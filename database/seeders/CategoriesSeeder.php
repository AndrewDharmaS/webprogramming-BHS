<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => "Sintesis",
        ]);
        DB::table('categories')->insert([
            'name' => "Staples",
        ]);
        DB::table('categories')->insert([
            'name' => "Busa Foam Kasur",
        ]);
        DB::table('categories')->insert([
            'name' => "Kaos",
        ]);
    }
}
