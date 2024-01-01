<?php

namespace App\Models;

use App\Models\StatusMedicine;

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


            static::creating(function ($orderMedicine) {
                // Fetch medicine statuses ordered by expiry date, oldest first
                $medicineStatuses = StatusMedicine::where('medicine_id', $orderMedicine->medicine_id)
                    ->orderBy('expiration_date')
                    ->get();

                $orderedQuantity = $orderMedicine->required_quantity;

                foreach ($medicineStatuses as $medicineStatus) {
                    $quantityToDeduct = min($orderedQuantity, $medicineStatus->quantity);

                    // Deduct quantity from the current medicine status
                    $medicineStatus->update(['quantity' => $medicineStatus->quantity - $quantityToDeduct]);

                    // Update ordered quantity
                    $orderedQuantity -= $quantityToDeduct;

                    if ($orderedQuantity <= 0) {
                        break; // Ordered quantity is fulfilled
                    }
                }

                // Update the total quantity of the medicine after processing all statuses
                $medicine = Medicine::find($orderMedicine->medicine_id);
                $newQuantity = $medicine->quantity - $orderMedicine->required_quantity;
                $newQuantity = max(0, $newQuantity);
                $medicine->update(['quantity' => $newQuantity]);
            });

    }


    // ... other model code
}
//                    // Update the total quantity in the medicines table
//                    $medicine = Medicine::find($orderMedicine->medicine_id);
//                    $newQuantity = $medicine->quantity - $orderMedicine->required_quantity;
//                    $newQuantity = max(0, $newQuantity);
//                    $medicine->update([
//                         'quantity' => $newQuantity,
//                 ]);

//    protected static function boot()
//    {
//        parent::boot();
//
//        // Register a creating event listener
//        static::creating(function ($orderMedicine) {
//            // Set a default value for the 'status' field
//            $medicine = Medicine::find($orderMedicine->medicine_id);
//
//            $newQuantity = $medicine->quantity - $orderMedicine->required_quantity;
//            $medicine->update([
//                'quantity' => $newQuantity,
//            ]);
//        });
//    }
//}
