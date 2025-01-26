<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Electronics', 'description' => 'Devices and gadgets', 'parent_id' => null],
            ['name' => 'Computers', 'description' => 'Desktops, laptops, and accessories', 'parent_id' => 1], // Assuming 'Electronics' has ID 1
            ['name' => 'Phones', 'description' => 'Smartphones and accessories', 'parent_id' => 1],
            ['name' => 'Home Appliances', 'description' => 'Appliances for home use', 'parent_id' => null],
            ['name' => 'Refrigerators', 'description' => 'Various types of refrigerators', 'parent_id' => 4], // Assuming 'Home Appliances' has ID 4
            ['name' => 'Washing Machines', 'description' => 'Different types of washing machines', 'parent_id' => 4],
        ]);
    }
}
