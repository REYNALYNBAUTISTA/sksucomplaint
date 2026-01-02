<?php

use App\Enums\Roles;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // --- ADD THE MISSING ID_NUMBER COLUMN ---
            $table->string('id_number', 20)->unique()->after('id')->nullable();

            // Add the role column as an integer (Foreign ID replacement/simple column)
            // This aligns with your app's logic that checks $user->role_id
            $table->unsignedBigInteger('role_id')->default(Roles::STUDENT->value)->after('password');

            // Add the foreign key for the office
            $table->foreignId('office_id')->nullable()->after('role_id')->constrained()->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['office_id']);
            // Drop all added columns
            $table->dropColumn(['office_id', 'role_id', 'id_number']);
        });
    }
};
