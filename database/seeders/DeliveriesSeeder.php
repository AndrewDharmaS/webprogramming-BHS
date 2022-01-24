<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('deliveries')->insert([
            'name' => "Instant (est. Today)",
        ]);
        DB::table('deliveries')->insert([
            'name' => "Next Day (Est. Tomorrow)",
        ]);
        DB::table('deliveries')->insert([
            'name' => "Regular (Est. Tomorrow/Two Day)",
        ]);
    }
}
