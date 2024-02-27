 // Function to view sale details
 function viewSale(invoiceNumber) {
    window.location.href = '/invoice/' + invoiceNumber;
}

// Function to edit sale details
function editSale(invoiceNumber) {
    window.location.href = '/sales/' + invoiceNumber + '/edit';
}

// Function to export data to CSV
function exportToCsv() {
    $.ajax({
        url: '/salesdata',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // Convert JSON data to CSV format
            var csvContent = "";

            // Add headers
            csvContent += Object.keys(data[0]).join(",") + "\n";

            // Add rows
            data.forEach(function(item) {
                csvContent += Object.values(item).join(",") + "\n";
            });

            // Create a CSV blob with proper content type
            var csvBlob = new Blob([csvContent], { type: 'text/csv' });

            // Create a temporary anchor element
            var link = document.createElement("a");
            link.href = URL.createObjectURL(csvBlob);
            link.setAttribute("download", "sales_data.csv");

            // Trigger the download
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}


$('#exportCsvButton').on('click', function() {
    exportToCsv();
});

function exportToPdf() {
    // Wrap the table in a narrower container
    var element = document.createElement('div');
    element.appendChild(document.getElementById('salesTable').cloneNode(true));
    element.style.width = 'fit-content'; // Set the container width to fit the table

    // Reduce font size of table content
    var tableContent = element.getElementsByTagName('td');
    for (var i = 0; i < tableContent.length; i++) {
        tableContent[i].style.fontSize = '10px'; // Adjust the font size as needed
    }

    var opt = {
        margin: 1,
        filename: 'sales_data.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
    };

    // New Promise-based usage:
    html2pdf().set(opt).from(element).save();
}

// Button click event handler
$('#exportPdfButton').on('click', function() {
    exportToPdf();
});


$(document).ready(function() {




    // Function to fetch sales data based on search
    function fetchSalesData(search) {
        $.ajax({
            url: '/salesdata',
            method: 'GET',
            dataType: 'json',
            data: { search: search }, // Pass search parameter
            success: function(response) {
                // Clear existing table data
                $('#salesTable tbody').empty();
                
                // Filter sales data based on search
                var filteredSales = response.filter(function(sale) {
                    return sale.InvoiceNumber.toLowerCase().includes(search.toLowerCase());
                });
                
                // Check if search result is empty
                if (filteredSales.length === 0) {
                    $('#salesTable tbody').append('<tr><td colspan="4">No records found</td></tr>');
                    return;
                }
                
                // Populate the table with filtered sales data
                $.each(filteredSales, function(index, sale) {
                    $('#salesTable tbody').append(
                        '<tr>' +
                        '<td>' + sale.InvoiceNumber + '</td>' +
                        '<td>' + sale.InvoiceDate + '</td>' +
                        '<td>' + sale.CustomerName + '</td>' +
                        '<td>' + sale.CustomerEmail + '</td>' +
                        '<td>' + sale.CustomerPhone + '</td>' +
                      
                         '<td>' + sale.CustomerState + '</td>' +
                        '<td>' + sale.total_gst_percentage + '</td>' +
                       
                       
                        
                        '<td>' + sale.total_gst_amount + '</td>' +
                        '<td>' + sale.total_sales_value + '</td>' +
                            '<td>' +
                                '<button onclick="viewSale(\'' + sale.InvoiceNumber + '\')" class="btn btn-info btn-sm mr-1">View</button>' +
                                '<button onclick="editSale(\'' + sale.InvoiceNumber + '\')" class="btn btn-primary btn-sm">&nbspEdit&nbsp;</button>' +

                            '</td>' +
                        '</tr>'
                    );
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // Initial fetch without search
    fetchSalesData('');

    // Search functionality
    $('#search').on('keyup', function() {
        var search = $(this).val().trim();
        fetchSalesData(search);
    });

    
});