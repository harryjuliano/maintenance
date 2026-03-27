<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaintenanceNotificationRequest;
use App\Models\MaintenanceNotification;
use App\Models\User;
use App\Support\AuditTrailLogger;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class NotificationController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:notifications-access'),
            new Middleware('permission:notifications-data', only: ['index']),
            new Middleware('permission:notifications-create', only: ['create', 'store']),
            new Middleware('permission:notifications-update', only: ['edit', 'update']),
            new Middleware('permission:notifications-delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $notifications = MaintenanceNotification::query()
            ->leftJoin('users', 'users.id', '=', 'notifications.user_id')
            ->select('notifications.*', 'users.name as user_name')
            ->latest('notifications.id')
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Maintenance/Notifications/Index', [
            'notifications' => $notifications,
        ]);
    }

    public function create()
    {
        return inertia('Apps/Maintenance/Notifications/Create', [
            'users' => User::query()->select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function store(MaintenanceNotificationRequest $request)
    {
        $notification = MaintenanceNotification::query()->create($request->validated());

        AuditTrailLogger::log('create', 'notification', $notification, 'Create notification', [
            'title' => $notification->title,
            'channel' => $notification->channel,
        ]);

        return to_route('apps.notifications.index');
    }

    public function edit(MaintenanceNotification $notification)
    {
        return inertia('Apps/Maintenance/Notifications/Edit', [
            'notification' => $notification,
            'users' => User::query()->select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function update(MaintenanceNotificationRequest $request, MaintenanceNotification $notification)
    {
        $notification->update($request->validated());

        AuditTrailLogger::log('update', 'notification', $notification, 'Update notification', [
            'title' => $notification->title,
            'channel' => $notification->channel,
        ]);

        return to_route('apps.notifications.index');
    }

    public function destroy(MaintenanceNotification $notification)
    {
        AuditTrailLogger::log('delete', 'notification', $notification, 'Delete notification', [
            'title' => $notification->title,
            'channel' => $notification->channel,
        ]);

        $notification->delete();

        return back();
    }
}
