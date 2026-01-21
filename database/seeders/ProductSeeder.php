<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $mobileCategory = Category::where('name', 'Mobile Phones')->first();
        $laptopCategory = Category::where('name', 'Laptops')->first();
        $menClothing = Category::where('name', 'Men Clothing')->first();
        $books = Category::where('name', 'Books')->first();

        Product::create([
            'name' => 'iPhone 14',
            'description' => 'Latest Apple iPhone 14 smartphone',
            'price' => 1200,
            'stock' => 10,
            'image_url' => 'https://example.com/iphone14.jpg',
            'category_id' => $mobileCategory->id
        ]);

        Product::create([
            'name' => 'MacBook Pro',
            'description' => 'Apple MacBook Pro 16-inch',
            'price' => 2500,
            'stock' => 5,
            'image_url' => 'https://example.com/macbookpro.jpg',
            'category_id' => $laptopCategory->id
        ]);

        Product::create([
            'name' => 'Men T-Shirt',
            'description' => 'Cotton T-Shirt for men',
            'price' => 20,
            'stock' => 50,
            'image_url' => 'https://example.com/men-tshirt.jpg',
            'category_id' => $menClothing->id
        ]);

        Product::create([
            'name' => 'Harry Potter Book',
            'description' => 'Harry Potter and the Sorcerer\'s Stone',
            'price' => 15,
            'stock' => 30,
            'image_url' => 'https://example.com/harrypotter.jpg',
            'category_id' => $books->id
        ]);
    }
}
