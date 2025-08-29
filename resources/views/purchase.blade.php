@extends('base')

@section('styles')
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('content')
<style>
    :root {
        --primary-color: #959595ff;
        --secondary-color: #0c337cff;
        --accent-color: #e74c3c;
        --success-color: #27ae60;
        --light-bg: #f8f9fa;
        --card-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
        --hover-shadow: 0 0.75rem 2rem rgba(0, 0, 0, 0.12);
    }

    .page-title {
        color: var(--primary-color);
        
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        display: inline-block;
        font-size: 30px;
    }

    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
    }

    .card-header {
        background-color: var(--primary-color);
        color: white;
        border-radius: 0.75rem 0.75rem 0 0 !important;
        padding: 1rem 1.5rem;
        font-weight: 600;
    }

    .btn-primary {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
        border-radius: 0.5rem;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        background-color: #2980b9;
        border-color: #2980b9;
        transform: translateY(-2px);
    }

    .btn-success {
        background-color: var(--success-color);
        border-color: var(--success-color);
        border-radius: 0.5rem;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
    }

    .btn-danger {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
        border-radius: 0.5rem;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
    }

    .action-btn {
        padding: 0.25rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        transform: translateY(-1px);
    }

    .table-container {
        max-height: 60vh;
        overflow-y: auto;
        border-radius: 0.75rem;
        box-shadow: var(--card-shadow);
    }

    .table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table thead th {
        background-color: white;
        color: black;
        border: none;
        padding: 1rem 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.875rem;
        
    }

    .table tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid #e9ecef;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(52, 152, 219, 0.05);
    }

    .search-box {
        border-radius: 2rem;
        padding: 0.5rem 1.25rem;
        border: 1px solid #ced4da;
        transition: all 0.3s ease;
    }

    .search-box:focus {
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        border-color: var(--secondary-color);
    }

    .modal-content {
        border: none;
        border-radius: 1rem;
        box-shadow: var(--hover-shadow);
    }

    .modal-header {
        background-color: white;
        color: black;
        border-radius: 1rem 1rem 0 0;
        padding: 1rem;
    }

    .modal-title {
        font-weight: 600;
    }

    .modal-footer {
        border-top: 1px solid #e9ecef;
        padding: 0.15rem 1rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .form-control {
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        border-color: var(--secondary-color);
    }

    .badge-total {
        background-color: var(--secondary-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-size: 1rem;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.75rem;
        }

        .table-container {
            max-height: 50vh;
        }
    }
</style>

<div class="container">
    <h1 class="page-title py-2">Purchase Management</h1>

    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-search me-2 text-muted"></i>
                    <input type="text" id="searchInput" class="form-control search-box" style="width: 250px;"
                        placeholder="Search purchases..." onkeyup="searchPurchases()" />
                </div>
                <button type="button" class="btn btn-primary d-flex align-items-center" onclick="openModal()">
                    <i class="fas fa-plus-circle me-2"></i> Add New Purchase
                </button>
            </div>

            <div class="table-container">
                <table class="table table-hover">
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
                        @foreach ($purchaseDetails as $index => $purchase)
                        <tr data-purchase-id="{{ $purchase->id }}">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $purchase->invoice_no }}</td>
                            <td>{{ $purchase->product->product_name ?? 'N/A' }}</td>
                            <td>{{ $purchase->purchase_quantity }}</td>
                            <td>Rs {{ number_format($purchase->purchase_rate, 2) }}</td>
                            <td>Rs {{ number_format($purchase->purchase_quantity * $purchase->purchase_rate, 2) }}</td>
                            <td>{{ $purchase->vendor->vendor_name ?? 'N/A' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button onclick="editPurchase(this)" class="btn btn-sm btn-success action-btn">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </button>
                                    <button onclick="deletePurchase(this)" class="btn btn-sm btn-danger action-btn">
                                        <i class="fas fa-trash-alt me-1"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Purchase Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="purchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-cart-plus me-2"></i>Add New Purchase</h5>
                <!-- <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button> -->
            </div>

            <form id="purchaseForm" onsubmit="submitForm(event)" novalidate>
                <div class="modal-body">
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label for="invoice" class="form-label">Invoice Number</label>
                            <input type="text" class="form-control" id="invoice" required>
                        </div>
                        <div class="col-md-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" min="1" step="1" required>
                        </div>
                        <div class="col-md-3">
                            <label for="vendor" class="form-label">Vendor</label>
                            <select class="form-select" id="vendor" required>
                                <option value="">-- Select Vendor --</option>
                                @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->vendor_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="productname" class="form-label">Product</label>
                            <select class="form-select" id="productname" required>
                                <option value="">-- Select Product --</option>
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 align-items-end mb-4">
                        <div class="col-md-3">
                            <label for="purchaserate" class="form-label">Purchase Price</label>
                            <input type="number" class="form-control" id="purchaserate" step="0.01" required>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-success w-100" onclick="addItem()">
                                <i class="fas fa-plus me-2"></i> Add Item
                            </button>
                        </div>
                    </div>

                    <div class="table-container mb-4" style="max-height: 200px;">
                        <table class="table table-hover" id="itemTable">
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
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-md-5">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fw-bold">Gross Total:</span>
                                        <span id="grossTotal">0.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fw-bold">VAT (13%):</span>
                                        <span id="vatAmount">0.00</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">Net Total:</span>
                                        <span class="badge-total" id="netTotal">0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal()">Cancel</button> -->
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Save Purchase
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Purchase Modal -->
<div class="modal fade" id="editPurchaseModal" tabindex="-1" aria-labelledby="editPurchaseLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Update Purchase</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>

            <form id="editPurchaseForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_purchase_id" name="id">

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="edit_invoice_no" class="form-label">Invoice No</label>
                            <input type="text" class="form-control" id="edit_invoice_no" name="invoice_no" required>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_vendor" class="form-label">Vendor</label>
                            <select class="form-select" id="edit_vendor" name="vendor_id" required>
                                <option value="">-- Select Vendor --</option>
                                @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->vendor_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_product" class="form-label">Product</label>
                            <select class="form-select" id="edit_product" name="product_id" required>
                                <option value="">-- Select Product --</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="edit_quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="edit_quantity" name="purchase_quantity" min="1" required>
                        </div>

                        <div class="col-md-3">
                            <label for="edit_purchaserate" class="form-label">Purchase Rate</label>
                            <input type="number" class="form-control" id="edit_purchaserate" name="purchase_rate" step="0.01" required>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-light rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Total Amount:</span>
                            <span class="fs-5 fw-bold text-primary" id="edit_total_amount">Rs 0.00</span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button> -->
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Update Purchase
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this purchase record? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    let itemCount = 0;
    let grossTotal = 0;
    let deletePurchaseId = null;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));

    function openModal() {
        const modal = new bootstrap.Modal(document.getElementById('userModal'));
        modal.show();
    }

    function closeModal() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('userModal'));
        modal.hide();
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

        // Validation
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
                <td>
                    <button type="button" class="btn btn-sm btn-danger action-btn" onclick="removeItem(this)">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>
        `);

        updateTotals();

        // Clear input fields for next item
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

        // Reorder SN
        $('#itemTable tbody tr').each(function(i) {
            $(this).find('td:first').text(i + 1);
        });
        itemCount = $('#itemTable tbody tr').length;
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
                location.reload();
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

    // Search Functionality
    function searchPurchases() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('table tbody tr');
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
        });
    }

    // Function to open the Update Purchase modal
    function editPurchase(button) {
        const row = $(button).closest('tr');
        const purchaseId = row.data('purchase-id');
        const invoiceNo = row.find('td:eq(1)').text().trim();
        const productName = row.find('td:eq(2)').text().trim();
        const quantity = row.find('td:eq(3)').text().trim();
        const purchaseRate = row.find('td:eq(4)').text().replace('Rs', '').replace(',', '').trim();
        const vendorName = row.find('td:eq(6)').text().trim();

        // Calculate total amount
        const totalAmount = parseFloat(quantity) * parseFloat(purchaseRate);

        // Set values in the modal form
        $('#edit_purchase_id').val(purchaseId);
        $('#edit_invoice_no').val(invoiceNo);
        $('#edit_quantity').val(quantity);
        $('#edit_purchaserate').val(purchaseRate);
        $('#edit_total_amount').text('Rs ' + totalAmount.toFixed(2));

        // Set Vendor dropdown
        $('#edit_vendor option').each(function() {
            if ($(this).text() === vendorName) {
                $(this).prop('selected', true);
                return false;
            }
        });

        // Set Product dropdown
        $('#edit_product option').each(function() {
            if ($(this).text() === productName) {
                $(this).prop('selected', true);
                return false;
            }
        });

        // Show the modal
        const modal = new bootstrap.Modal(document.getElementById('editPurchaseModal'));
        modal.show();

        // Add event listeners to update total amount when quantity or rate changes
        $('#edit_quantity, #edit_purchaserate').on('input', function() {
            const qty = parseFloat($('#edit_quantity').val()) || 0;
            const rate = parseFloat($('#edit_purchaserate').val()) || 0;
            $('#edit_total_amount').text('Rs ' + (qty * rate).toFixed(2));
        });
    }

    // Handle edit form submission
    $('#editPurchaseForm').on('submit', function(e) {
    e.preventDefault();

    const formData = $(this).serialize();
    const purchaseId = $('#edit_purchase_id').val();

    $.ajax({
        url: `/purchase/${purchaseId}`,
        method: 'PUT', // Use PUT directly
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            alert('Purchase updated successfully!');
            $('#editPurchaseModal').modal('hide');
            location.reload();
        },
        error: function(xhr) {
            console.error('Error:', xhr.responseText);
            alert('Failed to update purchase. Please check console for details.');
        }
    });
});

    // Delete purchase function
    function deletePurchase(button) {
        const row = $(button).closest('tr');
        deletePurchaseId = row.data('purchase-id');

        // Show confirmation modal
        deleteModal.show();
    }

    // Confirm deletion
    $('#confirmDeleteBtn').on('click', function() {
        if (deletePurchaseId) {
            $.ajax({
                url: `/purchases/${deletePurchaseId}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    alert('Purchase deleted successfully!');
                    deleteModal.hide();
                    location.reload();
                },
                error: function(xhr) {
                    alert('Failed to delete purchase. Please try again.');
                    deleteModal.hide();
                }
            });
        }
    });
</script>
@endsection