<?php

namespace App\Events;

use App\Models\ActivityLog;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ActivityLoggedEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public function __construct(
        public ActivityLog $log
    ) {}

    public function broadcastOn(): array
    {
        return [new PrivateChannel('activity')];
    }

    public function broadcastWith(): array
    {
        return [
            'action'      => $this->log->action,
            'description' => $this->log->description,
            'user'        => $this->log->user?->email,
            'created_at'  => $this->log->created_at->toDateTimeString(),
        ];
    }
}
