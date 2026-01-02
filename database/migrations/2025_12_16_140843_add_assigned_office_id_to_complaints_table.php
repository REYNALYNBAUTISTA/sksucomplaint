<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            // Add the missing column: The office the ADMIN ASSIGNS the complaint to.
            $table->foreignId('assigned_office_id')->nullable()->after('target_office_id')->constrained('offices')->onDelete('set null');

            // We should also add the admin_remarks column if it was missed:
            $table->text('admin_remarks')->nullable()->after('assigned_office_id');
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['assigned_office_id']);
            // Then drop the columns
            $table->dropColumn(['assigned_office_id', 'admin_remarks']);
        });
    }
};
