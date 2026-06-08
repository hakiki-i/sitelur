<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Owner',
            'email' => 'owner@peternakan.test',
            'password' => Hash::make('owner123'),
            'role' => 'owner'
        ]);
    }
}
