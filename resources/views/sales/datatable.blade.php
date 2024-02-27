<!-- resources/views/datatable.blade.php -->

@extends('layouts.app')
@section('style')
    <style>
        #salesTable th {
            white-space: nowrap; /* Prevent line breaks */
            overflow: hidden; /* Hide overflow */
            text-overflow: ellipsis; /* Add ellipsis for overflow text */
            max-width: 150px; /* Adjust maximum width as needed */
        }
        #salesTable th,
    #salesTable td {
        text-align: center;
    }
    </style>
@endsection
@section('content')
    <div class="container">
        <h2 class="mt-5 mb-4">Sales Data</h2>
        <button id="exportCsvButton" class="btn btn-primary">Export to CSV</button>
        <button id="exportPdfButton" class="btn btn-primary">Export to PDF</button>

        <div class="form-group">
            <label for="search">Search Invoice Number:</label>
            <input type="text" id="search" class="form-control" placeholder="Enter Invoice Number">
        </div>

        <table id="salesTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Invoice Number</th>
                    <th>Invoice Date</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Customer Phone</th>
                    <th>Customer State</th>
                    <th>Total GST %</th>
                    <th>Total GST</th>
                    <th>Sales Value</th>
                    <th>Actions</th> 
                </tr>
            </thead>
            <tbody>
                <!-- Data will be loaded dynamically here -->
            </tbody>
        </table>
    </div>

    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script src="{{ asset('js/datatable.js') }}"></script>
  
    
@endsection
