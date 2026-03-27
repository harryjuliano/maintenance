<?php

use App\Http\Controllers\Apps\AssetMasterController;
use App\Http\Controllers\Apps\AuditTrailController;
use App\Http\Controllers\Apps\BreakdownController;
use App\Http\Controllers\Apps\CalibrationSupportController;
use App\Http\Controllers\Apps\InspectionChecklistController;
use App\Http\Controllers\Apps\KpiReliabilityController;
use App\Http\Controllers\Apps\DashboardController;
use App\Http\Controllers\Apps\DowntimeTrackingController;
use App\Http\Controllers\Apps\MobileTechnicianFlowController;
use App\Http\Controllers\Apps\NotificationController;
use App\Http\Controllers\Apps\OperationalReportController;
use App\Http\Controllers\Apps\PlannerCalendarController;
use App\Http\Controllers\Apps\MaintenanceBlueprintController;
use App\Http\Controllers\Apps\PermissionController;
use App\Http\Controllers\Apps\PmSchedulerController;
use App\Http\Controllers\Apps\RcaCapaController;
use App\Http\Controllers\Apps\RoleController;
use App\Http\Controllers\Apps\SparePartControlController;
use App\Http\Controllers\Apps\UserController;
use App\Http\Controllers\Apps\WorkOrderController;
use App\Http\Controllers\Apps\WorkRequestController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix' => 'apps', 'as' => 'apps.', 'middleware' => ['auth']], function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/maintenance-blueprint', MaintenanceBlueprintController::class)->name('maintenance.blueprint');

    Route::resource('/assets', AssetMasterController::class)->except('show');
    Route::resource('/work-requests', WorkRequestController::class)->except('show');
    Route::resource('/work-orders', WorkOrderController::class)->except('show');
    Route::resource('/breakdowns', BreakdownController::class)->except('show');
    Route::resource('/pm-schedulers', PmSchedulerController::class)->except('show');
    Route::resource('/inspection-checklists', InspectionChecklistController::class)->except('show');
    Route::resource('/calibration-supports', CalibrationSupportController::class)->except('show');
    Route::resource('/downtime-trackings', DowntimeTrackingController::class)->except('show');
    Route::resource('/spare-parts', SparePartControlController::class)->except('show');
    Route::resource('/notifications', NotificationController::class)->except('show');
    Route::resource('/operational-reports', OperationalReportController::class)->except('show');
    Route::resource('/rca-capas', RcaCapaController::class)->except('show');
    Route::resource('/kpi-reliabilities', KpiReliabilityController::class)->except('show');
    Route::resource('/planner-calendars', PlannerCalendarController::class)->except('show');
    Route::resource('/mobile-technician-flows', MobileTechnicianFlowController::class)->except('show');

    Route::get('/permissions', PermissionController::class)->name('permissions.index');
    Route::resource('/roles', RoleController::class)->except(['create', 'edit', 'show']);
    Route::resource('/users', UserController::class)->except('show');

    Route::resource('/audit-trails', AuditTrailController::class)->only(['index', 'destroy']);
});

require __DIR__.'/auth.php';
