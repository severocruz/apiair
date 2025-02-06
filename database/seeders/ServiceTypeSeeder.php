<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServiceType;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $type = new ServiceType();
        $type->name = 'Vistas panorámicas';
        $type->save();

        $type = new ServiceType();
        $type->name = 'Baño';
        $type->save();

        $type = new ServiceType();
        $type->name = 'Habitación y lavandería';
        $type->save();

        $type = new ServiceType();
        $type->name = 'Entretenimiento';
        $type->save();

        $type = new ServiceType();
        $type->name = 'Para Familias';
        $type->save();

        $type = new ServiceType();
        $type->name = 'Calefacción y Refrigeración';
        $type->save();

        $type = new ServiceType();
        $type->name = 'Seguridad en el alojamiento';
        $type->save();

        $type = new ServiceType();
        $type->name = 'Internet y oficina';
        $type->save();

        $type = new ServiceType();
        $type->name = 'Cocina y comedor';
        $type->save();

        $type = new ServiceType();
        $type->name = 'Caracteristicas de la ubicación ';
        $type->save();

        $type = new ServiceType();
        $type->name = 'Exterior';
        $type->save();

        $type = new ServiceType();
        $type->name = 'Estacionamiento e instalaciones';
        $type->save();

        $type = new ServiceType();
        $type->name = 'Servicios';
        $type->save();

    }
}
