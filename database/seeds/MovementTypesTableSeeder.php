<?php

use Illuminate\Database\Seeder;
use App\MovementType;

class MovementTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['item', 'kit'];

        foreach ($types as $key => $type) {
            $movementType = new MovementType(['name' => $type]);
            $movementType->save();
        }
    }
}
