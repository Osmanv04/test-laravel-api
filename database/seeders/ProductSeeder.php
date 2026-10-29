<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currency;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usd = Currency::where('name', 'USD')->first();
        $eur = Currency::where('name', 'EUR')->first();
        $ves = Currency::where('name', 'VES')->first();
 
        Product::create([
            'name' => 'Laptop HP',
            'description' => 'Laptop HP Pavilion 15.6" Intel i5 8GB RAM 256GB SSD',
            'price' => 799.99,
            'currency_id' => $usd->id,
            'tax_cost' => 64.00,
            'manufacturing_cost' => 450.00,
        ]);
 
        Product::create([
            'name' => 'Smartphone Samsung',
            'description' => 'Samsung Galaxy S24 128GB Black',
            'price' => 899.00,
            'currency_id' => $eur->id,
            'tax_cost' => 72.00,
            'manufacturing_cost' => 400.00,
        ]);
 
        Product::create([
            'name' => 'Tablet iPad',
            'description' => 'Apple iPad Air 64GB WiFi',
            'price' => 500.00,
            'currency_id' => $ves->id,
            'tax_cost' => 40.00,
            'manufacturing_cost' => 250.00,
        ]);
    }
}
