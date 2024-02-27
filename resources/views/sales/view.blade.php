@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="invoice-container">
            <div class="invoice-header">
                <h1>Sales Invoice</h1>
            </div>
            <div class="invoice-details">
                <!-- Display invoice details such as invoice number, date, customer information -->
            </div>
            <table class="table invoice-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>GST %</th>
                        <th>GST Amount</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through each sale item -->
                    @foreach($invoice->saleItems as $saleItem)
                        <tr>
                            <td>{{ $saleItem->product->product_name }}</td>
                            <td>{{ $saleItem->quantity }}</td>
                            <td>{{ $saleItem->product->rate }}</td>
                            
                            <td>{{ $saleItem->product->gst }}</td> <!-- Calculate total price -->
                            <td>{{ ($saleItem->quantity * $saleItem->product->rate) * ($saleItem->product->gst / 100) }}</td> <!-- Calculate GST amount -->
                            <td>{{ $saleItem->quantity * $saleItem->product->rate + (($saleItem->quantity * $saleItem->product->rate) * ($saleItem->product->gst / 100)) }}</td> <!-- Calculate total amount -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="totals-table" style="float: right; margin-top: 20px;">
                <table class="table" style="border-collapse: collapse;">
                    <tr>
                        <td style="text-align: right; font-weight: bold;">Total Price:</td>
                        <td style="padding-left: 10px;">{{ $totalPrice }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: right; font-weight: bold;">Total GST %:</td>
                        <td style="padding-left: 10px;">{{ $totalGSTPercentage }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: right; font-weight: bold;">Total GST Amount:</td>
                        <td style="padding-left: 10px;">{{ $totalGSTAmount }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: right; font-weight: bold;">Total Sales Value:</td>
                        <td style="padding-left: 10px;">{{ $totalSalesValue }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
 .invoice-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    text-align: right;
    font-weight: bold;
}

.invoice-total label {
    margin-right: 10px; /* Adjust margin as needed */
    min-width: 150px; /* Adjust width as needed */
}

    </style>
@endsection
