<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fees', function (Blueprint $table) {
            // Add academic_term_id FK
            $table->foreignId('academic_term_id')->nullable()->after('program_id')->constrained('academic_terms')->onDelete('cascade');
            // Add student_id FK (nullable - for student-specific fees)
            $table->foreignId('student_id')->nullable()->after('academic_term_id')->constrained('students')->onDelete('cascade');
        });


        Schema::table('fees', function (Blueprint $table) {
            $table->dropColumn('academic_year');
        });
    }

    public function down(): void
    {
        Schema::table('fees', function (Blueprint $table) {
            $table->text('academic_year')->nullable()->after('group');
            $table->dropForeign(['student_id']);
            $table->dropColumn('student_id');
            $table->dropForeign(['academic_term_id']);
            $table->dropColumn('academic_term_id');
        });
    }
};
