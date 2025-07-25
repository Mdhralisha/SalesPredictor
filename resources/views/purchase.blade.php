


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
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
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
    <input type="button" class="createbtn" value="Add Purchase" onclick="openModal()">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>S.N</th>
                <th>Invoice No.</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Purchase Rate</th>
                <th>Total Purchase</th>
                <th>Vendor</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>1234</td>
                <td>XYZ</td>
                <td>10pcs</td>
                <td>Rs 10</td>
                <td>Rs 100</td>
                <td>Vendor A</td>
                <td>
                    <button onclick="editPurchase(this)" class="editpurchase">Edit</button>
                    <button onclick="deletePurchase(this)" class="deletepurchase">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Add Purchase Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="purchaseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content p-4">
      <div class="modal-header">
        <h5 class="modal-title" id="purchaseModalLabel">Add Purchase</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form onsubmit="submitForm(event)">
        <div class="modal-body" d-flex justify-content-center>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label>Invoice Number:</label>
              <input type="text" class="form-control" id="invoice" required>
            </div>
            <div class="form-group col-md-3">
              <label>Quantity:</label>
              <input type="number" class="form-control" id="quantity" required>
            </div>
            <div class="form-group col-md-3">
              <label>Vendor:</label>
              <select class="form-control" id="vendor" required>
                <option value="">-- Select Vendor --</option>
                <option value="Vendor A">Vendor A</option>
                <option value="Vendor B">Vendor B</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label>Product:</label>
              <select class="form-control" id="productname" required>
                <option value="">-- Select Product --</option>
                <option value="Product A">Product A</option>
                <option value="Product B">Product B</option>
              </select>
            </div>
          </div>

          <div class="form-row align-items-end">
            <div class="form-group col-md-3">
              <label>Purchase Price:</label>
              <input type="number" class="form-control" id="purchaserate" required>
            </div>
            <div class="form-group col-md-2">
              <button type="button" class="btn btn-success" style="margin-top: 32px;">Add</button>
            </div>
         
          </div>

          <table class="table table-bordered mt-4">
            <thead>
              <tr>
                <th>S.N</th>
                <th>Invoice No.</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Purchase Rate</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>1234</td>
                <td>Product A</td>
                <td>10</td>
                <td>Rs 100</td>
                <td>Rs 1000</td>
              </tr>
            </tbody>
          </table>

          <div class="row justify-content-end text-right pr-4">
            <div class="col-md-4">
              <p><strong>Gross Total:</strong> 0</p>
              <p><strong>VAT (13%):</strong> 0</p>
              <p><strong>Net Total:</strong> 0</p>
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

<!-- JS scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
 
 function openModal() {
    $('#userModal').modal('show');
  }

  function closeModal() {
    $('#userModal').modal('hide');
  }
  

  function submitForm(e) {
    e.preventDefault();
    const invoice = document.getElementById('invoice').value;
    const productName = document.getElementById('productname').value;
    const quantity = document.getElementById('quantity').value;
    const purchaserate = document.getElementById('purchaserate').value;
    const vendor = document.getElementById('vendor').value;

    alert(`Saved:\nInvoice: ${invoice}\nProduct: ${productName}\nQty: ${quantity}\nRate: ${purchaserate}\nVendor: ${vendor}`);
    closeModal();
  }
</script>
@endsection
