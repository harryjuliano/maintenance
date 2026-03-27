<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('operational_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_no')->unique();
            $table->date('report_date');
            $table->enum('shift', ['shift_1', 'shift_2', 'shift_3', 'general']);
            $table->text('summary');
            $table->unsignedInteger('downtime_minutes')->default(0);
            $table->unsignedInteger('breakdown_count')->default(0);
            $table->decimal('pm_compliance', 5, 2)->default(0);
            $table->enum('status', ['draft', 'submitted', 'approved'])->default('draft');
            $table->foreignId('prepared_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operational_reports');
    }
};
