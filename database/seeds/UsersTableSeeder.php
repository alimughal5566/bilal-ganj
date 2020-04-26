<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    //
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();

        $file = base_path() . '/database/seeds/csvs/users.csv';
        $csvData = file_get_contents($file);
        $rows = array_map('str_getcsv', explode("\n", $csvData));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $row = array_combine($header, $row);
            DB::table('users')->insert([
                'type' => $row['type'],
                'name' => $row['name'],
                'address' => $row['address'],
                'email' => $row['email'],
                'latitude' => $row['latitude'],
                'longitude' => $row['longitude'],
                'password' => bcrypt('12345'),
                'contact_number' => $row['contact_number'],
                'is_active' => $row['is_active'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        };

        Schema::enableForeignKeyConstraints();
    }
}
