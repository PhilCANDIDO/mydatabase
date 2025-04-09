<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    protected static function bootAuditable()
    {
        // Enregistre les événements de création
        static::created(function ($model) {
            self::logChanges('Add', $model, null, $model->getAttributes());
        });

        // Enregistre les événements de mise à jour
        static::updated(function ($model) {
            self::logChanges('Modify', $model, $model->getOriginal(), $model->getChanges());
        });

        // Enregistre les événements de suppression
        static::deleted(function ($model) {
            self::logChanges('Delete', $model, $model->getAttributes(), null);
        });
    }

    protected static function logChanges($action, $model, $before, $after)
    {
        $user = Auth::user();
        
        AuditLog::create([
            'user_id' => $user ? $user->id : null,
            'username' => $user ? $user->name : 'System',
            'action_type' => $action,
            'table_name' => $model->getTable(),
            'record_id' => $model->id,
            'before_data' => $before,
            'after_data' => $after,
            'ip_address' => request()->ip(),
            'created_at' => now()
        ]);
    }
}