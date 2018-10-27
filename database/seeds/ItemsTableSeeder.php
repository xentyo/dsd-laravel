<?php

use Illuminate\Database\Seeder;
use App\Item;
use Stevebauman\Inventory\Models\Inventory;
use Stevebauman\Inventory\Models\Metric;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = File::get('database/seeds/scripts/data/materials.json');
        $items = [];
        foreach (json_decode($file) as $key => $value) {
            if ($key > 0) {
                $items[] = ucfirst(mb_strtolower($value->name));
            }
        }

        $metricPiece = Metric::where('symbol', 'pz')->first();
        $metricPackage = Metric::where('symbol', 'pkg')->first();
        foreach ($items as $key => $name) {
            $inventory = new Inventory([
                'name' => $name,
                'metric_id' => $metricPackage->id
            ]);
            $inventory->save();

            try {
                $item = new Item([
                    'name' => $name
                ]);
                $item->inventory_id = $inventory->id;
                $item->metric_id = $metricPiece->id;
                $item->save();
            } catch (PDOException $ex) {
            }
        }
    }
}
