<?php

namespace App\Events;

use App\Models\FriendRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FriendRequestEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $friendRequest;
    public int $target_id;
    public function __construct(FriendRequest $friendRequest)
    {
        $this->friendRequest = $friendRequest;
        $this->target_id = $friendRequest->to_id;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('friend-request-channel-'.$this->target_id);
    }

    public function broadcastAs()
    {
        return 'FriendRequestEvent';   
    }
    
}
