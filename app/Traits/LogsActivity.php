<?php

namespace App\Traits;

use App\Events\ActivityLoggedEvent;
use App\Models\ActivityLog;
use App\Models\User;
use App\Notifications\ImportantActionNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    protected function logActivity(string $action, ?Model $subject = null, ?string $description = null): void
    {
        $log = ActivityLog::create([
            'user_id'      => Auth::id(),
            'action'       => $action,
            'description'  => $description,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id'   => $subject?->getKey(),
            'ip_address'   => request()->ip(),
            'user_agent'   => request()->userAgent(),
        ]);

        // Broadcast temps réel
        event(new ActivityLoggedEvent($log));
    }

    protected function notifyUser(User $user, string $subject, string $message): void
    {
        $user->notify(new ImportantActionNotification($subject, $message));
    }

    protected function notifySuperAdmins(string $subject, string $message): void
    {
        User::role('super-admin')->each(
            fn (User $admin) => $admin->notify(new ImportantActionNotification($subject, $message))
        );
    }
}
