<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Shopkeeper extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'name',
        'cnpj',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'owner_id');
    }
}
