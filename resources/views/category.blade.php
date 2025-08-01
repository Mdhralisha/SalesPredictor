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
         color: #0c337c;
        font-size: 30px;
        margin-bottom: 20px;
        margin-top: 20px;
    }
.addcategorybtn {
        background-color: #0c337cff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 200px; /* or auto */
}    /* .addcategorybtn {
    
        background-color: #0c337c;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-bottom: 20px;
        margin-left:920px;
        width: 15%;
    } */
    
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
     .editcategory{
      background: green;
      color:white;
      border: none;
      border-radius: 3px;
      width: 15%;
    
    }
    .editcategory:hover {
      background: #31684fff;
    }
    .deletecategory{
      background: red;
      color:white;
      border: none;
      border-radius: 3px;
      width: 15%;
    
    
    }
    .deletecategory:hover {
      background: #642f2fff;
    }
    .table.table-bordered{
      background-color: white;
      box-shadow: 0px 1px 2px gray;
    }
     .addcategorybtn:hover {
    background-color: #334258ff;
  }
  .btn-submit:hover {
    background-color: #3f6147ff;
  }

  .btn-cancel:hover {
    background-color: #794b4fff;
  }
  
      
      
</style>
  <div class="container pt-4">
      <h1 class="userin">Product Categories !!</h1>
  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
  <div class="d-flex align-items-center mr-3">
  <label for="searchInput" class="mr-2 mb-0" style="font-weight: normal;">Search:</label>
  <input type="text" id="searchInput" class="form-control" style="width: 250px;" placeholder="Search Categories..." onkeyup="searchCategories()" />
</div>
      <input type="button" class="addcategorybtn" value="ADD CATEGORY" onclick="openModal()">
      </div>
      @if(session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
      @endif
      <div style="height: 60vh;overflow-y:scroll">
      <table class="table table-bordered">
          <thead>
              <tr>
                  <th>S.N</th>
                  <th>Category Type</th>
                  <th>Actions</th>
              
              </tr>
          </thead>
          <tbody>
            @foreach($categories as $index => $category)
              <tr>
                  <td>{{ $index+1 }}</td>
                  <td>{{ $category->category_name }}</td>
                  <td>  
                    <button onclick="editCategory(this)" title="Edit" class="editcategory"  
                     data-id="{{ $category->id }}" 
                     data-name="{{ $category->category_name }}">Edit</button>
                    <button onclick="deleteCategory(this)" data-id="{{ $category->id }}" title="Delete" class="deletecategory">Delete</button>
                </td>
              </tr>
            @endforeach
          </tbody>
      </table>
      </div>
  </div>
   <div class="modal" id="userModal">
  <div class="modal-content">
    <h2>Add Category</h2>
    <!-- <form onsubmit="submitForm(event)"> -->
      <form method="POST" action="{{ route('category.store') }}">
      @csrf
      <input type="text" id="categoryy" placeholder="Category Name" name="category_name" required>
     
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
    const categoryy = document.getElementById('categoryy').value;
    
    alert(`User added:\nCategory: ${categoryy}`);
    closeModal();
  }
    function editCategory(button) {
  const id = button.getAttribute('data-id');
  const name = button.getAttribute('data-name');

  // Fill modal form
  document.getElementById('edit_categoryname').value = name;
  document.getElementById('edit_category_id').value = id;

  // Set form action dynamically
  document.getElementById('editCategoryForm').action = '/category/' + id;

  // Show modal
  document.getElementById('editModal').style.display = 'block';
}
  

  function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
  }


function deleteCategory(button) {
  const id = button.getAttribute('data-id');
  document.getElementById('deleteCategoryForm').action = '/category/' + id;
  document.getElementById('deleteModal').style.display = 'block';
}

  function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
  }


//Search Functionality
   function searchCategories() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('table tbody tr');
    rows.forEach(row => {
      row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
    });
  }

</script>

<div class="modal" id="editModal">
  <div class="modal-content">
    <h2>Edit Category</h2>
    <form id="editCategoryForm" method="POST" action="">
      @csrf
      @method('PUT')
    
      <input type="text" id="edit_category_id" name="id" hidden>
      <input type="text" id="edit_categoryname" placeholder="Category Name" required name="categoryname">
     
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
    
    <p style="text-align: center; font-size: 20px;">Are you sure you want to delete this Category?</p>
    <form id="deleteCategoryForm" method="POST">
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