<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('agents')->truncate();
        DB::table('agents')->insert(
            [
                [
                    'user_id'=>12,
                    'salary'=>15000,
                    'qualification'=>'FA',
                    'date_of_joining'=>Carbon::now(),
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ],
                [
                    'user_id'=>13,
                    'salary'=>12000,
                    'qualification'=>'I.Com',
                    'date_of_joining'=>Carbon::now(),
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ],
                [
                    'user_id'=>14,
                    'salary'=>10000,
                    'qualification'=>'Metric',
                    'date_of_joining'=>'2019-05-15',
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ],
            ]
        );
        Schema::enableForeignKeyConstraints();
    }
}
