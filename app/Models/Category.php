<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
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


    //relations
    public function medicines(): HasMany
    {
        return $this->hasMany(Medicine::class);
    }
//    protected $appends = ['category_name'];
//    public function getCategoryNameAttribute()
//    {
//        return $this->category->name ?? null;
//    }
}
