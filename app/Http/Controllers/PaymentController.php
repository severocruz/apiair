<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Carbon\Carbon;
use Date;
use DateTime;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;
use App\Models\Reserve;

class PaymentController extends Controller
{
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
        $firmaCalculada = hash_hmac('sha256', $payload, $claveSecreta);
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
