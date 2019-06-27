<?php

use Illuminate\Database\Seeder;

class RebeccaReviewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\RebeccaReview::class, 20)->create();
    }
}
