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
    }

    .btn-cancel {
      background-color: #dc3545;
      color: white;
    }
      .edituser{
      background: green;
      color:white;
      border: none;
      border-radius: 3px;
      width: 25%;
    
    }
    .deleteuser{
      background: red;
      color:white;
      border: none;
      border-radius: 3px;
      width: 25%;
    
    }
    .table.table-bordered{
      background-color: white;
      box-shadow: 0px 1px 2px gray;
    }
  
      
</style>
  <div class="container pt-4">
      <h1 class="userin">Users Information !!</h1>
     
      <input type="button" class="createbtn" value="Create User"  onclick="openModal()">

      <table class="table table-bordered">
          <thead>
              <tr>
                  <th>S.N</th>
                  <th>Username</th>
                  <th>User Email</th>
                  <th>User Role</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td>1</td>
                  <td>alisha</td>
                  <td>alisha@example.com</td>
                  <td>Admin</td>
                  <td>  
                    <button onclick="editUser(this)" title="Edit" class="edituser">Edit</button>
                    <button onclick="deleteUser(this)" title="Delete" class="deleteuser">Delete</button>
                </td>
             </tr>
              <!-- more rows -->
          </tbody>
      </table>
  </div>

  <div class="modal" id="userModal">
  <div class="modal-content">
    <h2>Create User</h2>
    <form onsubmit="submitForm(event)">
      <input type="text" id="username" placeholder="Username" required>
      <input type="email" id="email" placeholder="Email" required>
      <select id="role" required>
        <option value="">Select Role</option>
        <option value="Admin">Admin</option>
        <option value="User">User</option>
      </select>
      <div class="actions">
        <button type="submit" class="btn-submit">Create</button>
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
    const name = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const role = document.getElementById('role').value;

    alert(`User Created:\nName: ${name}\nEmail: ${email}\nRole: ${role}`);
    closeModal();
  }
</script>
  


@endsection