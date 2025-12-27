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
        Schema::create('studenttransfers', function (Blueprint $table) {
        $table->id();
        $table->integer('student_id');
        $table->enum('type', ['نقل', 'ترحيل']); 
        $table->integer('from_grade_id')->nullable();
        $table->integer('from_section_id')->nullable();
        $table->integer('to_grade_id')->nullable();
        $table->integer('to_section_id')->nullable();
        $table->integer('year')->nullable();
        $table->text('reason')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studenttransfers');
    }

};
