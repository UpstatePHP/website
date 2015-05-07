<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        if (App::environment() === 'production') exit();

		Model::unguard();

        // Truncate all tables, except migrations
        $tables = DB::select('SHOW TABLES');
        $dbName = 'Tables_in_' . env('DB_DATABASE');
        foreach ($tables as $table) {
            if ($table->$dbName !== 'migrations') {
                DB::table($table->$dbName)->truncate();
                $this->command->info('Truncated ' . $table->$dbName);
            }
        }

        $this->call('EventsTableSeeder');
        $this->call('SponsorsTableSeeder');
		// $this->call('UserTableSeeder');
	}

}
