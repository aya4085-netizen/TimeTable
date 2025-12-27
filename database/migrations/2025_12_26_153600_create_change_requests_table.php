<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('change_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('time_session_id')->constrained('time_sessions')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();

            // من باب التسهيل في الفلترة/العرض
            $table->foreignId('timetable_id')->constrained('timetables')->cascadeOnDelete();

            // مقترح التغيير (اختياري)
            $table->enum('requested_day', ['السبت','الاحد','الاثنين','الثلاثاء','الاريعاء','الخميس'])->nullable();
            $table->time('requested_start_time')->nullable();
            $table->time('requested_end_time')->nullable();

            $table->text('reason'); // سبب الطلب (ضروري)

            $table->enum('status', ['pending','approved','rejected'])->default('pending');

            // قرار المشرف
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('response_note')->nullable();
            $table->timestamp('processed_at')->nullable();

            $table->timestamps();

            $table->index(['status']);
            $table->index(['timetable_id']);
            $table->index(['teacher_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('change_requests');
    }
};
