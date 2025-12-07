<?php

namespace App\Events;

use App\Models\Product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class StockUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public function __construct(
        public Product $product
    ) {}

    public function broadcastOn(): array
    {
        return [new Channel('stocks')];
    }

    public function broadcastWith(): array
    {
        return [
            'product_id' => $this->product->id,
            'name'       => $this->product->name,
            'stock'      => $this->product->current_stock,
        ];
    }
}
