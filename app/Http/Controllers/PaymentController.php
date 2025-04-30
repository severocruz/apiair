<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Carbon\Carbon;
use Date;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;
use App\Models\Reserve;
use App\Helpers\PaymentUrl;
use InvalidArgumentException;

class PaymentController extends Controller
{
    public function HandleGeneratePaymentUrl($idReserva)
    {
        Log::info("Iniciando generación de la URL de pago");

        try {
            // 1. Validar que exista la reserva
            $reserve = Reserve::find($idReserva);
            if (!$reserve) {
                return response()->json([
                    'data' => null,
                    'message' => 'No existe la reserva',
                    'status' => false
                ], 404);
            }

            $monto = number_format($reserve->total_price, 2, '.', ''); // produce "1.00" (string)
            $monto = (float) $monto; // convierte "1.00" (string) → 1.0 (float)
            // 2. Preparar datos para el pago
            $data = [
                'companyId' => '95',
                'codigo'    => $reserve->id,
                'monto'     => $monto
            ];

            Log::info("Datos para el pago:", $data);
            // 3. Generar URL de pago
            $paymentUrl = PaymentUrl::url($data);
            // 4. Retornar respuesta exitosa
            return response()->json([
                'data' => $paymentUrl,
                'message' => 'URL de pago generada con éxito',
                'status' => true
            ]);

        } catch (InvalidArgumentException $e) {
            Log::error('Datos inválidos para pago: ' . $e->getMessage());
            return response()->json([
                'data' => null,
                'message' => 'Datos inválidos para pago: ' . $e->getMessage(),
                'status' => false
            ], 400);
        } catch (Exception $e) {
            Log::error("Error al generar la URL de pago: " . $e->getMessage());
            return response()->json([
                'data' => null,
                'message' => 'Error al generar la URL de pago: ' . $e->getMessage(),
                'status' => false
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        $payload = $request->getContent();
        $firmaRecibida = $request->header('X-VPAY-Signature');
        $claveSecreta = Config::get('services.vpay.webhook_secret');
        Log::info($claveSecreta);
        $firmaCalculada = hash_hmac('sha256', '', $claveSecreta);
        Log::info($firmaCalculada);
        //
        // Verificar si la firma calculada coincide con la firma recibida
        if (!hash_equals($firmaCalculada, $firmaRecibida)) {
            Log::warning('Firma inválida en webhook VPAY');
            return response()->json(['error' => 'Firma no válida'], 401);
        }

        $payment = new Payment();
        $payment->reserve_id = $request->input('codigo');
        $payment->mount = $request->input('monto');
        $payment->method = 'VPAY';// $request->input('method');
        $payment->reference = $request->input(key: 'transaccion');
        $payment->transaction_id = $request->input('codigo');// $request->input('transaction_id');
        $payment->transaction_at = Carbon::now(); // Fecha Actual
        $payment->save();

        $reserve = Reserve::find($payment->reserve_id);
        if($reserve){
            $total = Payment::where('reserve_id', $request->input('codigo'))->sum('mount');
            if ($total >= $reserve->total_price) {
                $reserve->state = 'Pagado';
                $reserve->save();
            }
        } else {
            Log::error("Reserva no encontrada para ID: {$payment->reserve_id}");
        }

        Log::info('VPAY Webhook recibido con firma válida:', $request->all());
        return response()->json([
            'message' => 'OK',
            'success' => true
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
