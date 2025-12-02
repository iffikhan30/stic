<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected $connections = [
        'tech_mysql',
        'bill_mysql',
        'product_mysql',
        'general_mysql',
        'feedback_mysql',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach ($this->connections as $connection) {

            for ($i = 1; $i <= 10; $i++) {

                DB::connection($connection)->table('tickets')->insert([
                    'ticket_no' => strtoupper('BT-' . Str::random(8)),
                    'name'          => $faker->name(),
                    'email'         => $faker->email(),
                    'phone'         => $faker->phoneNumber(),
                    'subject'       => $faker->sentence(),
                    'message'       => $faker->paragraph(),
                    'status_id'        => $faker->randomElement(['1','2','3']),
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }

            echo "Seeded 10 tickets in database connection: {$connection}\n";
        }
    }
}
