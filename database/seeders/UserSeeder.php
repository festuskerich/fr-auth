<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'kimtai',
            'last_name' => 'festus',
            'msisdn' => '254725850798',
            'email' => 'festuskerich@gmail.com',
            'password' => Hash::make('#12345679'),
        ]);
    }
}
