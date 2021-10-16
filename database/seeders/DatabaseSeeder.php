<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Url;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         Url::factory(120)->create();
    }
}
