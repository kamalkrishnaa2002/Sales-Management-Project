<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id('SaleID');
            $table->string('InvoiceNumber');
            $table->date('InvoiceDate');
            $table->string('CustomerName');
            $table->string('CustomerEmail');
            $table->string('CustomerPhone');
            $table->string('CustomerState');
            $table->decimal('total_gst_percentage', 5, 2);
            $table->decimal('total_gst_amount', 10, 2); 
            $table->decimal('total_sales_value', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
}

