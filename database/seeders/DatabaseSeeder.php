<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            OfficeSeeder::class, // Must run first for foreign keys
            ComplaintStatusSeeder::class, // Must run second for complaint table
            UserSeeder::class, // Depends on OfficeSeeder
        ]);
    }
}
