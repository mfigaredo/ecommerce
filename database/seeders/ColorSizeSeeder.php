<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;

class ColorSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = Size::all();
        foreach($sizes as $size) {
            $size->colors()
                ->attach([
                    1 => ['quantity' => mt_rand(10,20)], 
                    2 => ['quantity' => mt_rand(10,20)], 
                    3 => ['quantity' => mt_rand(10,20)], 
                    4 => ['quantity' => mt_rand(10,20)],
                ]);
        }
    }
}
