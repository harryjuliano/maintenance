<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('calibration_supports', function (Blueprint $table) {
            $table->id();
            $table->string('calibration_no')->unique();
            $table->foreignId('asset_id')->nullable()->constrained()->nullOnDelete();
            $table->string('checklist_name');
            $table->string('standard_reference')->nullable();
            $table->date('scheduled_at');
            $table->date('performed_at')->nullable();
            $table->date('next_due_at')->nullable();
            $table->enum('status', ['planned', 'in_progress', 'completed', 'overdue', 'cancelled'])->default('planned');
            $table->enum('result', ['pending', 'pass', 'fail'])->default('pending');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calibration_supports');
    }
};
