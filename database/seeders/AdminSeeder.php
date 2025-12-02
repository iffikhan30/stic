<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('admins')->insert([
            'name' => 'Super Admin',
            'email' => 'jack@admin.com',
            'password' => Hash::make('baabooEuro'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
