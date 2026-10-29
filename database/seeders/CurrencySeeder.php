<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Currency::create([
            'name' => 'USD',
            'symbol' => '$',
            'exchange_rate' => 1.0,
        ]);
        
        Currency::create([
            'name' => 'EUR',
            'symbol' => '€',
            'exchange_rate' => 0.92,
        ]);
        
        Currency::create([
            'name' => 'VES',
            'symbol' => 'Bs',
            'exchange_rate' => 888.1183,
        ]);
    }
}
