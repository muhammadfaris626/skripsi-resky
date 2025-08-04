<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'employee_number' => 'sales1',
                'name' => 'Sales 1',
                'position' => 'Sales'
            ],
            [
                'employee_number' => 'sales2',
                'name' => 'Sales 2',
                'position' => 'Sales'
            ],
            [
                'employee_number' => 'sales3',
                'name' => 'Sales 3',
                'position' => 'Sales'
            ],
        ];

        foreach ($data as $key => $value) {
            Employee::create($value);
        }
    }
}
