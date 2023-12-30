<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'id',
        'status_orders_id',
        'medicine_id'
    ];

    public function statusOrder(): BelongsTo
    {
        return $this->belongsTo(StatusOrder::class);
    }

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Register a creating event listener
        static::creating(function ($orderMedicine) {
            // Set a default value for the 'status' field
            $medicine = Medicine::find($orderMedicine->medicine_id);

            $newQuantity = $medicine->quantity - $orderMedicine->required_quantity;
            $medicine->update([
                'quantity' => $newQuantity,
            ]);
        });
    }
}
