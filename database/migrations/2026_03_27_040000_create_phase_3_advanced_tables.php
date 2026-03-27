<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('predictive_maintenance_readinesses', function (Blueprint $table) {
            $table->id();
            $table->string('readiness_no')->unique();
            $table->date('assessment_date');
            $table->foreignId('asset_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('data_quality_score', 5, 2)->default(0);
            $table->decimal('sensor_coverage_pct', 5, 2)->default(0);
            $table->enum('failure_model_status', ['not_started', 'training', 'validated', 'deployed'])->default('not_started');
            $table->enum('readiness_level', ['low', 'medium', 'high', 'best_in_class'])->default('low');
            $table->text('notes')->nullable();
            $table->enum('status', ['draft', 'reviewed', 'approved'])->default('draft');
            $table->timestamps();
        });

        Schema::create('cross_system_integrations', function (Blueprint $table) {
            $table->id();
            $table->string('integration_no')->unique();
            $table->string('system_name');
            $table->enum('integration_type', ['api', 'etl', 'iot', 'manual'])->default('api');
            $table->string('endpoint')->nullable();
            $table->enum('sync_frequency', ['realtime', 'hourly', 'daily', 'weekly', 'on_demand'])->default('daily');
            $table->dateTime('last_sync_at')->nullable();
            $table->decimal('success_rate_pct', 5, 2)->default(0);
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['planned', 'active', 'issue', 'deprecated'])->default('planned');
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('advanced_reporting_analytics', function (Blueprint $table) {
            $table->id();
            $table->string('analytics_no')->unique();
            $table->string('report_title');
            $table->date('report_period');
            $table->enum('metric_category', ['reliability', 'cost', 'energy', 'sparepart', 'executive'])->default('reliability');
            $table->text('insight_summary');
            $table->unsignedInteger('anomaly_count')->default(0);
            $table->decimal('prediction_accuracy', 5, 2)->default(0);
            $table->text('recommended_action')->nullable();
            $table->foreignId('prepared_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advanced_reporting_analytics');
        Schema::dropIfExists('cross_system_integrations');
        Schema::dropIfExists('predictive_maintenance_readinesses');
    }
};
