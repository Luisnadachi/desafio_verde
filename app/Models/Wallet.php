<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model
{

    use HasFactory;
    public $incrementing = false;

    protected $fillable = [
        'owner_id',
        'balance',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shopkeeper(): BelongsTo
    {
        return $this->belongsTo(Shopkeeper::class);
    }

}
