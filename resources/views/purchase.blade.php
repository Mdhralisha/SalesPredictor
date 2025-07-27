@extends('base')

@section('styles')
<!-- Bootstrap 4 CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection

@section('content')
<style>
    .userin {
        text-align: center;
        color: #6495ED;
        font-size: 30px;
        margin-bottom: 20px;
        margin-top: 20px;
    }

    .createbtn {
        background-color: #0c337c;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        float: right;
        margin-bottom: 20px;
    }

    .editpurchase {
        background-color: green;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    .deletepurchase {
        background-color: #dc3545;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
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

    .modal-body table {
        margin-top: 20px;
    }

    .modal-body .row p {
        margin: 0;
    }
</style>

<div class="container pt-4">
    <h1 class="userin">Purchase Details!!</h1>
    <button type="button" class="createbtn" onclick="openModal()">Add Purchase</button>
    <div style="height: 60vh;overflow-y:scroll">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Invoice No.</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Purchase Price</th>
                    <th>Total Purchase</th>
                    <th>Vendor Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Existing purchase rows will be here -->
                @foreach ($purchaseDetails as $index => $purchase)

                @endforeach
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $purchase->invoice_no }}</td>
                    <td>{{ $purchase->product->product_name ?? 'N/A' }}</td>
                    <td>{{ $purchase->purchase_quantity }}</td>
                    <td>Rs {{ number_format($purchase->purchase_rate, 2) }}</td>
                    <td>Rs {{ number_format($purchase->purchase_quantity * $purchase->purchase_rate, 2) }}</td>
                    <td>{{ $purchase->vendor->vendor_name ?? 'N/A' }}</td>
                    <td>
                        <button onclick="editPurchase(this)" class="editpurchase">Edit</button>
                        <button onclick="deletePurchase(this)" class="deletepurchase">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="purchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title">Add Purchases</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="purchaseForm" onsubmit="submitForm(event)" novalidate>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Invoice Number:</label>
                            <input type="text" class="form-control" id="invoice">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Quantity:</label>
                            <input type="number" class="form-control" id="quantity">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Vendor:</label>
                            <select class="form-control" id="vendor">
                                <option value="">-- Select Vendor --</option>
                                @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->vendor_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Product:</label>
                            <select class="form-control" id="productname">
                                <option value="">-- Select Product --</option>
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row align-items-end">
                        <div class="form-group col-md-3">
                            <label>Purchase Price:</label>
                            <input type="number" class="form-control" id="purchaserate">
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
                                <th>Purchase Price</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- dynamically added rows here -->
                        </tbody>
                    </table>

                    <div class="row justify-content-end text-right pr-4">
                        <div class="col-md-4">
                            <p><strong>Gross Total:</strong> <span id="grossTotal">0</span></p>
                            <p><strong>VAT (13%):</strong> <span id="vatAmount">0</span></p>
                            <p><strong>Net Total:</strong> <span id="netTotal">0</span></p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
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
        $('#userModal').modal('show');
    }

    function closeModal() {
        $('#userModal').modal('hide');
        resetForm();
    }

    function resetForm() {
        $('#invoice').val('');
        $('#quantity').val('');
        $('#vendor').val('');
        $('#productname').val('');
        $('#purchaserate').val('');
        $('#itemTable tbody').empty();
        itemCount = 0;
        grossTotal = 0;
        updateTotals();
    }

    function addItem() {
        const invoice = $('#invoice').val();
        const quantity = parseInt($('#quantity').val());
        const vendorId = $('#vendor').val();
        const vendorText = $("#vendor option:selected").text();
        const productId = $('#productname').val();
        const productText = $('#productname option:selected').text();
        const purchaserate = parseFloat($('#purchaserate').val());

        // Manual validation here instead of required attribute
        if (!invoice || !quantity || !vendorId || !productId || !purchaserate) {
            alert('Please fill in all fields.');
            return;
        }

        const total = quantity * purchaserate;
        itemCount++;
        grossTotal += total;

        $('#itemTable tbody').append(`
            <tr data-total="${total}" data-vendor-id="${vendorId}" data-product-id="${productId}">
                <td>${itemCount}</td>
                <td>${invoice}</td>
                <td>${productText}</td>
                <td>${quantity}</td>
                <td>${purchaserate.toFixed(2)}</td>
                <td>${total.toFixed(2)}</td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)">Remove</button></td>
            </tr>
        `);

        updateTotals();

        // Clear quantity, product, purchase rate but keep invoice and vendor to add multiple items easily
        $('#quantity').val('');
        $('#productname').val('');
        $('#purchaserate').val('');
    }

    function removeItem(btn) {
        const row = $(btn).closest('tr');
        const total = parseFloat(row.attr('data-total'));
        grossTotal -= total;
        row.remove();
        updateTotals();
        itemCount = $('#itemTable tbody tr').length;
        // Reorder SN
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
            alert('Please add at least one purchase item before saving.');
            return;
        }

        const purchases = [];
        rows.each(function() {
            const row = $(this);
            purchases.push({
                invoice_no: row.find('td:eq(1)').text(),
                quantity: parseInt(row.find('td:eq(3)').text()),
                vendor_id: row.data('vendor-id'),
                product_id: row.data('product-id'),
                purchase_rate: parseFloat(row.find('td:eq(4)').text()),
                total: parseFloat(row.find('td:eq(5)').text())
            });
        });

        $.ajax({
            url: '{{ route("purchase.saveMultiple") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                purchases: purchases
            },
            success: function(response) {
                alert('Purchases saved successfully!');
                closeModal();
                location.reload(); // Reload page to show new data (or update table dynamically)
            },
            error: function(xhr) {
                alert('Failed to save purchases. Please try again.');
            }
        });
    }

    $('#vendor').on('change', function() {
        const vendorId = $(this).val();
        const productSelect = $('#productname');
        productSelect.empty().append('<option value="">Loading...</option>');

        if (vendorId) {
            $.ajax({
                url: `/get-products-by-vendor/${vendorId}`,
                type: 'GET',
                success: function(data) {
                    productSelect.empty().append('<option value="">-- Select Product --</option>');
                    data.forEach(function(product) {
                        productSelect.append(`<option value="${product.id}">${product.product_name}</option>`);
                    });
                },
                error: function() {
                    productSelect.empty().append('<option value="">Error loading products</option>');
                }
            });
        } else {
            productSelect.empty().append('<option value="">-- Select Product --</option>');
        }
    });

    $('#productname').on('change', function() {
        const productId = $(this).val();
        if (productId) {
            $.ajax({
                url: `/get-product-price/${productId}`,
                type: 'GET',
                success: function(data) {
                    $('#purchaserate').val(data.purchase_rate || '');
                },
                error: function() {
                    $('#purchaserate').val('');
                    alert('Failed to load purchase price.');
                }
            });
        } else {
            $('#purchaserate').val('');
        }
    });
</script>
@endsection