<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $primaryKey = 'SaleID';

    protected $fillable = [
        'InvoiceNumber',
        'InvoiceDate',
        'CustomerName',
        'CustomerEmail',
        'CustomerPhone',
        'CustomerState',
        'total_gst_percentage', 
        'total_gst_amount',
        'total_sales_value',
    ];

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class, 'sale_id');
    }
    public function getSalesData()
    {
        // Retrieve sales data from the database
        $salesData = Sale::with('saleItems')->get();

        // Dump and die (dd) the sales data
        dd($salesData);
    }
}
