<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->constrained()->cascadeOnDelete();
            $table->string('code');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->unique(['plant_id', 'code']);
        });

        Schema::create('production_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->constrained()->cascadeOnDelete();
            $table->string('code');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->unique(['area_id', 'code']);
        });

        Schema::create('asset_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('maintenance_strategy_default')->nullable();
            $table->timestamps();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_code')->unique();
            $table->string('supplier_name');
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->unsignedInteger('lead_time_days')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->foreignId('supervisor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_category_id')->constrained()->restrictOnDelete();
            $table->foreignId('plant_id')->constrained()->restrictOnDelete();
            $table->foreignId('area_id')->constrained()->restrictOnDelete();
            $table->foreignId('production_line_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('parent_asset_id')->nullable()->constrained('assets')->nullOnDelete();
            $table->string('asset_code')->unique();
            $table->string('asset_name');
            $table->string('asset_number')->unique();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('manufacturer')->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->date('purchase_date')->nullable();
            $table->date('commissioning_date')->nullable();
            $table->unsignedInteger('useful_life_year')->nullable();
            $table->enum('criticality_level', ['low', 'medium', 'high', 'critical']);
            $table->decimal('risk_score', 8, 2)->nullable();
            $table->enum('maintenance_strategy', ['run_to_failure', 'preventive', 'predictive', 'condition_based']);
            $table->enum('status', ['active', 'standby', 'under_repair', 'retired'])->default('active');
            $table->string('location_note')->nullable();
            $table->string('capacity_spec')->nullable();
            $table->string('power_spec')->nullable();
            $table->unsignedInteger('standard_runtime_hours')->nullable();
            $table->string('photo')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('asset_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained()->cascadeOnDelete();
            $table->string('component_code');
            $table->string('component_name');
            $table->string('specification')->nullable();
            $table->enum('criticality_level', ['low', 'medium', 'high', 'critical']);
            $table->unsignedInteger('replace_interval')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->unique(['asset_id', 'component_code']);
        });

        Schema::create('asset_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained()->cascadeOnDelete();
            $table->enum('document_type', ['manual', 'drawing', 'sop', 'checklist', 'warranty', 'certificate', 'other']);
            $table->string('title');
            $table->string('file_path');
            $table->string('version')->nullable();
            $table->date('effective_date')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('work_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_no')->unique();
            $table->date('request_date');
            $table->time('request_time')->nullable();
            $table->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('department')->nullable();
            $table->foreignId('asset_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('area_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('production_line_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('request_type', ['breakdown', 'abnormality', 'inspection_followup', 'utility', 'facility', 'improvement']);
            $table->enum('urgency_level', ['low', 'medium', 'high', 'emergency']);
            $table->enum('impact_level', ['low', 'medium', 'high', 'critical']);
            $table->string('title');
            $table->text('description');
            $table->text('symptom')->nullable();
            $table->dateTime('breakdown_start_at')->nullable();
            $table->boolean('affects_production')->default(false);
            $table->decimal('estimated_production_loss', 15, 2)->nullable();
            $table->enum('status', ['draft', 'submitted', 'reviewed', 'approved', 'rejected', 'converted', 'closed'])->default('draft');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('reviewed_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('work_request_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_request_id')->constrained()->cascadeOnDelete();
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('failure_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('problem_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('cause_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('action_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('preventive_maintenance_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained()->cascadeOnDelete();
            $table->string('template_code')->unique();
            $table->string('template_name');
            $table->enum('maintenance_type', ['time_based', 'meter_based', 'condition_based', 'shutdown_based']);
            $table->unsignedInteger('frequency_value');
            $table->enum('frequency_unit', ['day', 'week', 'month', 'year', 'runtime_hour', 'cycle']);
            $table->unsignedInteger('estimated_duration_minutes');
            $table->string('skill_required')->nullable();
            $table->string('tool_required')->nullable();
            $table->text('standard_sparepart_kit')->nullable();
            $table->text('safety_note')->nullable();
            $table->boolean('loto_required')->default(false);
            $table->boolean('approval_required')->default(false);
            $table->boolean('active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('preventive_maintenance_template_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('preventive_maintenance_templates')->cascadeOnDelete();
            $table->unsignedInteger('sequence_no');
            $table->enum('item_type', ['check', 'clean', 'lubricate', 'tighten', 'measure', 'replace', 'test', 'record']);
            $table->string('item_name');
            $table->text('method')->nullable();
            $table->text('acceptance_criteria')->nullable();
            $table->string('standard_value')->nullable();
            $table->string('uom')->nullable();
            $table->boolean('is_required')->default(true);
            $table->timestamps();
        });

        Schema::create('inspection_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('inspection_type', ['daily_check', 'autonomous_maintenance', 'utility_check', 'safety_check', 'facility_check']);
            $table->string('code')->unique();
            $table->string('name');
            $table->enum('frequency_unit', ['day', 'week', 'month']);
            $table->unsignedInteger('frequency_value');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('inspection_template_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_template_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('sequence_no');
            $table->string('item_name');
            $table->enum('item_type', ['yes_no', 'number', 'text', 'photo']);
            $table->string('standard_value')->nullable();
            $table->decimal('min_value', 15, 4)->nullable();
            $table->decimal('max_value', 15, 4)->nullable();
            $table->string('uom')->nullable();
            $table->boolean('abnormal_trigger')->default(true);
            $table->timestamps();
        });

        Schema::create('spare_part_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('spare_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spare_part_category_id')->constrained()->restrictOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->string('part_code')->unique();
            $table->string('part_name');
            $table->string('part_number')->nullable();
            $table->string('brand')->nullable();
            $table->text('specification')->nullable();
            $table->string('unit');
            $table->enum('criticality_level', ['low', 'medium', 'high', 'critical']);
            $table->decimal('min_stock', 15, 4)->default(0);
            $table->decimal('max_stock', 15, 4)->default(0);
            $table->decimal('reorder_point', 15, 4)->default(0);
            $table->unsignedInteger('lead_time_days')->nullable();
            $table->decimal('unit_cost', 15, 2)->default(0);
            $table->boolean('active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->foreignId('plant_id')->constrained()->restrictOnDelete();
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->unique(['plant_id', 'code']);
        });

        Schema::create('warehouse_bins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->string('code');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->unique(['warehouse_id', 'code']);
        });

        Schema::create('technicians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('employee_no')->nullable();
            $table->foreignId('team_id')->nullable()->constrained()->nullOnDelete();
            $table->string('skill_level')->nullable();
            $table->text('certification_note')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('work_order_no')->unique();
            $table->foreignId('work_request_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('pm_schedule_id')->nullable();
            $table->foreignId('asset_id')->constrained()->restrictOnDelete();
            $table->foreignId('area_id')->constrained()->restrictOnDelete();
            $table->foreignId('production_line_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('work_order_type', ['corrective', 'preventive', 'predictive', 'inspection', 'calibration', 'improvement', 'emergency']);
            $table->enum('priority_level', ['low', 'medium', 'high', 'critical']);
            $table->enum('maintenance_class', ['planned', 'unplanned']);
            $table->string('title');
            $table->text('description');
            $table->text('problem_description')->nullable();
            $table->text('initial_diagnosis')->nullable();
            $table->text('root_cause_summary')->nullable();
            $table->text('corrective_action_summary')->nullable();
            $table->text('preventive_action_summary')->nullable();
            $table->foreignId('planner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('supervisor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('assigned_team_id')->nullable()->constrained('teams')->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('planned_start_at')->nullable();
            $table->dateTime('planned_end_at')->nullable();
            $table->dateTime('actual_start_at')->nullable();
            $table->dateTime('actual_end_at')->nullable();
            $table->unsignedInteger('response_time_minutes')->nullable();
            $table->unsignedInteger('repair_time_minutes')->nullable();
            $table->enum('verification_result', ['pending', 'pass', 'fail'])->nullable();
            $table->text('completion_note')->nullable();
            $table->text('close_note')->nullable();
            $table->boolean('requires_shutdown')->default(false);
            $table->boolean('permit_required')->default(false);
            $table->boolean('loto_required')->default(false);
            $table->enum('status', ['open', 'planned', 'assigned', 'in_progress', 'waiting_sparepart', 'waiting_production_release', 'completed', 'verified', 'closed', 'cancelled'])->default('open');
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('verified_at')->nullable();
            $table->foreignId('closed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('closed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('preventive_maintenance_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('preventive_maintenance_templates')->cascadeOnDelete();
            $table->foreignId('asset_id')->constrained()->cascadeOnDelete();
            $table->date('schedule_date');
            $table->date('due_date');
            $table->decimal('meter_due', 15, 4)->nullable();
            $table->foreignId('generated_work_order_id')->nullable()->constrained('work_orders')->nullOnDelete();
            $table->enum('status', ['planned', 'generated', 'in_progress', 'done', 'overdue', 'skipped', 'rescheduled'])->default('planned');
            $table->text('reschedule_reason')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::table('work_orders', function (Blueprint $table) {
            $table->foreign('pm_schedule_id')->references('id')->on('preventive_maintenance_schedules')->nullOnDelete();
        });

        Schema::create('work_order_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('sequence_no');
            $table->string('task_name');
            $table->text('task_description')->nullable();
            $table->text('standard_result')->nullable();
            $table->boolean('is_mandatory')->default(true);
            $table->enum('status', ['open', 'in_progress', 'done', 'skipped'])->default('open');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('work_order_labor_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('technician_id')->constrained()->restrictOnDelete();
            $table->dateTime('start_at');
            $table->dateTime('end_at')->nullable();
            $table->unsignedInteger('total_minutes')->nullable();
            $table->unsignedInteger('overtime_minutes')->nullable();
            $table->enum('labor_type', ['normal', 'overtime', 'vendor'])->default('normal');
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('work_order_spare_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('spare_part_id')->constrained()->restrictOnDelete();
            $table->foreignId('warehouse_id')->constrained()->restrictOnDelete();
            $table->decimal('qty_reserved', 15, 4)->default(0);
            $table->decimal('qty_issued', 15, 4)->default(0);
            $table->decimal('qty_used', 15, 4)->default(0);
            $table->decimal('qty_returned', 15, 4)->default(0);
            $table->decimal('unit_cost', 15, 2)->default(0);
            $table->decimal('total_cost', 15, 2)->default(0);
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('work_order_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->enum('attachment_type', ['before_photo', 'after_photo', 'evidence', 'report', 'checklist', 'other']);
            $table->string('file_path');
            $table->string('file_name');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('downtime_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('asset_id')->constrained()->restrictOnDelete();
            $table->dateTime('downtime_start_at');
            $table->dateTime('downtime_end_at')->nullable();
            $table->unsignedInteger('total_minutes')->nullable();
            $table->enum('downtime_type', ['full_stop', 'partial_stop', 'reduced_speed', 'standby_loss']);
            $table->text('production_impact_note')->nullable();
            $table->decimal('loss_estimation', 15, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('breakdown_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('asset_id')->constrained()->restrictOnDelete();
            $table->foreignId('failure_code_id')->nullable()->constrained('failure_codes')->nullOnDelete();
            $table->foreignId('problem_code_id')->nullable()->constrained('problem_codes')->nullOnDelete();
            $table->foreignId('cause_code_id')->nullable()->constrained('cause_codes')->nullOnDelete();
            $table->foreignId('action_code_id')->nullable()->constrained('action_codes')->nullOnDelete();
            $table->dateTime('breakdown_datetime');
            $table->text('symptom');
            $table->text('failure_mode')->nullable();
            $table->text('temporary_action')->nullable();
            $table->text('permanent_action')->nullable();
            $table->boolean('recurrence_flag')->default(false);
            $table->timestamps();
        });

        Schema::create('meter_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained()->cascadeOnDelete();
            $table->date('reading_date');
            $table->enum('meter_type', ['runtime_hour', 'cycle', 'km', 'other']);
            $table->decimal('meter_value', 15, 4);
            $table->enum('source', ['manual', 'system', 'iot']);
            $table->text('note')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_template_id')->constrained()->restrictOnDelete();
            $table->foreignId('asset_id')->nullable()->constrained()->nullOnDelete();
            $table->date('inspection_date');
            $table->foreignId('inspector_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['draft', 'submitted', 'reviewed', 'approved'])->default('draft');
            $table->text('result_summary')->nullable();
            $table->unsignedInteger('abnormal_count')->default(0);
            $table->boolean('auto_request_created')->default(false);
            $table->timestamps();
        });

        Schema::create('inspection_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained()->cascadeOnDelete();
            $table->foreignId('inspection_template_item_id')->constrained()->restrictOnDelete();
            $table->decimal('result_value', 15, 4)->nullable();
            $table->text('result_text')->nullable();
            $table->boolean('result_boolean')->nullable();
            $table->boolean('abnormal_flag')->default(false);
            $table->text('note')->nullable();
            $table->string('photo_path')->nullable();
            $table->timestamps();
        });

        Schema::create('asset_spare_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained()->cascadeOnDelete();
            $table->foreignId('spare_part_id')->constrained()->cascadeOnDelete();
            $table->enum('usage_type', ['consumable', 'replacement', 'critical_spare', 'optional']);
            $table->decimal('standard_qty', 15, 4)->nullable();
            $table->timestamps();
            $table->unique(['asset_id', 'spare_part_id']);
        });

        Schema::create('stock_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spare_part_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_bin_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('qty_on_hand', 15, 4)->default(0);
            $table->decimal('qty_reserved', 15, 4)->default(0);
            $table->decimal('qty_available', 15, 4)->default(0);
            $table->dateTime('last_movement_at')->nullable();
            $table->timestamps();
            $table->unique(['spare_part_id', 'warehouse_id', 'warehouse_bin_id'], 'stock_balances_unique_idx');
        });

        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_no')->unique();
            $table->dateTime('transaction_date');
            $table->foreignId('spare_part_id')->constrained()->restrictOnDelete();
            $table->foreignId('warehouse_id')->constrained()->restrictOnDelete();
            $table->foreignId('warehouse_bin_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('transaction_type', ['opening', 'receipt', 'issue', 'return', 'adjustment_plus', 'adjustment_minus', 'transfer_in', 'transfer_out', 'reservation', 'release_reservation']);
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->decimal('qty', 15, 4);
            $table->decimal('unit_cost', 15, 2)->default(0);
            $table->decimal('total_cost', 15, 2)->default(0);
            $table->text('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['reference_type', 'reference_id']);
        });

        Schema::create('stock_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('spare_part_id')->constrained()->restrictOnDelete();
            $table->foreignId('warehouse_id')->constrained()->restrictOnDelete();
            $table->decimal('qty_reserved', 15, 4);
            $table->decimal('qty_issued', 15, 4)->default(0);
            $table->enum('status', ['open', 'partial', 'fulfilled', 'cancelled'])->default('open');
            $table->dateTime('reserved_at');
            $table->dateTime('issued_at')->nullable();
            $table->timestamps();
        });

        Schema::create('root_cause_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('asset_id')->constrained()->restrictOnDelete();
            $table->string('rca_no')->unique();
            $table->enum('trigger_type', ['repeat_breakdown', 'critical_breakdown', 'high_downtime', 'pm_failure', 'quality_impact']);
            $table->text('issue_summary');
            $table->text('why_1')->nullable();
            $table->text('why_2')->nullable();
            $table->text('why_3')->nullable();
            $table->text('why_4')->nullable();
            $table->text('why_5')->nullable();
            $table->text('root_cause');
            $table->text('corrective_action_plan')->nullable();
            $table->text('preventive_action_plan')->nullable();
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('target_date')->nullable();
            $table->text('effectiveness_review')->nullable();
            $table->enum('verification_status', ['open', 'monitoring', 'effective', 'ineffective', 'closed'])->default('open');
            $table->timestamps();
            $table->unique('work_order_id');
        });

        Schema::create('corrective_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rca_id')->constrained('root_cause_analyses')->cascadeOnDelete();
            $table->text('action_description');
            $table->foreignId('responsible_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('target_date');
            $table->dateTime('completed_at')->nullable();
            $table->text('verification_note')->nullable();
            $table->enum('status', ['open', 'in_progress', 'done', 'verified', 'closed'])->default('open');
            $table->timestamps();
        });

        Schema::create('preventive_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rca_id')->constrained('root_cause_analyses')->cascadeOnDelete();
            $table->text('action_description');
            $table->foreignId('responsible_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('target_date');
            $table->dateTime('completed_at')->nullable();
            $table->text('verification_note')->nullable();
            $table->enum('status', ['open', 'in_progress', 'done', 'verified', 'closed'])->default('open');
            $table->timestamps();
        });

        Schema::create('improvement_registers', function (Blueprint $table) {
            $table->id();
            $table->enum('source_type', ['kaizen', 'audit', 'rca', 'user_suggestion', 'management_review']);
            $table->string('source_reference')->nullable();
            $table->string('title');
            $table->text('description');
            $table->text('expected_benefit')->nullable();
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('target_date')->nullable();
            $table->enum('status', ['open', 'approved', 'in_progress', 'implemented', 'verified', 'closed', 'rejected'])->default('open');
            $table->timestamps();
        });

        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->enum('module', ['work_request', 'work_order', 'pm_schedule', 'stock_issue', 'rca', 'capa']);
            $table->unsignedBigInteger('reference_id');
            $table->unsignedInteger('approval_step');
            $table->foreignId('approver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('approval_status', ['pending', 'approved', 'rejected', 'returned'])->default('pending');
            $table->text('approval_note')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->timestamps();
            $table->index(['module', 'reference_id']);
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('module');
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('title');
            $table->text('message');
            $table->enum('channel', ['in_app', 'email', 'whatsapp'])->default('in_app');
            $table->dateTime('read_at')->nullable();
            $table->timestamps();
            $table->index(['module', 'reference_id']);
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('module');
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('action');
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['module', 'reference_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('approvals');
        Schema::dropIfExists('improvement_registers');
        Schema::dropIfExists('preventive_actions');
        Schema::dropIfExists('corrective_actions');
        Schema::dropIfExists('root_cause_analyses');
        Schema::dropIfExists('stock_reservations');
        Schema::dropIfExists('stock_transactions');
        Schema::dropIfExists('stock_balances');
        Schema::dropIfExists('asset_spare_parts');
        Schema::dropIfExists('inspection_results');
        Schema::dropIfExists('inspections');
        Schema::dropIfExists('meter_readings');
        Schema::dropIfExists('breakdown_logs');
        Schema::dropIfExists('downtime_logs');
        Schema::dropIfExists('work_order_attachments');
        Schema::dropIfExists('work_order_spare_parts');
        Schema::dropIfExists('work_order_labor_logs');
        Schema::dropIfExists('work_order_tasks');
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropForeign(['pm_schedule_id']);
        });
        Schema::dropIfExists('preventive_maintenance_schedules');
        Schema::dropIfExists('work_orders');
        Schema::dropIfExists('technicians');
        Schema::dropIfExists('warehouse_bins');
        Schema::dropIfExists('warehouses');
        Schema::dropIfExists('spare_parts');
        Schema::dropIfExists('spare_part_categories');
        Schema::dropIfExists('inspection_template_items');
        Schema::dropIfExists('inspection_templates');
        Schema::dropIfExists('preventive_maintenance_template_items');
        Schema::dropIfExists('preventive_maintenance_templates');
        Schema::dropIfExists('action_codes');
        Schema::dropIfExists('cause_codes');
        Schema::dropIfExists('problem_codes');
        Schema::dropIfExists('failure_codes');
        Schema::dropIfExists('work_request_attachments');
        Schema::dropIfExists('work_requests');
        Schema::dropIfExists('asset_documents');
        Schema::dropIfExists('asset_components');
        Schema::dropIfExists('assets');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('asset_categories');
        Schema::dropIfExists('production_lines');
        Schema::dropIfExists('areas');
        Schema::dropIfExists('plants');
    }
};
