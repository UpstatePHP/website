<?php

use Faker\Factory as Faker;
use Carbon\Carbon;
use UpstatePHP\Website\Models;

class EventsTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();

        $venues = Models\Venue::all();

        foreach(range(1, 10) as $index)
        {
            $begins = $faker->dateTimeBetween('+'.$index.' months', '+'.($index+1).' months');

            $event = Models\Event::create([
                'title' => $faker->sentence(rand(4,6)),
                'description' => $faker->text,
                'registration_link' => $faker->url,
                'begins_at' => $begins->format('Y-m-d H:i:s'),
                'ends_at' => Carbon::instance($begins)->addHours(2),
            ]);

            if (rand(0, 1)) {
                $venues->random()->events()->save($event);
            }
        }
    }

}