@extends('base')

@section('styles')
  <!-- Bootstrap 4 CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
  <!-- Bootstrap 4 integration -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
  <!-- AdminLTE CSS (optional) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">

@endsection
@section('content')
<style>
    .userin {
        text-align: center;
        color: #6495ED;
        font-size: 30px;
        margin-bottom: 20px;
    }
    .addproductbtn {
        background-color: #0c337cff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-bottom: 20px;
        margin-left:920px;
        width: 15%;
    }
       .modal {
      display: none;
      position: fixed;
      z-index: 9999; /* Ensure it's on top */
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
    }
    

    /* Modal Box */
    .modal-content {
      background-color: #fff;
      margin: 10% auto;
      padding: 20px;
      border-radius: 8px;
      width: 400px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
      position: relative;
    }

    .modal-content h2 {
      margin-top: 0;
      text-align: center;
    }

    .modal-content input,
    .modal-content select {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .modal-content .actions {
      display: flex;
      justify-content: space-between;
      margin-top: 15px;
    }

    .modal-content .actions button {
      padding: 10px 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn-submit {
      background-color: #28a745;
      color: white;
    }

    .btn-cancel {
      background-color: #dc3545;
      color: white;
    }
</style>
  <div class="container mt-4">
      <h1 class="userin">Product Details!!</h1>
      <input type="button" class="addproductbtn" value="ADD PRODUCTS" onclick="openModal()">

      <table class="table table-bordered">
          <thead>
              <tr>
                  <th>S.N</th>
                  <th>Product Name</th>
                  <th>Product Quantity</th>
                  <th>Product Unit</th>
                  <th>purchase Rate</th>
                  <th> Sales Rate</th>
                  <th>Category Type</th>

              
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td>1</td>
                  <td>Rio Juice</td>
                  <td>10</td>
                  <td>Pcs</td>
                  <td>25</td>
                  <td>30</td>
                  <td>Beeverage</td>
          </tbody>
      </table>
  </div>
   <div class="modal" id="userModal">
  <div class="modal-content">
    <h2>Add New Product</h2>
    <form onsubmit="submitForm(event)">
      <input type="text" id="productname" placeholder="Product Name" required>
      <input type="number" id="productquantity" placeholder="Quantity" required>
      <input type="text" id="productunit" placeholder="Product Unit" required>
      <input type="number" id="purchaserate" placeholder="Purchase Rate" required>
      <input type="number" id="salesrate" placeholder="Sales Rate" required>
      <select id="categorytype" required>
        <option value="">Select Category</option>
        <option value="Beeverage">Beeverage</option>
        <option value="Soaps">Soaps</option>
        <option value="Dairy">Dairy</option>

      </select>
      <div class="actions">
        <button type="submit" class="btn-submit">ADD</button>
        <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
  function openModal() {
    document.getElementById('userModal').style.display = 'block';
  }

  function closeModal() {
    document.getElementById('userModal').style.display = 'none';
  }

  function submitForm(e) {
    e.preventDefault();
    const name = document.getElementById('productname').value;
    const quantity = document.getElementById('productquantity').value;
    const unit = document.getElementById('productunit').value;
    const prate = document.getElementById('purchaserate').value;
    const salesrate = document.getElementById('salesrate').value;
    const categorytype = document.getElementById('categorytype').value;

    alert(`User Created:\nName: ${name}\nQuantity: ${quantity}\nUnit: ${unit}\nPurchase Rate: ${prate}\nSales Rate: ${salesrate}\nCategory Type: ${categorytype}`);
    closeModal();
  }
</script>
  
  


@endsection