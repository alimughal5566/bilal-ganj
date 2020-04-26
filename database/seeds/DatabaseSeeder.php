<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(AgentSeeder::class);
        $this->call(BgShopSeeder::class);
        $this->call(RidersSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(CategoriesProductsSeeder::class);
        $this->call(MediaTableSeeder::class);

    }
}
