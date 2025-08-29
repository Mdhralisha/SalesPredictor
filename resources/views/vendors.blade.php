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
       
      color: #74767aff;
        font-size: 30px;
        margin-bottom:20px;
        margin-top: 20px;
    }
    /* .createbtn {
        background-color: #0c337cff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-bottom: 20px;
        margin-left:920px;
        width: 15%;
    } */
        .createbtn {
        background-color: #0c337cff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 200px; /* or auto */
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
      width: 25% ;
      margin-left: 40px;
    }

    .btn-cancel {
      background-color: #dc3545;
      color: white;
      width: 25% ;
      margin-right: 40px;

    }
      .editvendor{
      background:  #27ae60;
      color:white;
      border: none;
      border-radius: 5px;
      width: 35%;
    
    }
    .deletevendor{
      background: red;
      color:white;
      border: none;
      border-radius: 5px;
      width: 40%;
    

    }
    .editvendor:hover {
      background: #31684fff;
    }
    .deletevendor:hover {
      background: #642f2fff;
    }
    .confirm {
        text-align: center;
        margin-bottom: 20px;
        font-family: sans-serif;
        font-size: 20px;
    }
      .table.table-bordered{
      background-color: white;
      box-shadow: 0px 1px 2px gray;
      border-radius: 15px;
    }
    .createbtn:hover {
       background-color: #2980b9;
        border-color: #2980b9;
        transform: translateY(-2px);
    }
    .btn-submit:hover {
        background-color: #405b46ff;
    }
   .btn-cancel:hover{
    background-color: #7a4545ff
   }
   .btn-delete:hover {
    background-color: #4b6c5eff;
   }


     #searchInput {
    margin-left: 10px; /* Space for the icon */
  }




  
      
</style>
  <div class="container pt-4">
      <h1 class="userin">Vendor Management</h1>
 <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
  <div class="d-flex align-items-center mr-3">
  <!-- <label for="searchInput" class="mr-2 mb-0" style="font-weight: normal;">Search:</label> -->
     <i class="fas fa-search me-2 text-muted"></i>  
  <input type="text" id="searchInput" class="form-control" style="width: 250px;" placeholder="Search vendors..." onkeyup="searchVendors()" />
</div>
<!-- 
      <input type="button" class="createbtn" value="Add vendor"  onclick="openModal()"> -->
      <button class="createbtn" onclick="openModal()">
  <i class="fas fa-plus-circle me-2"></i> Add Vendor
</button>
      </div>
  <div style="height: 60vh;overflow-y:scroll">
      <table class="table table-bordered">
          <thead>
              <tr>
                  <th>S.N</th>
                  <th>Vendor name</th>
                  <th>Address</th>
                  <th>Contact</th>
                  <th>Email</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tbody>
            @foreach($vendors as $index => $vendor)
              <tr>
                  <td>{{ $index+1 }}</td>
                  <td>{{ $vendor->vendor_name }}</td>
                  <td>{{ $vendor->vendor_address }}</td>
                  <td>{{ $vendor->vendor_contactno }}</td>
                  <td>{{ $vendor->vendor_email }}</td>
                  <td>
                    <button onclick="editVendor(this)" title="Edit" class="editvendor"  
                     data-id="{{ $vendor->id }}" 
                     data-name="{{ $vendor->vendor_name }}"
                     data-address="{{ $vendor->vendor_address }}"
                     data-contact="{{ $vendor->vendor_contactno }}"
                     data-email="{{ $vendor->vendor_email }}"><i class="fas fa-edit me-1"></i> Edit</button>
                    <button onclick="deleteVendor(this)" title="Delete" class="deletevendor" data-id="{{ $vendor->id }}">
<i class="fas fa-trash-alt me-1"></i> Delete</button>
                  </td>

            @endforeach
              
            
          </tbody>
      </table>
      </div>
  </div>
 <div class="modal" id="userModal">
  <div class="modal-content">
    <h2>Add Vendor</h2>
    <form method="post"  action="{{ route('vendor.store') }}" >
        @csrf
      <input type="text" id="vendorname" placeholder="Vendor name" required name="vendor_name">
      <input type="text" id="vendoraddress" placeholder="Address" required name="vendor_address">
      <input type="text" id="contact" placeholder="Contact" required name="vendor_contact" maxlength="10" pattern="\d{10}">
      <input type="email" id="email" placeholder="Email" required name="vendor_email">
    
      <div class="actions">
        <button type="submit" class="btn-submit" id="submitBtn">Add</button>
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
    const name = document.getElementById('vendorname').value;
    const address = document.getElementById('vendoraddress').value;
    const contact = document.getElementById('contact').value;
    const email = document.getElementById('email').value;
   

    alert(`User Created:\nName: ${name}\nAddress: ${address}\nContact: ${contact}\nEmail: ${email} `);
    closeModal();
  }
  function editVendor(button) {
    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const address = button.getAttribute('data-address');
    const contact = button.getAttribute('data-contact');
    const email = button.getAttribute('data-email');

    // Fill modal form
    document.getElementById('edit_vendorname').value = name;
    document.getElementById('edit_vendoraddress').value = address;
    document.getElementById('edit_contact').value = contact;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_vendor_id').value = id;

    // Set form action dynamically
    document.getElementById('editVendorForm').action = '/vendor/' + id;

    // Show modal
    document.getElementById('editModal').style.display = 'block';
  }
  function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
  }


  function deleteVendor(button) {
    const id = button.getAttribute('data-id');
    document.getElementById('deleteVendorForm').action = '/vendor/' + id;
    document.getElementById('deleteModal').style.display = 'block';
  }
  function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
  }

   function searchVendors() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('table tbody tr');
    rows.forEach(row => {
      row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
    });
  }
  
</script>





<div class="modal" id="editModal">
  <div class="modal-content">
    <h2>Edit Vendors</h2>
    <form id="editVendorForm" method="POST" action=" ">
      @csrf
      @method('PUT')
      <input type="hidden" id="edit_vendor_id" name="vendor_id">
      <input type="text" id="edit_vendorname" placeholder="Vendor Name" required name="vendor_name">
      <input type="text" id="edit_vendoraddress" placeholder="Address" required name="vendor_address">
      <input type="text" id="edit_contact" placeholder="Contact Number" required name="vendor_contact" maxlength="10" pattern="\d{10}">
      <input type="email" id="edit_email" placeholder="Email" required name="vendor_email">
     
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
    
    <p style="text-align: center; font-size: 20px;">Are you sure you want to delete this Vendor ?</p>
    <form id="deleteVendorForm" method="POST">
      @csrf
      @method('DELETE')
      <div class="actions">
        <button type="submit" class="btn-submit" style="background: green; margin-left: 100px;">Delete</button>
        <button type="button" class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
      </div>
    </form>
  </div>
</div>
  


@endsection