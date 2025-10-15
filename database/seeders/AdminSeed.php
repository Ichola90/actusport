<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $password = "infoflashsport2025";

        DB::table('users')->insert([
            'name' => 'infoflashsport',
            'email' => 'contact@infoflashsport.com',
            'password' => Hash::make($password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
