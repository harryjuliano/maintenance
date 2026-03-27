<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rca_capas', function (Blueprint $table) {
            $table->id();
            $table->string('rca_no')->unique();
            $table->foreignId('work_order_id')->nullable()->constrained()->nullOnDelete();
            $table->text('problem_statement');
            $table->text('root_cause');
            $table->text('corrective_action')->nullable();
            $table->text('preventive_action')->nullable();
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('due_date')->nullable();
            $table->enum('status', ['open', 'in_progress', 'verified', 'closed'])->default('open');
            $table->timestamps();
        });

        Schema::create('kpi_reliabilities', function (Blueprint $table) {
            $table->id();
            $table->string('kpi_code')->unique();
            $table->date('kpi_period');
            $table->foreignId('asset_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('mtbf_hours', 10, 2)->default(0);
            $table->decimal('mttr_hours', 10, 2)->default(0);
            $table->decimal('availability_pct', 5, 2)->default(0);
            $table->unsignedInteger('breakdown_count')->default(0);
            $table->decimal('emergency_wo_ratio', 5, 2)->default(0);
            $table->decimal('pm_compliance', 5, 2)->default(0);
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamps();
        });

        Schema::create('planner_calendars', function (Blueprint $table) {
            $table->id();
            $table->string('plan_no')->unique();
            $table->string('title');
            $table->date('plan_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->foreignId('asset_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('work_order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('plan_type', ['pm', 'cm', 'inspection', 'calibration', 'project']);
            $table->enum('priority', ['low', 'medium', 'high', 'emergency'])->default('medium');
            $table->enum('status', ['scheduled', 'in_progress', 'done', 'cancelled'])->default('scheduled');
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('mobile_technician_flows', function (Blueprint $table) {
            $table->id();
            $table->string('flow_no')->unique();
            $table->foreignId('work_order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('technician_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('checkin_at')->nullable();
            $table->dateTime('checkout_at')->nullable();
            $table->text('action_taken');
            $table->text('sparepart_used')->nullable();
            $table->text('verification_note')->nullable();
            $table->enum('status', ['assigned', 'on_the_way', 'on_site', 'working', 'completed', 'verified'])->default('assigned');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobile_technician_flows');
        Schema::dropIfExists('planner_calendars');
        Schema::dropIfExists('kpi_reliabilities');
        Schema::dropIfExists('rca_capas');
    }
};
