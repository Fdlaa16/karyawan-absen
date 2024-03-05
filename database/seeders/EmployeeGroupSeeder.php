<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeGroup = [
            [
                'name' => 'Admin',
                'created_at' => now(),
            ],
            [
                'name' => 'Karyawan A',
                'created_at' => now(),
            ],
            [
                'name' => 'Karyawan B',
                'created_at' => now(),
            ],
        ];
    
        DB::table('employee_groups')->insert($employeeGroup);
    }
}
