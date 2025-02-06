<?php

namespace Database\Seeders;

use App\Models\AccommodationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccommodationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $type = new AccommodationType();
        $type->name = 'Un alojamiento entero';
        $type->description = 'Los huespedes tendrán todo el alojamiento para ellos.';   
        $type->save();

        $type = new AccommodationType();
        $type->name = 'Una habitación';
        $type->description = 'Los huespedes tendrán una habitación privada en un alojamiento, ademas de acceso a espacios compartidos.';
        $type->save();

        $type = new AccommodationType();
        $type->name = 'Una habitación compartida';
        $type->description = 'Los huespedes compartirán una habitación con otros huéspedes en un hostal gestionado por personal especializado.';
        $type->save();
        
    }
}
