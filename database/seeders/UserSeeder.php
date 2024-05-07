<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Muhamad Syahrul Ramadhan',
            'email' => 'msyahrulr12@gmail.com',
            'email_verified_at' => new \DateTime(),
            'password' => bcrypt('admin123'),
        ]);
    }
}
