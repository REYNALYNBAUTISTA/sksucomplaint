<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();

            // Foreign Key to the Student who filed the complaint
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('subject');
            $table->text('description');
            $table->string('file_path')->nullable(); // For student's optional evidence

            // 1. Foreign Key to the Office the complaint is directed to (Student's Choice)
            $table->foreignId('target_office_id')->constrained('offices')->onDelete('cascade');



            // Foreign Key to the current status (Pending, Addressed, Resolved, etc.)
            $table->foreignId('current_status_id')->constrained('complaint_statuses');


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
