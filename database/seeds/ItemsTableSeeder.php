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
        $items = ['AGUJAS', 'CANULAS', 'MASCARILLAS', 'JERINGAS', 'CATETERES', 'GUANTES', 'GABACHAS', 'PRESERVATIVOS', 'SONDAS', 'TUBOS', 'PINZAS', 'ADHESIVOS', 'APÓSITOS', 'GASAS', 'HUATAS', 'VENDAS', 'RESUCITADORES', 'NYLON', 'POLIESTERES', 'POLIPROPILENOS', 'DIALIZADORES', 'IMPLANTES', 'LENTES', 'TROCARS', 'INJERTOS', 'VÁLVULAS'];
        foreach ($items as $key => $name) $items[$key] = ucfirst(ucwords($name));
        $metricPiece = Metric::where('symbol', 'pz')->first();
        $metricPackage = Metric::where('symbol', 'pkg')->first();
        foreach ($items as $key => $name) {
            $inventory = new Inventory([
                'name' => $name,
                'metric_id' => $metricPackage->id
            ]);
            $inventory->save();

            $item = new Item([
                'name' => $name
            ]);
            $item->inventory_id = $inventory->id;
            $item->metric_id = $metricPiece->id;
            $item->save();
        }
    }
}
