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
    }

    .btn-cancel {
      background-color: #dc3545;
      color: white;
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
  
  
      
</style>
  <div class="container mt-4">
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
              <tr>
                  <td>1</td>
                  <td>alisha</td>
                  <td>Bhaktapur</td>
                  <td>1234567890</td>
                  <td>alisha@example.com</td>
                  <td>  
                    <button onclick="editVendor(this)" title="Edit" class="editvendor">Edit</button>
                    <button onclick="deleteVendor(this)" title="Delete" class="deletevendor">Delete</button>
                </td>
                
             </tr>
              
            
          </tbody>
      </table>
  </div>

  <div class="modal" id="userModal">
  <div class="modal-content">
    <h2>Add Vendor</h2>
    <form onsubmit="submitForm(event)">
      <input type="text" id="vendorname" placeholder="Vendor name" required>
      <input type="text" id="vendoraddress" placeholder="Address" required>
      <input type="number" id="contact" placeholder="Contact" required>
      <input type="email" id="email" placeholder="Email" required>
    
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




   let currentEditRow = null;

  // Edit Vendor Button Click
  function editVendor(button) {
    const row = button.closest('tr');
    currentEditRow = row;

    const cells = row.getElementsByTagName('td');
    document.getElementById('vendorname').value = cells[1].innerText;
    document.getElementById('vendoraddress').value = cells[2].innerText;
    document.getElementById('contact').value = cells[3].innerText;
    document.getElementById('email').value = cells[4].innerText;
    document.getElementById('submitBtn').innerText = "Update";

    // Change modal title
    document.querySelector('#userModal h2').innerText = "Update Vendor";
   

    // Show modal
    document.getElementById('userModal').style.display = 'block';
  }


  // Override submitForm() to support editing
  const originalSubmitForm = submitForm;

  submitForm = function (e) {
    e.preventDefault();
    const name = document.getElementById('vendorname').value;
    const address = document.getElementById('vendoraddress').value;
    const contact = document.getElementById('contact').value;
    const email = document.getElementById('email').value;

    if (currentEditRow) {
      // Update row
      const cells = currentEditRow.getElementsByTagName('td');
      cells[1].innerText = name;
      cells[2].innerText = address;
      cells[3].innerText = contact;
      cells[4].innerText = email;

      currentEditRow = null;
      document.querySelector('#userModal h2').innerText = "Add Vendor";
    } else {
      // Call original submitForm for new entry
      originalSubmitForm(e);
    }

    closeModal();
  };


  let vendorToDelete = null;

// Trigger the delete confirmation modal
function deleteVendor(button) {
  vendorToDelete = button.closest('tr');
  document.getElementById('deleteModal').style.display = 'block';
}

// Confirm delete
function confirmDelete() {
  if (vendorToDelete) {
    vendorToDelete.remove();
    vendorToDelete = null;
  }
  document.getElementById('deleteModal').style.display = 'none';
}

// Cancel delete
function cancelDelete() {
  vendorToDelete = null;
  document.getElementById('deleteModal').style.display = 'none';
}
  
</script>
  


@endsection