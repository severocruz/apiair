<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Aspect;
class AspectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $description = new Aspect();
        $description->description = 'Tranquilo';
        $description->describe_id = 1;
        $description->save();

        $description = new Aspect();
        $description->description = 'Excepcional';
        $description->describe_id = 1;
        $description->save();

        $description = new Aspect();
        $description->description = 'Familiar';
        $description->describe_id = 1;
        $description->save();

        $description = new Aspect();
        $description->description = 'Elegante';
        $description->describe_id = 1;
        $description->save();

        $description = new Aspect();
        $description->description = 'Central';
        $description->describe_id = 1;
        $description->save();

        $description = new Aspect();
        $description->description = 'Espacioso';
        $description->describe_id = 1;
        $description->save();

    }
}
