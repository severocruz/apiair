<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Describe;

class DescribeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $describe = new Describe();
        $describe->describe = 'Casa';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Departamento';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Granero';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Cama y desayuno';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Barco';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Cabaña';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Casa rodante';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Casa particular';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Castillo';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Cueva';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Contenedor';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Casa griega';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Dammuso';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Domo';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Casa enterrada';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Granja';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Casa de huéspedes';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Hotel';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Casa flotante';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Kezhan';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Minsu';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Riad';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Ryokanpl:ryokan';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Cabaña de pastor';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Tienda de campaña';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Minicasa';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Torre';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Casa del Arbol';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Trullo';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Molino de viento';
        $describe->save();

        $describe = new Describe();
        $describe->describe = 'Yurta';
        $describe->save();

    }
}
