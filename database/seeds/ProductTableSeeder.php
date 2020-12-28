<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $limit = 5;

        for ($i = 0; $i < $limit; $i++) {
            DB::table('tbl_product')->insert([
                'shop_id' => '5',
                'product_name' => $faker->name,
                'product_quantity' => $faker->numberBetween(4, 40),
                'product_sold' => $faker->numberBetween(5, 20),
                'product_slug' => $faker->name,
                'category_id' => $faker->numberBetween(1, 8),
                'brand_id' => $faker->numberBetween(1, 8),
                'product_desc' => $faker->name,
                'product_content' => $faker->name,
                'product_price' => $faker->numberBetween(0, 5000000),
                'product_image' => $faker->image(),
                'product_status' => '0',
            ]);
        }
    }
}
