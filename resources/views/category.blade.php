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
    .addcategorybtn {
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
     .editcategory{
      background: green;
      color:white;
      border: none;
      border-radius: 3px;
      width: 15%;
    
    }
    .deletecategory{
      background: red;
      color:white;
      border: none;
      border-radius: 3px;
      width: 15%;
    
    
    }
    .table.table-bordered{
      background-color: white;
      box-shadow: 0px 1px 2px gray;
    }
  
      
      
</style>
  <div class="container pt-4">
      <h1 class="userin">Product Categories !!</h1>
      <input type="button" class="addcategorybtn" value="ADD CATEGORY" onclick="openModal()">
      @if(session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
      @endif
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
                    <button onclick="editCategory(this)" title="Edit" class="editcategory">Edit</button>
                    <button onclick="deleteCategory(this)" title="Delete" class="deletecategory">Delete</button>
                </td>
              </tr>
            @endforeach
          </tbody>
      </table>
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
</script>


@endsection