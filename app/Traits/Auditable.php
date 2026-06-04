<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait Auditable
{
    protected static function bootAuditable(): void
    {
        static::created(function (Model $model) {
            static::logChange($model, 'created', [], $model->toArray());
        });

        static::updated(function (Model $model) {
            $old = $model->getOriginal();
            $new = $model->getChanges();

            $changed = [];
            foreach ($new as $key => $value) {
                if (array_key_exists($key, $old)) {
                    $changed[$key] = [
                        'old' => $old[$key],
                        'new' => $value,
                    ];
                }
            }

            if (!empty($changed)) {
                static::logChange($model, 'updated', $old, $new);
            }
        });

        static::deleted(function (Model $model) {
            static::logChange($model, 'deleted', $model->toArray(), []);
        });
    }

    protected static function logChange(Model $model, string $action, array $oldValues, array $newValues): void
    {
        $user = Auth::user();

        if (!$user && !app()->runningInConsole()) {
            return;
        }

        AuditLog::create([
            'user_id' => $user?->id,
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'old_values' => json_encode($oldValues),
            'new_values' => json_encode($newValues),
            'ip_address' => Request::ip() ?? '127.0.0.1',
            'user_agent' => Request::userAgent() ?? 'console',
        ]);
    }
}
