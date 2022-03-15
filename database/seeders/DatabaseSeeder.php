<?php

namespace Database\Seeders;

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
        /* \App\Models\User::factory(5)->create(); */
        /* \App\Models\Type_Mouvement::factory(2)->create(); */
        /* \App\Models\Type_Ressource::factory(3)->create(); */
        /* \App\Models\Mouvement::factory(15)->create(); */
        \App\Models\Mouvement::factory(15)->create();
    }
}