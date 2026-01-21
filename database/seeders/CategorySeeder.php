<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $electronics = Category::create(['name' => 'Electronics']);
        $fashion = Category::create(['name' => 'Fashion']);
        $books = Category::create(['name' => 'Books']);

        // فئات فرعية
        Category::create(['name' => 'Mobile Phones', 'parent_id' => $electronics->id]);
        Category::create(['name' => 'Laptops', 'parent_id' => $electronics->id]);
        Category::create(['name' => 'Men Clothing', 'parent_id' => $fashion->id]);
        Category::create(['name' => 'Women Clothing', 'parent_id' => $fashion->id]);
    }
}
