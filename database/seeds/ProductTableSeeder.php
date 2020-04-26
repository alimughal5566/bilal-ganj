<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('products')->truncate();

        $file = base_path() . '/database/seeds/csvs/products.csv';
        $csvData = file_get_contents($file);
        $rows = array_map('str_getcsv', explode("\n", $csvData));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $row = array_combine($header, $row);
            DB::table('products')->insert([
                'bgshop_id' => $row['bgshop_id'],
                'name' => $row['name'],
                'size' => $row['size'],
                'description' => $row['description'],
                'quantity' => $row['quantity'],
                'condition' => $row['condition'],
                'in_stock' => $row['in_stock'],
                'ucp' => $row['ucp'],
                'is_feature' => $row['is_feature'],
                'model' => $row['model'],
                'discount' => $row['discount'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        };

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
