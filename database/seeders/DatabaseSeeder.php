<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        DB::table('users')->insert([
            'first_name' => 'Ali',
            'email' => 'test@gmail.com',
            'password' => Hash::make('12345'),
            'city' => 'Sarawak',
            'dob' => Carbon::parse('2000-01-01'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('events')->insert([
            'event_name' => 'Virtual Half Marathon',
            'no_of_participants' => 0,
            'start' => Carbon::now()->format('Y-m-d H:i:s'),
            'end' => Carbon::now()->format('Y-m-d H:i:s'),
            'registration_start' => Carbon::now()->format('Y-m-d H:i:s'),
            'registration_end' => Carbon::now()->format('Y-m-d H:i:s'),
            'description' => "Come join us!",
            'fee_5km' => 15,
            'fee_10km' => 25,
            'fee_21km' => 35,
            'fee_42km' => 45,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('events')->insert([
            'event_name' => 'Spartan Virtual Marathon',
            'no_of_participants' => 0,
            'start' => Carbon::now()->format('Y-m-d H:i:s'),
            'end' => Carbon::now()->format('Y-m-d H:i:s'),
            'registration_start' => Carbon::now()->format('Y-m-d H:i:s'),
            'registration_end' => Carbon::now()->format('Y-m-d H:i:s'),
            'description' => "Come join us!",
            'fee_5km' => 15,
            'fee_10km' => 25,
            'fee_21km' => 35,
            'fee_42km' => 45,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);


    }
}
