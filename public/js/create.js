
    $(document).ready(function () {
        // Function to calculate totals
        function calculateTotals() {
            var total_price = 0;
            var total_gst_amount = 0;
            var total_sales_value = 0;
            var total_gst_percentage = 0; // Initialize total GST percentage
    
            // Loop through each product section
            $('.product-section').each(function () {
                var quantity = parseFloat($(this).find('.quantity').val());
                var price = parseFloat($(this).find('.price').val());
                var gstPercentage = parseFloat($(this).find('.gst-percentage').val());
    
                // Calculate individual totals
                var productTotal = quantity * price;
                var productGSTTotal = quantity * (gstPercentage / 100) * price;
    
                // Add to overall totals
                total_price += productTotal;
                total_gst_amount += productGSTTotal;
                total_sales_value += productTotal + productGSTTotal;
                total_gst_percentage += gstPercentage; // Add GST percentage to total
            });
    
            // Set the calculated totals in the respective input fields
            $('input[name="total_price"]').val(total_price.toFixed(2));
            $('input[name="total_gst_amount"]').val(total_gst_amount.toFixed(2));
            $('input[name="total_sales_value"]').val(total_sales_value.toFixed(2));
            $('input[name="total_gst_percentage"]').val(total_gst_percentage.toFixed(2)); // Set total GST percentage
        }

        // Add product section dynamically
        $("#addProductSection").click(function () {
            var productSection = $(".product-section:first").clone();
            productSection.find('input').val(''); // Clear input values

            // Re-enable all product dropdown options in the new section
            productSection.find('.product-dropdown option').prop('disabled', false);

            $("#productSectionsContainer").append(productSection);
        });

        // Remove product section
        $(document).on('click', '.remove-product-section', function () {
            var productSection = $(this).closest('.product-section');

            // If there's only one record, clear all the input fields
            if ($('.product-section').length === 1) {
                productSection.find('input').val('');
                productSection.find('.product-dropdown').val('');
                $('input[name="InvoiceNumber"]').val('');
            } else {
                // If there are multiple records, remove the current record
                productSection.remove();
            }

            // Recalculate totals after changes in product or quantity
            calculateTotals();
        });

        $(document).on('change input', '.product-dropdown, .quantity', function () {
            var productSection = $(this).closest('.product-section');
            var selectedProductId = productSection.find('.product-dropdown').val();

            // Check if the selected product is already chosen
            var isAlreadyChosen = $('.product-dropdown').toArray().some(function (dropdown) {
                var productId = $(dropdown).val();
                return productId === selectedProductId && dropdown !== productSection.find('.product-dropdown')[0];
            });

            if (isAlreadyChosen) {
                alert('This product is already chosen in another section. Please choose a different product.');
                productSection.remove();
                calculateTotals();
                return;
            }

            // Make an AJAX request to fetch product details
            $.ajax({
                url: '/get-product-details/' + selectedProductId,
                type: 'get',
                dataType: 'json',
                success: function (data) {
                    // Update the input fields with the fetched data
                    productSection.find('.price').val(data.price);
                    productSection.find('.gst-percentage').val(data.gst_percentage); // Set GST percentage

                    // Calculate GST amount based on GST percentage and price
                    var gstPercentage = parseFloat(data.gst_percentage);
                    var quantity = parseFloat(productSection.find('.quantity').val());
                    var price = parseFloat(productSection.find('.price').val());
                   
                    var gstAmount = (gstPercentage / 100) * price * quantity;
                    // Set the calculated GST amount in the corresponding input field
                    productSection.find('.gst-amount').val(gstAmount.toFixed(2));

                    // Calculate total amount (Price + GST Amount) and set it in the corresponding input field
                   
                    var totalAmount = quantity * (price + gstAmount);
                    productSection.find('.total-amount').val(totalAmount.toFixed(2));

                    // Recalculate totals after changes in product or quantity
                    calculateTotals();

                    // Extract unique categories from selected products
                    var selectedCategories = [];
                    $('.product-dropdown').each(function () {
                        var selectedCategory = $(this).find('option:selected').data('category');
                        if (selectedCategory) {
                            selectedCategories.push(selectedCategory);
                        }
                    });

                    // Determine the appropriate prefix based on the number of categories
                    var categoryCodes = {
                        'Food': 'FO',
                        'Electronics': 'EL',
                        'Apparel': 'AP',
                        'General': 'GA'
                    };

                    // Only default to 'GA' if there are multiple categories
                    var prefix;
                    if (selectedCategories.length > 0) {
                        // Check if all selected categories are the same
                        var uniqueCategories = [...new Set(selectedCategories)]; // Extract unique categories
                        if (uniqueCategories.length === 1) {
                            prefix = categoryCodes[uniqueCategories[0]];
                        } else {
                            prefix = categoryCodes['General'];
                        }
                    } else {
                        prefix = categoryCodes['General']; // Default to 'General' if no category is selected
                    }

                    var newNumber = data.last_sale_id;

                    // Construct the final invoice number
                    var invoiceNumber = prefix + '-' + newNumber;

                    // Set the generated invoice number in the input field
                    $('input[name="InvoiceNumber"]').val(invoiceNumber);
                },
                error: function (xhr) {
                    // Handle error response, if needed
                    console.log(xhr.responseText);
                }
            });
        });

        // Set default quantity to 1 when a product is selected
        $(document).on('change', '.product-dropdown', function () {
            var productSection = $(this).closest('.product-section');
            productSection.find('.quantity').val(1);
        });

        // Submit form using Ajax
        $("#submitForm").click(function () {
            // Check if any required field is empty
            var isEmpty = false;

            // Loop through each required input field
            $('input[required], select[required]').each(function () {
                if (!$(this).val()) {
                    isEmpty = true;
                    return false; // Exit the loop if an empty field is found
                }
            });

            // If any required field is empty, show an alert
            if (isEmpty) {
                alert("Please fill in all required fields.");
                return; // Do not proceed with form submission
            }

            // Ask for confirmation before submitting the form
            var isConfirmed = window.confirm("Are you sure you want to submit the form?");
            if (!isConfirmed) {
                return; // Do not proceed if the user cancels the confirmation
            }

            // Re-enable all product dropdown options
            $('.product-dropdown option').prop('disabled', false);

            $.ajax({
                url: $("#salesForm").attr('action'),
                type: 'post',
                data: $("#salesForm").serialize(),
                success: function (response) {
                    // Handle success response, if needed
                    console.log(response);

                    window.location.href = '/datatable'; 
                },
                error: function (xhr) {
                    // Handle error response, if needed
                    console.log(xhr.responseText);
                }
            });
        });

        // Initial calculation of totals on page load
        calculateTotals();
    });

