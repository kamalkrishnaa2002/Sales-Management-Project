<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'pid';

    protected $fillable = [
        'cid',
        'product_name',
        'qty',
        'rate',
        'gst',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cid', 'cid'); // assuming 'cid' is the foreign key in the 'products' table
    }
}
