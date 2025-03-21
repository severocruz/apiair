<?php

namespace App\Http\Controllers\Reserve;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\AccommodationAvailability;
class AccommodationAvailabilityController extends Controller
{
      //
      public function store(Request $request)
      {
          try{
              $validator = Validator::make($request->all(), [
                  'accommodation_id' => 'required',
                  'reserve_id' => 'required',  
                  'start_date'=> 'required',
                //   'end_date' => 'required',
                  'availability'=>'required',                  
              ]);
  
              if ($validator->fails()) {
              
                  return response()->json(
                      ['message' => 'Error en la validación de datos',
                              'errors' => $validator->errors(),
                             'status'  => '400'], 
                      400);
                      
              }
              $accommodationPrice = AccommodationAvailability::create($request->all());
              return response()->json(
                  ['data'=>$accommodationPrice,
                         'status'    => true,
                         'message' => 'fechas registradas'],
                 200);
              }catch (Exception $e) {
                  
                  Log::error('Error al registrar la fecha: '.$e->getMessage(),
              ['trace' => $e->getTraceAsString()]);
                  return response()->json(
                      [ 'data'=>null,
                              'message' => 'Error al registrar el fecha',
                             'status'   => false], 
                      500);
              }
  
      }
  
      public function update(Request $request, AccommodationAvailability $accommodationPrice)
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
              'message' => 'fecha actualizada'];
              return response()->json(
                  $data,
                 200);
              }catch (Exception $e) {
                  
                  Log::error('Error al actualizar la fecha: '.$e->getMessage(),
              ['trace' => $e->getTraceAsString()]);
              $data=[ 'data'=>null,
                      'message' => 'Error al actualizar la fecha',
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
              $accommodationPrices = AccommodationAvailability::where('accommodation_id','=',$accommodationId)
                                         ->where('status','=',true)
                                         ->get();
              if($accommodationPrices->isEmpty()){
                  return response()->json(
                      [
                              'data'=>[],
                              'message' => 'No existen fechas para el Alojamiento',
                             'status'    => false], 
                      200);
      
              }
              return response()->json(
                  ['data'=>$accommodationPrices,
                         'status'    => true,
                         'message' => 'fechas encontradas'],
                 200);
  
  
          } catch (Exception $e) {
              Log::error('Error al obtener fechas: '.$e->getMessage());
              return response()->json(
                  [ 'data'=>[],
                          'message' => 'Error al obtener fechas',
                         'status'   => false], 
                  500);
          }
  
      }
      public function delete( $id)
      {
          //
          
          try{
              $accommodationPrice = AccommodationAvailability::find($id);
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
              'message' => 'fecha eliminada'];
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
