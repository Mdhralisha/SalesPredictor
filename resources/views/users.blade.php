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
    width: 200px;
    /* or auto */
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

  .edituser {
    background: green;
    color: white;
    border: none;
    border-radius: 3px;
    width: 25%;

  }

  .deleteuser {
    background: red;
    color: white;
    border: none;
    border-radius: 3px;
    width: 25%;

  }

  .table.table-bordered {
    background-color: white;
    box-shadow: 0px 1px 2px gray;
  }
</style>
<div class="container pt-4">
  <h1 class="userin">Users Information !!</h1>
  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
    <div class="d-flex align-items-center mr-3">
      <label for="searchInput" class="mr-2 mb-0" style="font-weight: normal;">Search:</label>
      <input type="text" id="searchInput" class="form-control" style="width: 250px;" placeholder="Search Users..." onkeyup="searchUsers()" />
    </div>
    <input type="button" class="createbtn" value="Create User" onclick="openModal()">
  </div>
  <div style="height: 60vh;overflow-y:scroll">
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
        @foreach ($users as $index => $user)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->user_role }}</td>
          <td>
            <button class="edituser" onclick="editUser(this)"
              data-id="{{ $user->id }}"
              data-name="{{ $user->name }}"
              data-email="{{ $user->email }}"
              data-role="{{ $user->user_role }}">Edit</button>
            <button class="deleteuser" onclick="alert('Delete User: {{ $user->name }}')">Delete</button>
        </tr>
        @endforeach

      </tbody>
    </table>
  </div>
</div>

<div class="modal" id="userModal">
  <div class="modal-content">
    <h2>Create User</h2>
    <form action="{{ route('users.store') }}" method="POST">
      @csrf
      <input type="text" id="name" name="name" placeholder="Username" required>
      <input type="email" id="email" name="email" placeholder="Email" required>

      <!-- Password fields -->
      <input type="password" id="password" name="password" placeholder="Password" required>
      <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>

      <select id="user_role" name="user_role" required>
        <option value="">Select Role</option>
        <option value="admin">Admin</option>
        <option value="teller">Teller</option>
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

  function editUser(button) {
    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const email = button.getAttribute('data-email');
    const role = button.getAttribute('data-role');

    document.getElementById('edit_user_id').value = id;
    document.getElementById('edit_usernamee').value = name;
    document.getElementById('edit_useremail').value = email;
    document.getElementById('edit_userrole').value = role; // This selects the current role

    document.getElementById('editModal').style.display = 'block';
  }

  function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
  }

  function deleteUser(button) {
    const id = button.getAttribute('data-id');
    document.getElementById('deleteForm').action = '/users/' + id;
    document.getElementById('deleteModal').style.display = 'block';
  }

  function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
  }


  //Search Functionality
  function searchUsers() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('table tbody tr');
    rows.forEach(row => {
      row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
    });
  }
</script>
<div class="modal" id="editModal">
  <div class="modal-content">
    <h2>Edit Users</h2>
    <form id="editProductForm" method="POST" action=" ">
      @csrf
      @method('PUT')
      <input type="hidden" id="edit_user_id" name="user_id">
      <input type="text" id="edit_usernamee" placeholder="User Name" required name="username">
      <input type="email" id="edit_useremail" placeholder="Email" required name="useremail">

      <select id="edit_userrole" name="userrole" required>
        <option value="">Select Role</option>
        <option value="Admin" {{ old('userrole') == 'Admin' ? 'selected' : '' }}>Admin</option>
        <option value="User" {{ old('userrole') == 'User' ? 'selected' : '' }}>User</option>
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

    <p style="text-align: center; font-size: 20px;">Are you sure you want to delete this user?</p>
    <form id="deleteForm" method="POST">
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