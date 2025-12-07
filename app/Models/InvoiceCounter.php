<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceCounter extends Model
{
    protected $fillable = ['date', 'counter'];

    protected $casts = [
        'date' => 'date',
    ];
}
