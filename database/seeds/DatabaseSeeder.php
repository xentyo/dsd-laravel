<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MovementTypesTableSeeder::class);
        $this->call(MetricsTableSeeder::class);
        $this->call(ItemsTableSeeder::class);
    }
}
