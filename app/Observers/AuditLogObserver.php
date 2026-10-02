<?php

namespace App\Observers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditLogObserver
{
    public function created(Model $model): void
    {
        $this->record($model, 'CREATED', $this->attributes($model->getAttributes()));
    }

    public function updated(Model $model): void
    {
        $changes = [];

        foreach ($model->getChanges() as $key => $newValue) {
            if ($this->isIgnoredAttribute($key)) {
                continue;
            }

            $changes[$key] = [
                'old' => $model->getRawOriginal($key),
                'new' => $newValue,
            ];
        }

        if ($changes !== []) {
            $this->record($model, 'UPDATED', $changes);
        }
    }

    public function deleted(Model $model): void
    {
        $this->record($model, 'DELETED', $this->attributes($model->getAttributes()));
    }

    /**
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    private function attributes(array $attributes): array
    {
        $attributes = array_filter(
            $attributes,
            fn (string $key): bool => ! $this->isIgnoredAttribute($key),
            ARRAY_FILTER_USE_KEY
        );

        foreach ($attributes as $key => $value) {
            if (preg_match('/password|token|secret|recovery|remember/i', $key)) {
                $attributes[$key] = '[REDACTED]';
            }
        }

        return $attributes;
    }

    private function isIgnoredAttribute(string $key): bool
    {
        return in_array($key, ['id', 'created_at', 'updated_at', 'deleted_at'], true);
    }

    /**
     * @param  array<string, mixed>  $changes
     */
    private function record(Model $model, string $action, array $changes): void
    {
        $changes = $this->redactChanges($changes);
        $userId = Auth::id();

        if ($model instanceof User && $userId === $model->getKey()) {
            $userId = null;
        }

        AuditLog::query()->create([
            'user_id' => $userId,
            'action' => $action,
            'target_table' => $model->getTable(),
            'target_id' => $model->getKey(),
            'description' => json_encode($changes, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'ip_address' => app()->bound('request') ? request()->ip() : null,
        ]);
    }

    /**
     * @param  array<string, mixed>  $changes
     * @return array<string, mixed>
     */
    private function redactChanges(array $changes): array
    {
        foreach ($changes as $key => $value) {
            if (preg_match('/password|token|secret|recovery|remember/i', (string) $key)) {
                $changes[$key] = '[REDACTED]';
            }
        }

        return $changes;
    }
}
