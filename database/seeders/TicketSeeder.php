<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ticket::factory()->create([
            'movie_name' => fake()->name,
            'cost' => fake()->randomFloat(2,10, 100),
            't_cap' => 5,
            'c_cap' => 0,
        ]);
        Ticket::factory(5)->create();
    }
}
