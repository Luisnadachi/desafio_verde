<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'payer_id',
        'payee_id',
        'value',
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
