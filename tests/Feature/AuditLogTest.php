<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\College;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuditLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_model_creation_update_and_deletion_are_recorded(): void
    {
        $college = College::query()->create([
            'name' => 'Science College',
            'code' => 'SCI',
        ]);

        $createdLog = AuditLog::query()->latest('id')->first();
        $this->assertSame('CREATED', $createdLog->action);
        $this->assertSame('colleges', $createdLog->target_table);
        $this->assertSame($college->id, $createdLog->target_id);
        $this->assertStringContainsString('Science College', $createdLog->description);

        $college->update(['name' => 'Engineering College']);

        $updatedLog = AuditLog::query()->latest('id')->first();
        $this->assertSame('UPDATED', $updatedLog->action);
        $this->assertStringContainsString('Science College', $updatedLog->description);
        $this->assertStringContainsString('Engineering College', $updatedLog->description);

        $college->delete();

        $deletedLog = AuditLog::query()->latest('id')->first();
        $this->assertSame('DELETED', $deletedLog->action);
        $this->assertSame('colleges', $deletedLog->target_table);
        $this->assertSame(3, AuditLog::query()->count());
    }

    public function test_audit_logs_are_not_logged_again_and_sensitive_values_are_redacted(): void
    {
        User::query()->create([
            'name' => 'Private User',
            'email' => 'private@example.test',
            'password' => 'secret-password',
        ]);

        $this->assertSame(1, AuditLog::query()->count());
        $this->assertStringNotContainsString('secret-password', AuditLog::query()->first()->description);
        $this->assertStringContainsString('[REDACTED]', AuditLog::query()->first()->description);
    }
}
