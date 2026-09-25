<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EntityListed implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly string $entity,
        public readonly int $count,
    ) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('entities'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'entity.listed';
    }

    public function broadcastWith(): array
    {
        return [
            'entity' => $this->entity,
            'count' => $this->count,
        ];
    }
}
