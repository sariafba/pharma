<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicine extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = [ 'statusMedicines'];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function statusMedicines(): HasMany
    {
        return $this->hasMany(StatusMedicine::class);
    }

    public function favoritMedicines(): HasMany
    {
        return $this->hasMany(FavoritMedicine::class);
    }

//    public function orders(): HasMany
//    {
//        return $this->hasMany(Order::class);
//    }

//    public function carts(): HasMany
//    {
//        return $this->hasMany(Cart::class);
//    }

}
