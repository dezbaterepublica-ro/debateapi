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
        $this->call(CountiesCitiesSeeder::class);
        $this->call(AuthoritiesSeeder::class);
        $this->call(DebatesSeeder::class);
    }
}
