<?php

namespace App\Support;

use App\Models\AuditTrail;

class AuditTrailLogger
{
    public static function log(string $action, string $module, ?object $model = null, ?string $description = null, array $metadata = []): void
    {
        AuditTrail::query()->create([
            'user_id' => auth()->id(),
            'action' => $action,
            'module' => $module,
            'auditable_type' => $model ? $model::class : null,
            'auditable_id' => $model?->id,
            'description' => $description,
            'metadata' => $metadata,
        ]);
    }
}
