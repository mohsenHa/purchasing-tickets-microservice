<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'first_name' => 'Mohsen',
            'last_name' => 'Haghgoo',
            'email' => 'mohsen.haghgoo@example.com',
        ]);
        User::factory(5)->create();


    }
}
