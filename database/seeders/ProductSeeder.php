<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'cid' => 1,
            'product_name' => 'Pizza',
            'qty' => 10,
            'rate' => 299,
            'gst' => '5'
        ]);

        Product::create([
            'cid' => 1,
            'product_name' => 'Burger',
            'qty' => 10,
            'rate' => 399,
            'gst' => '5'
        ]);

        Product::create([
            'cid' => 2,
            'product_name' => 'Laptop',
            'qty' => 5,
            'rate' => 54999,
            'gst' => '18'
        ]);

        Product::create([
            'cid' => 3,
            'product_name' => 'T-Shirt',
            'qty' => 50,
            'rate' => 999,
            'gst' => '12'
        ]);

        Product::create([
            'cid' => 2,
            'product_name' => 'Keyboard',
            'qty' => 20,
            'rate' => 999,
            'gst' => '18'
        ]);

        Product::create([
            'cid' => 3,
            'product_name' => 'Sleeveless T-Shirt',
            'qty' => 100,
            'rate' => 599,
            'gst' => '12'
        ]);
    }
}
