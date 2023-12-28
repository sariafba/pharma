<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatusOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at'
    ];


    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

}
