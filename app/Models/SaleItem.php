<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        
        // Add other fields as needed
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Add other relationships if needed

    // Additional methods or attributes can be added as per your requirement
    // For example, you might want to calculate the total cost including GST
    public function getTotalCostWithGst()
    {
        return $this->total_cost + $this->gst_amount;
    }
}
