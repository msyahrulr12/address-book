<?php

namespace Database\Seeders;

use App\Models\AddressBook;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class AddressBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AddressBook::create([
            'code' => Str::random(25),
            'name' => 'Guest',
            'address' => 'Kp. Bahagia Sejahtera',
            'phone_number' => '0865434567654',
            'status' => true,
            'description' => 'Seorang tamu',
        ]);
    }
}
