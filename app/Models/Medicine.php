<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicine extends Model
{
    use HasFactory;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    //relations methods
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

////////dont delete//////////
//for adding extra attribute for model

//    protected $appends = ['category_name'];
//    public function getCategoryNameAttribute()
//    {
//        return $this->category->name ?? null;
//    }

//    protected function categoryId(): Attribute
//    {
//        return Attribute::make(
//            get: fn ($value) => Category::find($value)->name,
//        );
//    }

}
