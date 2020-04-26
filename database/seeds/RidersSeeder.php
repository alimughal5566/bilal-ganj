<?php

use Illuminate\database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RidersSeeder extends Seeder
{
    /**
     * Run the datebase seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('riders')->truncate();

        DB::table('riders')->insert(
            [
                [
                    'user_id' => 15,
                    'status' => 'free',
                    'vehicle_type' => 'bike',
                    'vehicle_number' => 'LEV-6143',
                    'salary' => 12000,
                    'date_of_joining' => Carbon::now(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'user_id' => 16,
                    'status' => 'free',
                    'vehicle_type' => 'bike',
                    'vehicle_number' => 'LEV-6142',
                    'salary' => 12000,
                    'date_of_joining' => Carbon::now(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ], [
                'user_id' => 17,
                'status' => 'free',
                'vehicle_type' => 'loadingRickshaw',
                'vehicle_number' => 'LEV-6141',
                'salary' => 13000,
                'date_of_joining' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'user_id' => 18,
                'status' => 'free',
                'vehicle_type' => 'loadingRickshaw',
                'vehicle_number' => 'LEV-6140',
                'salary' => 13000,
                'date_of_joining' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'user_id' => 19,
                'status' => 'free',
                'vehicle_type' => 'pickup',
                'vehicle_number' => 'LEV-6144',
                'salary' => 15000,
                'date_of_joining' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'user_id' => 20,
                'status' => 'free',
                'vehicle_type' => 'pickup',
                'vehicle_number' => 'LEV-6145',
                'salary' => 15000,
                'date_of_joining' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            ]
        );
        Schema::enableForeignKeyConstraints();

    }
}
