<!-- resources/views/sales/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container custom-container">
    <h2>Create Sale</h2>
    <form action="{{ route('sales.store') }}" method="post" id="salesForm">
        @csrf

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="InvoiceNumber">Invoice Number:</label>
                <input type="text" name="InvoiceNumber" class="form-control" required readonly>
            </div>

            <div class="form-group col-md-4">
                <label for="InvoiceDate">Invoice Date:</label>
                <?php
                  
                    $currentDate = date('Y-m-d');
                    
                  
                    $threeDaysAgo = date('Y-m-d', strtotime('-3 days'));
                ?>
                <input type="date" name="InvoiceDate" class="form-control" required
                       value="<?= $currentDate ?>" min="<?= $threeDaysAgo ?>" max="<?= $currentDate ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="CustomerName">Customer Name:</label>
                <input type="text" name="CustomerName" class="form-control" required>
            </div>

            <div class="form-group col-md-4">
                <label for="CustomerEmail">Customer Email:</label>
                <input type="email" name="CustomerEmail" class="form-control" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="CustomerPhone">Customer Phone:</label>
                <input type="tel" name="CustomerPhone" class="form-control" required>
            </div>

            <div class="form-group col-md-4">
                <label for="CustomerState">Customer State:</label>
                <select name="CustomerState" class="form-control" required>
                    <option value="" disabled selected>Select State</option>
                    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                    <option value="Assam">Assam</option>
                    <option value="Bihar">Bihar</option>
                    <option value="Chandigarh">Chandigarh</option>
                    <option value="Chhattisgarh">Chhattisgarh</option>
                    <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                    <option value="Daman and Diu">Daman and Diu</option>
                    <option value="Delhi">Delhi</option>
                    <option value="Goa">Goa</option>
                    <option value="Gujarat">Gujarat</option>
                    <option value="Haryana">Haryana</option>
                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                    <option value="Jharkhand">Jharkhand</option>
                    <option value="Karnataka">Karnataka</option>
                    <option value="Kerala">Kerala</option>
                    <option value="Ladakh">Ladakh</option>
                    <option value="Lakshadweep">Lakshadweep</option>
                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                    <option value="Maharashtra">Maharashtra</option>
                    <option value="Manipur">Manipur</option>
                    <option value="Meghalaya">Meghalaya</option>
                    <option value="Mizoram">Mizoram</option>
                    <option value="Nagaland">Nagaland</option>
                    <option value="Odisha">Odisha</option>
                    <option value="Puducherry">Puducherry</option>
                    <option value="Punjab">Punjab</option>
                    <option value="Rajasthan">Rajasthan</option>
                    <option value="Sikkim">Sikkim</option>
                    <option value="Tamil Nadu">Tamil Nadu</option>
                    <option value="Telangana">Telangana</option>
                    <option value="Tripura">Tripura</option>
                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                    <option value="Uttarakhand">Uttarakhand</option>
                    <option value="West Bengal">West Bengal</option>
                </select>
            </div>
            
        </div>

        <div id="productSectionsContainer">
            <!-- Product section template -->
            <div class="product-section">
                <div class="row">
                    <!-- Product Dropdown -->
                    <div class="form-group col-md-3">
                        <label for="product_id">Product:</label>
                        <select name="product_id[]" class="form-control product-dropdown" required>
                            <option value="" disabled selected>Select Product</option>
                            @foreach($products as $product)
                            <option value="{{ $product->pid }}" data-category="{{ $product->category->category_name }}">{{ $product->product_name }}</option>

                            @endforeach
                        </select>
                    </div>
            
                    <!-- Quantity Input -->
                    <div class="form-group col-md-2 col-sm-6">
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity[]" class="form-control quantity" required min="1">
                    </div>
            
                    <!-- Price Input -->
                    <div class="form-group col-md-2 col-sm-6">
                        <label for="price">Price:</label>
                        <input type="text" name="price[]" class="form-control price" required>
                    </div>
            
                    <!-- GST Percentage Input -->
                    <div class="form-group col-md-1">
                        <label for="gst_percentage">GST %:</label>
                        <input type="text" name="gst_percentage[]" class="form-control gst-percentage" required>
                    </div>
            
                    <!-- GST Amount Input -->
                    <div class="form-group col-md-1">
                        <label for="gst_amount">GST Amount:</label>
                        <input type="text" name="gst_amount[]" class="form-control gst-amount" required>
                    </div>
            
                    <!-- Total Amount Input -->
                    <div class="form-group col-md-1">
                        <label for="total_amount">Total Amount:</label>
                        <input type="text" name="total_amount[]" class="form-control total-amount" required>
                    </div>
                    <!-- Remove and Add Buttons -->
                    <div class="form-group col-md-2 col-sm-12 d-flex align-items-center">
                        
                        <div class="flex">
                            <button type="button" class="btn btn-success btn-block ml-1 flex-grow-1" id="addProductSection">Add</button>
                            <button type="button" class="btn btn-danger btn-block remove-product-section ml-1 flex-grow-1">Remove</button>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
            
        </div>
        
        
        <!-- Submit Button -->
       
    
        <div class="totals-section mt-4">
            <div class="row">
                <div class="form-group col-md-3 offset-md-9 text-left">
                    <h3>Totals</h3>
                </div>
            </div>
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
        </div>
        
</form>
</div>



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="{{ asset('js/create.js') }}"></script>

@endsection
