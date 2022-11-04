<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shopkeeper extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'wallet_id',
        'name',
        'cnpj',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}