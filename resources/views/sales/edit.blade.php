<!-- resources/views/sales/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container custom-container">
        <h2>Edit Sale</h2>
        <form action="{{ route('sales.update', $sale->InvoiceNumber) }}" method="post" id="salesForm">
            @csrf
            @method('PUT') <!-- Use PUT method for updating -->

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="InvoiceNumber">Invoice Number:</label>
                    <input type="text" name="InvoiceNumber" class="form-control" value="{{ $sale->InvoiceNumber }}" readonly> <!-- Make invoice number readonly -->
                </div>

                <div class="form-group col-md-4">
                    <label for="InvoiceDate">Invoice Date:</label>
                    <input type="date" name="InvoiceDate" class="form-control" value="{{ $sale->InvoiceDate }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="CustomerName">Customer Name:</label>
                    <input type="text" name="CustomerName" class="form-control" value="{{ $sale->CustomerName }}" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="CustomerEmail">Customer Email:</label>
                    <input type="email" name="CustomerEmail" class="form-control" value="{{ $sale->CustomerEmail }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="CustomerPhone">Customer Phone:</label>
                    <input type="tel" name="CustomerPhone" class="form-control" value="{{ $sale->CustomerPhone }}" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="CustomerState">Customer State:</label>
                  
                    <select name="CustomerState" class="form-control" required>
                        <option value="" disabled selected>Select State</option>
                        @php
                            $selectedState = $sale->CustomerState;
                            $states = [
                                "Andaman and Nicobar Islands", "Andhra Pradesh", "Arunachal Pradesh", "Assam",
                                "Bihar", "Chandigarh", "Chhattisgarh", "Dadra and Nagar Haveli", "Daman and Diu",
                                "Delhi", "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jammu and Kashmir",
                                "Jharkhand", "Karnataka", "Kerala", "Ladakh", "Lakshadweep", "Madhya Pradesh",
                                "Maharashtra", "Manipur", "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Puducherry",
                                "Punjab", "Rajasthan", "Sikkim", "Tamil Nadu", "Telangana", "Tripura", "Uttar Pradesh",
                                "Uttarakhand", "West Bengal"
                            ];
                        @endphp
                        @foreach($states as $state)
                            <option value="{{ $state }}" {{ $selectedState == $state ? 'selected' : '' }}>
                                {{ $state }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
            </div>

            <div id="productSectionsContainer">
                <!-- Product section template -->
                <!-- Product section template -->
            @foreach($sale->saleItems as $saleItem)
            <div class="product-section">
                <div class="row">
                    <!-- Hidden input field to store sale_id -->
                    <input type="hidden" name="sale_item_id[]" value="{{ $saleItem->id }}">
                    
                    <!-- Product Dropdown -->
                    <div class="form-group col-md-3">
                        <label for="product_id">Product:</label>
                        <select name="product_id[]" class="form-control product-dropdown" required>
                            <option value="" disabled>Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->pid }}" data-category="{{ $product->category->category_name }}" @if($saleItem->product->pid == $product->pid) selected @endif>{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Quantity Input -->
                    <div class="form-group col-md-2 col-sm-6">
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity[]" class="form-control quantity" value="{{ $saleItem->quantity }}" required min="1">
                    </div>
                    

                    <!-- Price Input -->
                    <div class="form-group col-md-2 col-sm-6">
                        <label for="price">Price:</label>
                        <input type="text" name="price[]" class="form-control price" value="{{ $saleItem->price }}" required readonly>
                    </div>

                    <!-- GST Percentage Input -->
                    <div class="form-group col-md-1">
                        <label for="gst_percentage">GST %:</label>
                        <input type="text" name="gst_percentage[]" class="form-control gst-percentage" value="{{ $saleItem->gst_percentage }}" required readonly>
                    </div>

                    <!-- GST Amount Input -->
                    <div class="form-group col-md-1">
                        <label for="gst_amount">GST Amount:</label>
                        <input type="text" name="gst_amount[]" class="form-control gst-amount" value="{{ $saleItem->gst_amount }}" required readonly>
                    </div>

                    <!-- Total Amount Input -->
                    <div class="form-group col-md-1">
                        <label for="total_amount">Total Amount:</label>
                        <input type="text" name="total_amount[]" class="form-control total-amount" required readonly>
                    </div>

                    <!-- Remove Button -->
                    <div class="form-group col-md-2 col-sm-12 d-flex align-items-center">
                        <div class="flex">
                            <button type="button" class="btn btn-danger btn-block remove-product-section ml-1 flex-grow-1">Remove</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            </div>
            
            <!-- Button to add new product section -->
            <div class="form-group">
                <button type="button" class="btn btn-success" id="addProductSection">Add Product</button>
            </div>
            
            <!-- Totals Section -->
            <div class="row">
                <div class="form-group col-md-3 offset-md-9 text-left">
                    <label for="total_price">Total Price:</label>
                    <input type="text" name="total_price" class="form-control" readonly>
                </div>
                <div class="form-group col-md-3 offset-md-9 text-left">
                    <label for="total_gst_amount">Total GST %:</label>
                    <input type="text" name="total_gst_percentage" class="form-control" readonly>
                </div>
                <div class="form-group col-md-3 offset-md-9 text-left">
                    <label for="total_gst_amount">Total GST Amount:</label>
                    <input type="text" name="total_gst_amount" class="form-control" readonly>
                </div>
                <div class="form-group col-md-3 offset-md-9 text-left">
                    <label for="total_sales_value">Total Sales Value:</label>
                    <input type="text" name="total_sales_value" class="form-control" readonly>
                </div>
                <div class="form-group col-md-3 offset-md-9 text-left">
                    <button type="button" class="btn btn-primary" id="submitForm">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ asset('js/edit.js') }}"></script>
    
@endsection
