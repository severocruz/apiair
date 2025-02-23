<?php

namespace App\Http\Controllers\Accommodation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\AccommodationDiscount;
class AccommodationDiscountController extends Controller
{
    //
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'accommodation_id' => 'required',
                
            ]);

            if ($validator->fails()) {
            
                return response()->json(
                    ['message' => 'Error en la validación de datos',
                            'errors' => $validator->errors(),
                           'status'  => '400'], 
                    400);
                    
            }
            $accommodationPrice = AccommodationDiscount::create($request->all());
            return response()->json(
                ['data'=>$accommodationPrice,
                       'status'    => true,
                       'message' => 'precio registrado'],
               200);
            }catch (Exception $e) {
                
                Log::error('Error al registrar la descuento: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
                return response()->json(
                    [ 'data'=>null,
                            'message' => 'Error al registrar el descuento',
                           'status'   => false], 
                    500);
            }

    }

    public function update(Request $request, AccommodationDiscount $accommodationPrice)
    {
        //
        try{
            $validator = Validator::make($request->all(), [
                //'accommodation_id' => '',
                // 'price_night'=>'numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
                // 'price_weekend'=>'numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
                // 'type'=>'string|min:3'
            ]);

            if ($validator->fails()) {
            //     Log::error('Error al validar el precio: ',
            // (array)$validator->errors());
            $data = ['message' => 'Error en la validación de datos',
            'errors' => $validator->errors(),
           'status'  => '400'];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $accommodationPriceUpdated = $accommodationPrice->update($request->all());
            $data = ['data'=>$accommodationPriceUpdated,
            'status'    => true,
            'message' => 'descuento actualizado'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                
                Log::error('Error al actualizar la descuento: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al actualizar la descuento',
                    'status'   => false];
                return response()->json(
                    $data, 
                    500);
            }	
    }
    public function showByAccommodation ($accommodationId)
    {
        //
        try {
            $accommodationPrices = AccommodationDiscount::where('accommodation_id','=',$accommodationId)
                                    ->get();
            if($accommodationPrices->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No existen descuentos para el Alojamiento',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationPrices,
                       'status'    => true,
                       'message' => 'descuentos encontrados'],
               200);


        } catch (Exception $e) {
            Log::error('Error al obtener los descuentos: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener los descuentos',
                       'status'   => false], 
                500);
        }

    }
    public function delete( $id)
    {
        //
        
        try{
            $accommodationPrice = AccommodationDiscount::find($id);
            if($accommodationPrice)
            {
             $accommodationPriceUpdated = $accommodationPrice->delete();
            }else{
                $accommodationPriceUpdated = false;
            }

            if (!$accommodationPriceUpdated) {
            $data = ['message' => 'No se pudo eliminar',
            'errors' => [],
           'status'  => '400'];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $data = ['data'=>$accommodationPriceUpdated,
            'status'    => true,
            'message' => 'descripcion eliminada'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                Log::error('Error al eliminar precio: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al eliminar descripción',
                    'status'   => false];
                return response()->json(
                    $data, 
                    500);
            }	
    }
}
