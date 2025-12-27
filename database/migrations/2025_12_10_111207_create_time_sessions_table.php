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
        Schema::create('time_sessions', function (Blueprint $table) {
            $table->id();
            $table->integer('timetable_id');
            $table->enum('day', ['السبت','الاحد','الاثنين','الثلاثاء','الاريعاء','الخميس']);
            $table->time('start_time');
            $table->time('end_time');
          
            $table->integer('subject_id');
            $table->integer('teacher_id');
            $table->integer('section_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_sessions');
    }
};
