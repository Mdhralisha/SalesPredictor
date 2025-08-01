@extends('base')

@section('styles')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection

@section('content')
<style>
    /* Your existing styles here (same as you provided) */
    .userin {
        text-align: center;
        color: #0c337c;
        font-size: 30px;
        margin-bottom: 20px;
        margin-top: 20px;
    }
    /* .createbtn {
        background-color: #0c337c;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        float: right;
        margin-bottom: 20px;
    } */

        


  .createbtn{
       background-color: #0c337cff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 200px; /* or auto */
    }
    .editsales {
        background-color: green;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }
    .editsales:hover {
        background-color: #31684f;
    }
    .deletesales {
        background-color: #dc3545;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }
    .deletesales:hover {
        background-color: #6e3e43;
    }
    
    .table.table-bordered {
        background-color: white;
        box-shadow: 0px 1px 2px gray;
    }
    .modal-content {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        padding: 20px;
    }
    .modal-title {
        color: #333;
    }
    .modal-footer button {
        width: 150px;
    }
    .createbtn:hover {
        background-color: #45536eff;
    }
</style>

<div class="container pt-4">
    <h1 class="userin">Sales Details!!</h1>
      <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
  <div class="d-flex align-items-center mr-3">
  <label for="searchInput" class="mr-2 mb-0" style="font-weight: normal;">Search:</label>
  <input type="text" id="searchInput" class="form-control" style="width: 250px;" placeholder="Search Sales..." onkeyup="searchSales()" />
</div>
    <button type="button" class="createbtn" onclick="openModal()">Add Sales</button>
</div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Invoice No.</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Sale Price</th>
                    <th>Total Sales</th>
                    <th>Customer Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $index => $sale)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $sale->invoice_no }}</td>
                    <td>{{ $sale->product->product_name ?? 'N/A' }}</td>
                    <td>{{ $sale->sales_quantity }}</td>
                    <td>Rs {{ number_format($sale->sales_rate, 2) }}</td>
                    <td>Rs {{ number_format($sale->sales_quantity * $sale->sales_rate, 2) }}</td>
                    <td>{{ $sale->customer->customer_name ?? 'N/A' }}</td>
                    <td>
                        <button onclick="editSales(this)" class="editsales">Edit</button>
                        <button onclick="deleteSales(this)" class="deletesales">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
  
</div>

<!-- Modal -->
<div class="modal fade" id="salesModal" tabindex="-1" role="dialog" aria-labelledby="salesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title">Add Sales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="salesForm" onsubmit="submitForm(event)" novalidate>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Invoice Number:</label>
                            <input type="text" class="form-control" id="invoice" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Quantity:</label>
                            <input type="number" class="form-control" id="quantity" min="1" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Customer:</label>
                            <select class="form-control" id="customer" required>
                                <option value="">-- Select Customer --</option>
                                @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Product:</label>
                            <select class="form-control" id="productname" required>
                                <option value="">-- Select Product --</option>
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row align-items-end">
                        <div class="form-group col-md-3">
                            <label>Sales Price:</label>
                            <input type="number" class="form-control" id="salesrate" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <button type="button" class="btn btn-success" style="margin-top: 32px;" onclick="addItem()">Add</button>
                        </div>
                    </div>

                    <table class="table table-bordered mt-4" id="itemTable">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Invoice No.</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Sale Price</th>
                                <th>Total Sales</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <div class="row justify-content-end text-right pr-4">
                        <div class="col-md-4">
                            <p><strong>Gross Total:</strong> <span id="grossTotal">0.00</span></p>
                            <p><strong>VAT (13%):</strong> <span id="vatAmount">0.00</span></p>
                            <p><strong>Net Total:</strong> <span id="netTotal">0.00</span></p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Sales</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    let itemCount = 0;
    let grossTotal = 0;

    function openModal() {
        $('#salesModal').modal('show');
    }

    function closeModal() {
        $('#salesModal').modal('hide');
        resetForm();
    }

    function resetForm() {
        $('#invoice, #quantity, #salesrate').val('');
        $('#customer, #productname').val('');
        $('#itemTable tbody').empty();
        itemCount = 0;
        grossTotal = 0;
        updateTotals();
    }

    function addItem() {
        const invoice = $('#invoice').val().trim();
        const quantity = parseInt($('#quantity').val());
        const customerId = $('#customer').val();
        const productId = $('#productname').val();
        const productText = $('#productname option:selected').text();
        const salesrate = parseFloat($('#salesrate').val());

        if (!invoice) {
            alert('Invoice Number is required');
            return;
        }
        if (!quantity || quantity <= 0) {
            alert('Quantity must be a positive number');
            return;
        }
        if (!customerId) {
            alert('Please select a Customer');
            return;
        }
        if (!productId) {
            alert('Please select a Product');
            return;
        }
        if (!salesrate || salesrate <= 0) {
            alert('Sales Price must be a positive number');
            return;
        }

        const total = quantity * salesrate;
        itemCount++;
        grossTotal += total;

        $('#itemTable tbody').append(`
            <tr data-total="${total}" data-customer-id="${customerId}" data-product-id="${productId}" data-invoice="${invoice}">
                <td>${itemCount}</td>
                <td>${invoice}</td>
                <td>${productText}</td>
                <td>${quantity}</td>
                <td>${salesrate.toFixed(2)}</td>
                <td>${total.toFixed(2)}</td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)">Remove</button></td>
            </tr>
        `);

        updateTotals();

        // Reset fields except invoice and customer (usually same invoice/customer for multiple items)
        $('#quantity, #productname, #salesrate').val('');
    }

    function removeItem(btn) {
        const row = $(btn).closest('tr');
        const total = parseFloat(row.data('total'));
        grossTotal -= total;
        row.remove();
        updateTotals();

        itemCount = $('#itemTable tbody tr').length;
        $('#itemTable tbody tr').each(function(i) {
            $(this).find('td:first').text(i + 1);
        });
    }

    function updateTotals() {
        const vat = grossTotal * 0.13;
        const net = grossTotal + vat;
        $('#grossTotal').text(grossTotal.toFixed(2));
        $('#vatAmount').text(vat.toFixed(2));
        $('#netTotal').text(net.toFixed(2));
    }

    function submitForm(e) {
        e.preventDefault();

        const rows = $('#itemTable tbody tr');
        if (rows.length === 0) {
            alert('Please add at least one sales item before saving.');
            return;
        }

        const sales = [];
        rows.each(function () {
            const row = $(this);
            sales.push({
                invoice_no: row.data('invoice'),
                quantity: parseInt(row.find('td:eq(3)').text()),
                customer_id: row.data('customer-id'),
                product_id: row.data('product-id'),
                sales_rate: parseFloat(row.find('td:eq(4)').text()),
                total: parseFloat(row.find('td:eq(5)').text())
            });
        });

        $.ajax({
            url: '{{ route("sales.saveMultiple") }}',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                _token: '{{ csrf_token() }}',
                sales: sales
            }),
            success: function (response) {
                alert(response.message || 'Sales saved successfully!');
                closeModal();
                location.reload();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                let errMsg = 'Failed to save sales.';
                if(xhr.responseJSON && xhr.responseJSON.errors) {
                    errMsg = Object.values(xhr.responseJSON.errors).flat().join("\n");
                } else if (xhr.responseJSON && xhr.responseJSON.error) {
                    errMsg = xhr.responseJSON.error;
                }
                alert(errMsg);
            }
        });
    }

    $('#productname').on('change', function () {
        const productId = $(this).val();
        if (productId) {
            $.get(`/get-product-sale-price/${productId}`, function (data) {
                $('#salesrate').val(data.sales_rate || '');
            }).fail(function () {
                $('#salesrate').val('');
                alert('Failed to fetch sales price.');
            });
        } else {
            $('#salesrate').val('');
        }
    });


    
    // Search Functionality
      function searchSales() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('table tbody tr');
    rows.forEach(row => {
      row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
    });
  }
</script>
@endsection
