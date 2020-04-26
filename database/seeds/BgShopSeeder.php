<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BgShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('bg_shops')->truncate();

        $file = base_path().'/database/seeds/csvs/bgshop.csv';
        $csvData = file_get_contents($file);
        $rows = array_map('str_getcsv',explode("\n",$csvData));
        $header = array_shift($rows);

        foreach ($rows as $row){
            $row = array_combine($header,$row);
            DB::table('bg_shops')->insert([
                'user_id'=>$row['user_id'],
                'agent_id'=>$row['agent_id'],
                'shop_name'=>$row['shop_name'],
                'opening_time'=>$row['opening_time'],
                'closing_time'=>$row['closing_time'],
                'is_verified'=>$row['is_verified'],
                'credit'=> $row['credit'],
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ]);
        };

        Schema::enableForeignKeyConstraints();
    }
}
