<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Agent;

class ClientsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Create 20 clients
        $clients = Client::factory()->count(20)->create();

        // Create random number of agents between 1-5 for each client
        foreach ($clients as $client) {
            Agent::factory()->count(rand(1, 5))->create(['client_id' => $client->id]);
        }
    }
}
