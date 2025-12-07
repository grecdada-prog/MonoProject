<?php

namespace App\Events;

use App\Models\Sale;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class SaleCreatedEvent implements ShouldBroadcast
{
    use SerializesModels;

    public function __construct(public Sale $sale) {}

    public function broadcastOn()
    {
        return new PrivateChannel('sales');
    }

    public function broadcastWith()
    {
        return [
            'invoice' => $this->sale->invoice_number,
            'amount'  => $this->sale->total_amount,
            'seller'  => $this->sale->seller->username,
            'sold_at' => $this->sale->sold_at->toDateTimeString(),
        ];
    }
}
