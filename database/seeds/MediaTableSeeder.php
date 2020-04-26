<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('media')->truncate();

        $file = base_path().'/database/seeds/csvs/media.csv';
        $csvData = file_get_contents($file);
        $rows = array_map('str_getcsv',explode("\n",$csvData));
        $header = array_shift($rows);

        foreach ($rows as $row){
            $row = array_combine($header,$row);
            DB::table('media')->insert([
                'image' => $row['image'],
                'product_id' => $row['product_id'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        };

        Schema::enableForeignKeyConstraints();
    }
}
