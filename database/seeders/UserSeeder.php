<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Nandani',
            'email' => 'nandani@gnmail.com',
            'password' => bcrypt('password'),
        ]);

        Contact::create([
            'user_id' => 1,
            'phone_no' => '7879203349',
            'address' => 'Bangalore',
        ]);
    }
}
