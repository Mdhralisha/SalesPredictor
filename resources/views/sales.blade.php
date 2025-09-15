@extends('base')

@section('styles')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .userin {
        color: #82868dff;
        font-size: 30px;
        margin-bottom: 20px;
        margin-top: 20px;
    }

    .createbtn {
        background-color: #0c337cff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 200px;
    }

    .createbtn:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
    }

    .editsales {
        background: #27ae60;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
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
        border-radius: 5px;
        cursor: pointer;
    }

    .deletesales:hover {
        background-color: #6e3e43;
    }

    .table.table-bordered {
        background-color: white;
        box-shadow: 0px 1px 2px gray;
        border-radius: 15px;
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

    #searchInput {
        margin-left: 10px;
    }

    .edit-modal,
    .delete-modal {
        display: none;
        position: fixed;
        z-index: 1050;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        overflow: hidden;
    }

    .edit-modal-content,
    .delete-modal-content {
        background: #fff;
        margin: 3% auto;
        padding: 20px;
        border-radius: 12px;
        width: 60%;
        max-width: 600px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .delete-modal-content {
        width: 30%;
        margin: 15% auto;
    }

    .btn-submit {
        background-color: #28a745;
        color: white;
    }

    .btn-cancel {
        background-color: #dc3545;
        color: white;
    }

    .btn-submit:hover {
        background-color: #3f6147ff;
    }

    .btn-cancel:hover {
        background-color: #794b4fff;
    }

    .table-container {
        max-height: 60vh;
        overflow-y: auto;
        border-radius: 0.75rem;
        box-shadow: var(--card-shadow);
    }
</style>
@endsection

@section('content')
<div class="container pt-4">
    <h1 class="userin">Sales Management</h1>
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <div class="d-flex align-items-center mr-3">
            <i class="fas fa-search me-2 text-muted"></i>
            <input type="text" id="searchInput" class="form-control" style="width: 250px;" placeholder="Search Sales..." onkeyup="searchSales()" />
        </div>
        <button type="button" class="createbtn" onclick="openModal()">
            <i class="fas fa-plus-circle me-2"></i> Add Sales
        </button>
    </div>
     @if(session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
      @endif

    <div class="table-container">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Invoice No.</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Sale Price</th>
                    <th>Dis. Amnt</th>
                    <th>Total Sales</th>
                    <th>Customer Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $index => $sale)
                <tr data-sale-id="{{ $sale->id }}">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $sale->invoice_no }}</td>
                    <td>{{ $sale->product->product_name ?? 'N/A' }}</td>
                    <td>{{ $sale->sales_quantity }}</td>
                    <td>Rs {{ number_format($sale->sales_rate, 2) }}</td>
                    <td>Rs {{ number_format($sale->sales_discount, 2) }}</td>
                    <td>Rs {{ number_format(($sale->sales_quantity * $sale->sales_rate)-$sale->sales_discount, 2) }}</td>
                    <td>{{ $sale->customer->customer_name ?? 'N/A' }}</td>
                    <td>
                        <button onclick="editSales(this)" class="editsales">
                            <i class="fas fa-edit me-1"></i> Edit
                        </button>
                        <button onclick="deleteSales(this)" class="deletesales">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Sales Modal -->
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
                            <input type="text" class="form-control" id="invoice" value="{{ $invoice_no ?? '' }}" readonly>
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
                        <div class="form-group col-md-3">
                            <label>Discount Amount:</label>
                            <input type="number" class="form-control" id="discountAmnt">
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
                                <th>Discount</th>
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

<!-- Edit Sales Modal -->
<div id="editSalesModal" class="edit-modal">
    <div class="edit-modal-content">
        <h2 style="text-align: center;">Edit Sales</h2>
        <form id="editSalesForm">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_sale_id" name="id">

            <div class="form-group">
                <input type="text" class="form-control" id="edit_invoice_no" name="invoice_no" required hidden>
            </div>

            <div class="form-group">
                <label for="edit_customer">Customer:</label>
                <select class="form-control" id="edit_customer" name="customer_id" required>
                    <option value="">-- Select Customer --</option>
                    @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="edit_product">Product:</label>
                <select class="form-control" id="edit_product" name="product_id" required>
                    <option value="">-- Select Product --</option>
                    @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="edit_quantity">Quantity:</label>
                <input type="number" class="form-control" id="edit_quantity" name="sales_quantity" min="1" required>
            </div>

            <div class="form-group">
                <label for="edit_sales_rate">Sales Price:</label>
                <input type="number" class="form-control" id="edit_sales_rate" name="sales_rate" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="edit_discount">Discount:</label>
                <input type="number" class="form-control" id="edit_discount" name="sales_discount" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="edit_total_amount">Total Amount:</label>
                <input type="text" class="form-control" id="edit_total_amount" readonly>
            </div>

            <div class="actions" style="text-align: center; margin-top: 20px;">
                <button type="submit" class="btn btn-success">Update</button>
                <button type="button" class="btn btn-danger" onclick="closeEditModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteSalesModal" class="delete-modal">
    <div class="delete-modal-content">
        <p style="text-align: center; font-size: 20px;">Are you sure you want to delete this sale?</p>
        <form id="deleteSalesForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="actions" style="text-align: center;">
                <button type="submit" class="btn btn-success">Delete</button>
                <button type="button" class="btn btn-danger" onclick="closeDeleteModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    let itemCount = 0;
    let grossTotal = 0;
    let currentSaleId = null;

    function openModal() {
        $('#salesModal').modal('show');
        // Auto-generate invoice number if not provided
        $.get('{{ route("sales.latestInvoice") }}', function(data) {
            $('#invoice').val(data.invoice_no);
        }).fail(function() {
            $('#invoice').val('');
            alert('Failed to fetch invoice number.');
        });
    }

    function closeModal() {
        $('#salesModal').modal('hide');
        resetForm();
    }

    function resetForm() {
        $('#quantity, #salesrate, #discountAmnt').val('');
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
        const discountAmnt = parseFloat($('#discountAmnt').val()) || 0;

        if (!invoice || !quantity || !customerId || !productId || !salesrate) {
            alert('Please fill all required fields correctly.');
            return;
        }

        const total = (quantity * salesrate) - discountAmnt;
        itemCount++;
        grossTotal += total;

        $('#itemTable tbody').append(`
            <tr data-total="${total}" data-customer-id="${customerId}" data-product-id="${productId}" data-invoice="${invoice}">
                <td>${itemCount}</td>
                <td>${invoice}</td>
                <td>${productText}</td>
                <td>${quantity}</td>
                <td>${salesrate.toFixed(2)}</td>
                <td>${discountAmnt.toFixed(2)}</td>
                <td>${total.toFixed(2)}</td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)">Remove</button></td>
            </tr>
        `);
        updateTotals();
        $('#quantity, #productname, #salesrate, #discountAmnt').val('');
    }

    function removeItem(btn) {
        const row = $(btn).closest('tr');
        grossTotal -= parseFloat(row.data('total'));
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
            alert('Add at least one item.');
            return;
        }

        const sales = [];
        rows.each(function() {
            const row = $(this);
            sales.push({
                invoice_no: row.data('invoice'),
                quantity: parseInt(row.find('td:eq(3)').text()),
                customer_id: row.data('customer-id'),
                product_id: row.data('product-id'),
                sales_rate: parseFloat(row.find('td:eq(4)').text()),
                total: parseFloat(row.find('td:eq(6)').text()),
                sales_discount: parseFloat(row.find('td:eq(5)').text()),
            });
        });

        $.ajax({
            url: '{{ route("sales.saveMultiple") }}',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                _token: '{{ csrf_token() }}',
                sales
            }),
            success: function(resp) {
                alert(resp.message || 'Saved!');
                closeModal();
                location.reload();
            },
            error: function(xhr) {
                let errMsg = 'Failed to save.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errMsg = Object.values(xhr.responseJSON.errors).flat().join("\n");
                } else if (xhr.responseJSON && xhr.responseJSON.error) {
                    errMsg = xhr.responseJSON.error;
                }
                alert(errMsg);
            }
        });
    }

    $('#productname').on('change', function() {
        const productId = $(this).val();
        if (productId) {
            $.get(`/get-product-sale-price/${productId}`, function(data) {
                    $('#salesrate').val(data.sales_rate || '');
                })
                .fail(() => {
                    $('#salesrate').val('');
                    alert('Failed to fetch price.');
                });
        } else {
            $('#salesrate').val('');
        }
    });

    $('#edit_product').on('change', function() {
        const productId = $(this).val();
        if (productId) {
            $.get(`/get-product-sale-price/${productId}`, function(data) {
                    $('#edit_sales_rate').val(data.sales_rate || '');
                })
                .fail(() => {
                    $('#edit_sales_rate').val('');
                    alert('Failed to fetch price.');
                });
        } else {
            $('#edit_sales_rate').val('');
        }
    });

    function searchSales() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('table tbody tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
        });
    }

    function editSales(btn) {
        const row = $(btn).closest('tr');
        const saleId = row.data('sale-id');
        const customerId = row.find('td:eq(7)').text();
        const productId = row.find('td:eq(2)').text();
        const quantity = row.find('td:eq(3)').text();
        const salesRate = row.find('td:eq(4)').text();
        const discount = row.find('td:eq(5)').text();
        const invoiceNo = row.find('td:eq(1)').text();

        $('#edit_sale_id').val(saleId);
        $('#edit_invoice_no').val(invoiceNo);
        $('#edit_customer').val(customerId);
        $('#edit_product').val(productId);
        $('#edit_quantity').val(quantity);
        $('#edit_sales_rate').val(salesRate);
        $('#edit_discount').val(discount);
        $('#edit_total_amount').val((quantity * salesRate - discount).toFixed(2));

        $('#editSalesModal').fadeIn();
    }

    function closeEditModal() {
        $('#editSalesModal').fadeOut();
    }

    function deleteSales(btn) {
        const row = $(btn).closest('tr');
        const saleId = row.data('sale-id');
        $('#deleteSalesForm').attr('action', `/sales/${saleId}`);
        $('#deleteSalesModal').fadeIn();
    }

    function closeDeleteModal() {
        $('#deleteSalesModal').fadeOut();
    }
</script>
@endsection