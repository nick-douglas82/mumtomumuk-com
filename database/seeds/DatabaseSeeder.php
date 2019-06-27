<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(ReviewTableSeeder::class);
        // $this->call(EventTableSeeder::class);
        // $this->call(PlaceTableSeeder::class);
        // $this->call(SiteTableSeeder::class);
        $this->call(RebeccaReviewTableSeeder::class);
    }
}
