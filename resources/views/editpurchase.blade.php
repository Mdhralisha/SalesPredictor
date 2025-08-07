@extends('base')

@section('content')
<div class="container pt-4">
    <h2 class="text-center mb-4" style="color: #0c337c;">Edit Purchase</h2>

    <form method="POST" action="{{ route('purchase.update', $purchase->id) }}">
        @csrf
        <!-- First Row -->
        <div class="form-row">
            <div class="form-group col-md-3">
                <label>Invoice Number:</label>
                <input type="text" name="invoice_no" class="form-control" value="{{ $purchase->invoice_no }}" required>
            </div>
            <div class="form-group col-md-3">
                <label>Quantity:</label>
                <input type="number" name="purchase_quantity" class="form-control" value="{{ $purchase->purchase_quantity }}" required>
            </div>
            <div class="form-group col-md-3">
                <label>Vendor:</label>
                <select name="vendor_id" class="form-control" required>
                    <option value="">-- Select Vendor --</option>
                    @foreach ($vendors as $vendor)
                        <option value="{{ $vendor->id }}" {{ $vendor->id == $purchase->vendor_id ? 'selected' : '' }}>
                            {{ $vendor->vendor_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Product:</label>
                <select name="product_id" class="form-control" required>
                    <option value="">-- Select Product --</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ $product->id == $purchase->product_id ? 'selected' : '' }}>
                            {{ $product->product_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Second Row -->
        <div class="form-row">
            <div class="form-group col-md-3">
                <label>Purchase Price:</label>
                <input type="number" name="purchase_rate" class="form-control" value="{{ $purchase->purchase_rate }}" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Purchase</button>
        <a href="{{ route('purchase.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
