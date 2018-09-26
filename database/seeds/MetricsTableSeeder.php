<?php

use Illuminate\Database\Seeder;
use Stevebauman\Inventory\Models\Metric;

class MetricsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metrics = [
            'm' => 'Metre',
            'kg' => 'Kilogram',
            'pkg' => 'Package',
            'pz' => 'Piece',
        ];

        foreach ($metrics as $symbol => $name) {
            $metric = new Metric();
            $metric->name = $name;
            $metric->symbol = $symbol;
            $metric->save();
        }
    }
}
