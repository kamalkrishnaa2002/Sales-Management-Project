<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;

class SaleController extends Controller
{

    public function getProductDetails($productId)
    {
        $product = Product::find($productId);
    
        // Get the last sale ID and increment it by 1
        $lastSaleId = Sale::max('SaleID') + 1;
    
        return response()->json([
            'price' => $product->rate,
            'gst_percentage' => $product->gst,
            'last_sale_id' => str_pad($lastSaleId, 3, '0', STR_PAD_LEFT), // Convert to 3-digit number
        ]);
    }
    

    public function create()
    {
        $products = Product::all(); // Fetch all products

        return view('sales.create', compact('products'));
    }


    public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'InvoiceNumber' => 'required|string',
        'InvoiceDate' => 'required|date',
        'CustomerName' => 'required|string',
        'CustomerEmail' => 'required|email',
        'CustomerPhone' => 'required|regex:/^\+?[0-9]{10,13}$/',
        'CustomerState' => 'required|string',
        'product_id.*' => 'required|string',
        'quantity.*' => 'required|integer|min:1',
        'price.*' => 'required',
        'gst_percentage.*' => 'required',
        'gst_amount.*' => 'required',

        'total_gst_percentage.*' => 'required',
        'total_gst_amount.*' => 'required',
        'total_sales_value.*' => 'required',
    ]);

    // Create a new sale
    $sale = Sale::create([
        'InvoiceNumber' => $request->input('InvoiceNumber'),
        'InvoiceDate' => $request->input('InvoiceDate'),
        'CustomerName' => $request->input('CustomerName'),
        'CustomerEmail' => $request->input('CustomerEmail'),
        'CustomerPhone' => $request->input('CustomerPhone'),
        'CustomerState' => $request->input('CustomerState'),
        'total_gst_percentage' => $request->input('total_gst_percentage'),
        'total_gst_amount' => $request->input('total_gst_amount'),
        'total_sales_value' => $request->input('total_sales_value'),


    ]);

    // Check if the sale was created successfully
    if ($sale) {
        // Iterate through product sections and create sale items
        foreach ($request->input('product_id') as $key => $productId) {
            SaleItem::create([
                'sale_id' => $sale->SaleID,
                'product_id' => $productId,
                'quantity' => $request->input('quantity')[$key],
                
            ]);
        }

        // Redirect after successful insertion
        return redirect()->route('sales.datatable')->with('success', 'Sale created successfully!');
    } else {
        // Handle the case where Sale creation fails
        return redirect()->route('sales.create')->with('warning', 'Failed to create Sale.');
    }
}


    public function update(Request $request, $invoiceNumber)
    {
        // Validate the request data
        $request->validate([
            'InvoiceNumber' => 'required|string',
            'InvoiceDate' => 'required|date',
            'CustomerName' => 'required|string',
            'CustomerEmail' => 'required|email',
            'CustomerPhone' => 'required|regex:/^\+?[0-9]{10,13}$/',
            'CustomerState' => 'required|string',
            'product_id.*' => 'required|string',
            'quantity.*' => 'required|integer|min:1',
            'price.*' => 'required',
            'gst_percentage.*' => 'required',
            'gst_amount.*' => 'required',
    
            'total_gst_percentage.*' => 'required',
            'total_gst_amount.*' => 'required',
            'total_sales_value.*' => 'required',
        ]);
        // Find the sale by InvoiceNumber
        $sale = Sale::where('InvoiceNumber', $invoiceNumber)->firstOrFail();
    
        // Update the sale data with the fields passed from the form
        $sale->update($request->only([
            'InvoiceDate',
            'CustomerName',
            'CustomerEmail',
            'CustomerPhone',
            'CustomerState',
            'total_gst_percentage',
            'total_gst_amount',
            'total_sales_value',


        ]));
    
        // Update or create sale items
        foreach ($request->input('product_id') as $index => $productId) {
            SaleItem::updateOrCreate(
                ['id' => $request->input('sale_item_id.'.$index)], // Update if exists
                [
                    'sale_id' => $sale->getKey(), // Use the primary key value of the sale
                    'product_id' => $productId,
                    'quantity' => $request->input('quantity.'.$index),
                    
                ]
            );
        }
    
        // Return a response, redirect, or perform any other action as needed
    }
    
    
    


    public function datatable()
    {
        return view('sales.datatable');
    }
    

    public function edit($invoiceNumber)
    {
        // Fetch the sale data by InvoiceNumber
        $sale = Sale::where('InvoiceNumber', $invoiceNumber)->firstOrFail();
    
        // Fetch all products to populate dropdown
        $products = Product::all();
    
        // Pass the sale data and products to the view
        return view('sales.edit', compact('sale', 'products'));
    }


    public function getallsales()
    {
        // Retrieve all sales data
        $sales = Sale::all();

        // Return the sales data as JSON
        return response()->json($sales);
    }


    public function getSalesData()
    {
        // Retrieve sales data from the database
        $salesData = Sale::with('saleItems')->get();

        // Return the sales data as JSON
        return response()->json(['salesData' => $salesData]);
    }

    
    
    public function salesview($invoiceNumber)
{
    // Fetch the sale data by InvoiceNumber
    $sale = Sale::where('InvoiceNumber', $invoiceNumber)->firstOrFail();

    // Fetch all products to populate dropdown
    $products = Product::all();

    // Pass the sale data and products to the view
    return view('sales.view', compact('sale', 'products'));
}

public function showInvoice($invoiceNumber)
{
    // Fetch details of the invoice based on the invoice number
    $invoice = Sale::where('InvoiceNumber', $invoiceNumber)->with('saleItems.product')->first();

    // Check if invoice exists
    if (!$invoice) {
        // Handle case when invoice does not exist (e.g., show error message or redirect)
        return redirect()->route('invoice.index')->with('error', 'Invoice not found.');
    }

    // Calculate totals
    $totalPrice = 0;
    $totalGSTPercentage = 0;
    $totalGSTAmount = 0;
    $totalSalesValue = 0;

    foreach ($invoice->saleItems as $saleItem) {
        // Assuming each sale item has associated product details
        $product = $saleItem->product;

        // Calculate total price for the sale item
        $totalPrice += $saleItem->quantity * $product->rate;

        // Calculate total GST amount for the sale item
        $totalGSTAmount += ($saleItem->quantity * $product->rate) * ($product->gst / 100);

        // Accumulate total GST percentage
        $totalGSTPercentage += $product->gst;

        // Calculate total sales value for the sale item
        $totalSalesValue += $saleItem->quantity * $product->rate + ($saleItem->quantity * $product->rate) * ($product->gst / 100);
    }

    // Pass data to the invoice view along with the calculated totals
    return view('sales.view', [
        'invoice' => $invoice,
        'totalPrice' => $totalPrice,
        'totalGSTPercentage' => $totalGSTPercentage,
        'totalGSTAmount' => $totalGSTAmount,
        'totalSalesValue' => $totalSalesValue
    ]);
}

        
}
