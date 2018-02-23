<?php
namespace database;

use Illuminate\Database\Seeder;
use VendasTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(VendasTableSeeder::class);
    }
}
