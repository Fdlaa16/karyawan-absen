<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shifts = [
            [
                'name' => 'Shift 1',
                'created_at' => now(),
            ],
            [
                'name' => 'Shift 2',
                'created_at' => now(),
            ],
            [
                'name' => 'Shift 3',
                'created_at' => now(),
            ],
        ];
    
        DB::table('shifts')->insert($shifts);
    }
    
}
