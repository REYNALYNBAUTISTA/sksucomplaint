<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplaintStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        $statuses = [
            // Status ID 1
            ['name' => 'Pending (Admin Review)', 'color_class' => 'bg-yellow-100 text-yellow-800'],
            // Status ID 2
            ['name' => 'Addressed (Sent to Office)', 'color_class' => 'bg-blue-100 text-blue-800'],
            // Status ID 3
            ['name' => 'Action Taken (Admin Review)', 'color_class' => 'bg-purple-100 text-purple-800'],
            // Status ID 4 - FINAL STATUS
            ['name' => 'Resolved (Action Approved)', 'color_class' => 'bg-green-100 text-green-800'],
            // Status ID 5 (Optional: If complaint is rejected/invalidated)
            ['name' => 'Invalid/Closed', 'color_class' => 'bg-gray-100 text-gray-800'],
        ];

        foreach ($statuses as $status) {
            DB::table('complaint_statuses')->insertOrIgnore($status);
        }
    }
}
