<?php

use Illuminate\Database\Seeder;
use Laracasts\TestDummy\Factory as TestDummy;

class EventsTableSeeder extends Seeder
{
    public function run()
    {
        TestDummy::times(20)->create('UpstatePHP\Website\Domain\Events\Event');
    }

}
