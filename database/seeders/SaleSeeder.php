<?php

namespace Database\Seeders;

use App\Models\History;
use App\Models\Sale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'sale_date' => '2024-09-02',
                'amount' => '10000000',
                'target_amount' => '50000000',
                'employee_id' => 1,
            ],
            [
                'sale_date' => '2024-09-15',
                'amount' => '35000000',
                'target_amount' => '50000000',
                'employee_id' => 1,
            ]
        ];

        foreach ($data as $key => $value) {
            Sale::create($value);
        }

        $history = [
            [
                'sale_id' => 1,
                'target_id' => 1,
                'achieved' => 0
            ],
            [
                'sale_id' => 2,
                'target_id' => 1,
                'achieved' => 0
            ],
        ];

        foreach ($history as $key => $value) {
            History::create($value);
        }
    }
}
