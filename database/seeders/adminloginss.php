<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admins;


class adminloginss extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admins::create([
            'name' => 'Admin',
            'email' => 'vinodchoudhary14012006@gmail.com',
            'password' => '123456',
            'phone' => 7849959879,
        ]);
    }
}
