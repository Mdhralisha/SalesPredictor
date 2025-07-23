@extends('base')

@section('styles')
<!-- Bootstrap 4 CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
    margin-top: 20px;
  }

  .addproductbtn {
    background-color: #0c337cff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 20px;
    margin-left: 920px;
    width: 15%;
  }

  .modal {
    display: none;
    position: fixed;
    z-index: 9999;
    /* Ensure it's on top */
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
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
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

  .editproduct {
    background: green;
    color: white;
    border: none;
    border-radius: 3px;
    width: 35%;

  }

  .deleteproduct {
    background: red;
    color: white;
    border: none;
    border-radius: 3px;
    width: 45%;

  }

  .table.table-bordered {
    background-color: white;
    box-shadow: 0px 1px 2px gray;
  }

</style>
<div class="container pt-4">
  <h1 class="userin">Product Details!!</h1>
  <input type="button" class="addproductbtn" value="ADD PRODUCTS" onclick="openModal()">
  <div style="height: 60vh;overflow-y:scroll">
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
        <th>Actions</th>



      </tr>
    </thead>
    <tbody>
      @foreach($products as $index => $product)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $product->product_name }}</td>
        <td>{{ $product->product_quantity }}</td>
        <td>{{ $product->product_unit }}</td>
        <td>{{ $product->product_rate }}</td>
        <td>{{ $product->sales_rate }}</td>
        <td>{{ $product->category->category_name }}</td> <!-- Make sure you have relationship set up -->
        <td>
          <button onclick="editProduct(this)" title="Edit" class="editproduct"

            data-id="{{ $product->id }}"
            data-name="{{ $product->product_name }}"
            data-qty="{{ $product->product_quantity }}"
            data-unit="{{ $product->product_unit }}"
            data-prate="{{ $product->product_rate }}"
            data-srate="{{ $product->sales_rate }}"
            data-category="{{ $product->category_id }}">Edit</button>
          <button onclick="deleteProduct(this)" title="Delete" class="deleteproduct"
            data-id="{{ $product->id }}">Delete</button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
</div>
<div class="modal" id="userModal">
  <div class="modal-content">
    <h2>Add New Product</h2>
    <form action="{{ route('product.store') }}" method="POST">
      @csrf
      <input type="text" id="productname" placeholder="Product Name" required name="productname">
      <input type="number" id="productquantity" placeholder="Quantity" required name="productquantity">

      <select id="productunit" name="productunit" required>
        <option value="">Select Product Unit</option>
        <option value="kg">Kg</option>
        <option value="litre">Litre</option>
        <option value="pcs">Pcs</option>


      </select>
      <input type="number" id="purchaserate" placeholder="Purchase Rate" required name="purchaserate">
      <input type="number" id="salesrate" placeholder="Sales Rate" required name="salesrate">
      <select id="categorytype" name="category" required>
        <option value="">Select Category</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
        @endforeach
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


  function editProduct(button) {

    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const qty = button.getAttribute('data-qty');
    const unit = button.getAttribute('data-unit');
    const prate = button.getAttribute('data-prate');
    const srate = button.getAttribute('data-srate');
    const category = button.getAttribute('data-category');

    // Fill modal form
    document.getElementById('edit_product_id').value = id;
    document.getElementById('edit_productname').value = name;
    document.getElementById('edit_productquantity').value = qty;
    document.getElementById('edit_productunit').value = unit;
    document.getElementById('edit_purchaserate').value = prate;
    document.getElementById('edit_salesrate').value = srate;
    document.getElementById('edit_categorytype').value = category;

    // Set form action dynamically
    document.getElementById('editProductForm').action = '/product/' + id;

    // Show modal
    document.getElementById('editModal').style.display = 'block';
  }

  function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
  }




  function deleteProduct(button) {
    // Set action URL
    const id = button.getAttribute('data-id');
    const form = document.getElementById('deleteProductForm');
    form.action = '/product/' + id;

    // Show the modal
    document.getElementById('deleteModal').style.display = 'block';
  }

  function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
  }
</script>
<div class="modal" id="editModal">
  <div class="modal-content">
    <h2>Edit Product</h2>
    <form id="editProductForm" method="POST">
      @csrf
      @method('PUT')
      <input type="hidden" id="edit_product_id" name="product_id">
      <input type="text" id="edit_productname" placeholder="Product Name" required name="productname">
      <input type="number" id="edit_productquantity" placeholder="Quantity" required name="productquantity">

      <select id="edit_productunit" name="productunit" required>
        <option value="">Select Units</option>
        <option value="kg">Kg</option>
        <option value="litre">Litre</option>
        <option value="pcs">Pcs</option>
      </select>
      <input type="number" id="edit_purchaserate" placeholder="Purchase Rate" required name="purchaserate">
      <input type="number" id="edit_salesrate" placeholder="Sales Rate" required name="salesrate">
      <select id="edit_categorytype" name="category" required>
        <option value="">Select Category</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
        @endforeach
      </select>
      <div class="actions">
        <button type="submit" class="btn-submit">Update</button>
        <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
      </div>
    </form>
  </div>
</div>


<!-- Delete Product Functionality -->
<div class="modal" id="deleteModal">
  <div class="modal-content">

    <p style="text-align: center; font-size: 20px;">Are you sure you want to delete this product?</p>
    <form id="deleteProductForm" method="POST">
      @csrf
      @method('DELETE')
      <div class="actions">
        <button type="submit" class="btn-submit" style="background: green; margin-left: 100px;">Delete</button>
        <button type="button" class="btn-cancel" style="background: red; margin-right: 70px;" onclick="closeDeleteModal()">Cancel</button>
      </div>
    </form>
  </div>
</div>




@endsection