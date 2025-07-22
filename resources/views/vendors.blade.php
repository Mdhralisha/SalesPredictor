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
        margin-bottom:20px;
        margin-top: 20px;
    }
    .createbtn {
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
      background: green;
      color:white;
      border: none;
      border-radius: 3px;
      width: 25%;
    
    }
    .deletevendor{
      background: red;
      color:white;
      border: none;
      border-radius: 3px;
      width: 30%;
    
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
    }
  
  
  
      
</style>
  <div class="container pt-4">
      <h1 class="userin">Vendors Information !!</h1>
      <input type="button" class="createbtn" value="Create vendor"  onclick="openModal()">

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
                     data-contact="{{ $vendor->vendor_contact }}"
                     data-email="{{ $vendor->vendor_email }}">Edit</button>
                    <button onclick="deleteVendor(this)" title="Delete" class="deletevendor" data-id="{{ $vendor->id }}">Delete</button>
                  </td>

            @endforeach
              
            
          </tbody>
      </table>
  </div>
 <div class="modal" id="userModal">
  <div class="modal-content">
    <h2>Add Vendor</h2>
    <form method="post"  action="{{ route('vendor.store') }}" >
        @csrf
      <input type="text" id="vendorname" placeholder="Vendor name" required name="vendor_name">
      <input type="text" id="vendoraddress" placeholder="Address" required name="vendor_address">
      <input type="number" id="contact" placeholder="Contact" required name="vendor_contact">
      <input type="email" id="email" placeholder="Email" required name="vendor_email">
    
      <div class="actions">
        <button type="submit" class="btn-submit" id="submitBtn">Add</button>
        <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
      </div>
    </form>
  </div>
</div>

<div class="modal" id="deleteModal">
  <div class="modal-content">
    <h4 style="text-align:center;" class="confirm">Are you sure you want to delete this vendor?</h4>
    <div class="actions" style="justify-content:center;" class="del">
      <button class="btn-submit" onclick="confirmDelete()" class="del1">Delete</button>
      <button class="btn-cancel" onclick="cancelDelete()" style="margin-left: 15px;">Cancel</button>
    </div>
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
      <input type="number" id="edit_contact" placeholder="Contact Number" required name="vendor_contact">
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
        <button type="button" class="btn-cancel" style="background: red; margin-right: 70px;" onclick="closeDeleteModal()">Cancel</button>
      </div>
    </form>
  </div>
</div>
  


@endsection