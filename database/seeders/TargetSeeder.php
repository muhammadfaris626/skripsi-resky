<?php

namespace Database\Seeders;

use App\Models\Target;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'period' => '2024-09',
                'amount' => '50000000'
            ],
            [
                'period' => '2024-10',
                'amount' => '65000000'
            ],
            [
                'period' => '2024-11',
                'amount' => '78000000'
            ],
            [
                'period' => '2024-12',
                'amount' => '125000000'
            ],
        ];

        foreach ($data as $key => $value) {
            Target::create($value);
        }
    }
}
