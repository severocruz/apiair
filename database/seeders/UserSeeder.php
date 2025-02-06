<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user= new User();
        $user->name = 'Juan Carlos';
        $user->lastname = 'Bueno';
        $user->email = 'juan@mail.com';
        $user->password=bcrypt('1234567');
        $user->save();
    }
}
