<?php

use Illuminate\Database\Seeder;

use App\MovementType;

class MovementTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'item' => 'When only one item it was dispensed', 
            'kit' => 'When a group of items from a kit was dispensed in a kit or as a kit'
        ];

        foreach ($types as $name => $description) {
            $movementType = new MovementType([
                'name' => $name,
                'description' => $description
            ]);
            $movementType->save();
        }
    }
}
