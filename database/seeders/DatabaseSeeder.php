<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'jford',
            'email' => 'jford@gmail.com',
            'password' => bcrypt('test123'),
        ]);

        // Call the clients seeder
        $this->call(ClientsTableSeeder::class);
    }
}
