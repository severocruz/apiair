<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Description;
class DescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $description = new Description();
        $description->description = 'Tranquilo';
        $description->describe_id = 1;
        $description->save();

        $description = new Description();
        $description->description = 'Excepcional';
        $description->describe_id = 1;
        $description->save();

        $description = new Description();
        $description->description = 'Familiar';
        $description->describe_id = 1;
        $description->save();

        $description = new Description();
        $description->description = 'Elegante';
        $description->describe_id = 1;
        $description->save();

        $description = new Description();
        $description->description = 'Central';
        $description->describe_id = 1;
        $description->save();

        $description = new Description();
        $description->description = 'Espacioso';
        $description->describe_id = 1;
        $description->save();

    }
}
