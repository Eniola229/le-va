<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id'       => (string) Uuid::uuid4(),
            'name'     => 'Lev Av Admin',
            'email'    => 'admin@levav.com',
            'password' => Hash::make('changeme123'),
            'role'     => 'admin',
            'status'   => 'approved',
        ]);
    }
}
