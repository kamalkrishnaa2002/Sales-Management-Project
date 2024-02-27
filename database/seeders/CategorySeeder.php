<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category; // Make sure to include the correct namespace for Category model

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['category_name' => 'Food']);
        Category::create(['category_name' => 'Electronics']);
        Category::create(['category_name' => 'Apparel']);
    }
}
