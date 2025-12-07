<?php

namespace App\Services;

use App\Models\InvoiceCounter;
use Illuminate\Support\Facades\DB;

class InvoiceNumberService
{
    public function generate(): string
    {
        return DB::transaction(function () {
            $today = now()->toDateString();

            $counter = InvoiceCounter::lockForUpdate()->firstOrCreate(
                ['date' => $today],
                ['counter' => 0]
            );

            $counter->counter++;
            $counter->save();

            $seq = str_pad($counter->counter, 5, '0', STR_PAD_LEFT);
            $prefix = now()->format('Ymd');

            return "INV-{$prefix}-{$seq}";
        });
    }
}
