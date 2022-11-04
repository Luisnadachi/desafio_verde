<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{

    protected $fillable = [
        'payer_id',
        'payee_id',
        'value',
        'date_created',
    ];

    public function payer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payee(): BelongsTo
    {
        return $this->belongsTo(Shopkeeper::class);
    }

}
