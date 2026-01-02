<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Office;
use App\Enums\Roles;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

        public function run(): void
{
    // Fetch the necessary office ID
    $saoOffice = Office::where('name', 'Student Affairs Office (SAO)')->first();

    // 1. Super Admin User (Role: super-admin)
    User::firstOrCreate(['email' => 'superadmin@sksu.edu.ph'], [
        'id_number' => 'SKSU-9999',
        'name' => 'System Super Admin',
        'password' => Hash::make('password'),
        'role_id' => Roles::SUPER_ADMIN->value, // <--- CORRECTED
        'office_id' => null,
    ]);

    // 2. Admin User (Role: admin) - Handles routing and approval
    User::firstOrCreate(['email' => 'admin@sksu.edu.ph'], [
        'id_number' => 'ADM-001',
        'name' => 'Complaints Desk Admin',
        'password' => Hash::make('password'),
        'role_id' => Roles::ADMIN->value, // <--- CORRECTED
        'office_id' => null,
    ]);

    // 3. Office Personnel User (Role: office) - Tied to an Office
    if ($saoOffice) {
        User::firstOrCreate(['email' => 'office@sksu.edu.ph'], [
            'id_number' => 'SAO-001',
            'name' => 'SAO Personnel',
            'password' => Hash::make('password'),
            'role_id' => Roles::OFFICE_PERSONNEL->value, // <--- CORRECTED
            'office_id' => $saoOffice->id,
        ]);
    }

    // 4. Student User (Role: student)
    User::firstOrCreate(['email' => 'student@sksu.edu.ph'], [
        'id_number' => '2023-54321',
        'name' => 'Maria Student',
        'password' => Hash::make('password'),
        'role_id' => Roles::STUDENT->value, // <--- CORRECTED
        'office_id' => null,
    ]);
}

}
