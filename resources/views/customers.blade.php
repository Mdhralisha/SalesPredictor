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
        margin-left: 920px;
        width: 15%;
    } */

          .createbtn{
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

    .editcustomer {
        background: green;
        color: white;
        border: none;
        border-radius: 3px;
        width: 25%;


    }
    .editcustomer:hover {
        background: #31684fff;
    }

    .deletecustomer {
        background: red;
        color: white;
        border: none;
        border-radius: 3px;
        width: 35%;

    }
    .deletecustomer:hover {
        background: #642f2fff;
    }

    .table.table-bordered {
        background-color: white;
        box-shadow: 0px 1px 2px gray;
    }

    .createbtn:hover {
        background-color:  #334258ff;
    }
    .btn-submit:hover {
        background-color: #3f6147ff;
    }
    .btn-cancel:hover {
        background-color: #794b4fff;
    }
</style>
<div class="container pt-4" >
    <h1 class="userin">Customers Information !!</h1>
    
  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
  <div class="d-flex align-items-center mr-3">
  <label for="searchInput" class="mr-2 mb-0" style="font-weight: normal;">Search:</label>
  <input type="text" id="searchInput" class="form-control" style="width: 250px;" placeholder="Search Customers..." onkeyup="searchCustomers()" />
</div>

    <input type="button" class="createbtn" value="Add Customer" onclick="openModal()">

</div>
    <div style="height: 60vh;overflow-y:scroll">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Customer name</th>
                    <th>Address</th>
                    <th>Contact No</th>

                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $index => $customer)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $customer->customer_name }}</td>
                    <td>{{ $customer->customer_address }}</td>
                    <td>{{ $customer->customer_contactno }}</td>


                    <td>
                        <button onclick="editCustomer(this)" title="Edit" class="editcustomer"
                            data-id="{{ $customer->id }}"
                            data-name="{{ $customer->customer_name }}"
                            data-address="{{ $customer->customer_address }}"
                            data-contact="{{ $customer->customer_contactno }}">Edit</button>
                        <button onclick="deleteCustomer(this)" title="Delete" class="deletecustomer"
                            data-id="{{ $customer->id }}">Delete</button>

                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>

<div class="modal" id="userModal">
    <div class="modal-content">
        <h2>Add Customer</h2>
        <form action="{{ route('customer.store') }}" method="POST">
            @csrf
            <input type="text" id="customername" placeholder="Customer Name" required name="customername">
            <input type="text" id="address" placeholder="Address" required name="address">
            <input type="text" id="contact" placeholder="Contact No" required name="contact" maxlength="10" pattern="\d{10}">


            <div class="actions">
                <button type="submit" class="btn-submit">Add</button>
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
        const name = document.getElementById('customername').value;
        const address = document.getElementById('address').value;
        const contact = document.getElementById('contact').value;



        alert(`User Created:\nName: ${name}\nAddress: ${address}\ncontact: ${contact}\nEmail: ${email}`);
        closeModal();
    }

    function editCustomer(button) {
        // Get data attributes from the button
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const address = button.getAttribute('data-address');
        const contact = button.getAttribute('data-contact');

        // Fill modal form with existing data
        document.getElementById('edit_customer_id').value = id;
        document.getElementById('edit_customername').value = name;
        document.getElementById('edit_address').value = address;
        document.getElementById('edit_contact').value = contact;

        // Set the form action dynamically
        document.getElementById('editCustomerForm').action = '/customer/' + id;

        // Show the edit modal
        document.getElementById('editModal').style.display = 'block';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    function deleteCustomer(button) {
        const id = button.getAttribute('data-id');
        const row = button.closest('tr');
        const cells = row.getElementsByTagName('td');
        const customerId = cells[0].innerText;


        // Set the form action dynamically
        document.getElementById('deleteCustomerForm').action = `/customer/${id}`;

        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }



    //Search Functionality
    function searchCustomers() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('table tbody tr');
    rows.forEach(row => {
      row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
    });
  }
</script>



<div class="modal" id="editModal">
    <div class="modal-content">
        <h2>Edit Customer</h2>
        <form id="editCustomerForm" method="POST">
            @csrf
            @method('PUT')

            <input type="text" id="edit_customer_id" name="id" hidden>
            <input type="text" id="edit_customername" placeholder="Customer Name" required name="customername">
            <input type="text" id="edit_address" placeholder="Address" required name="address">
            <input type="text" id="edit_contact" placeholder="Contact No" required name="contact" maxlength="10" pattern="\d{10}">


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

        <p style="text-align: center; font-size: 20px;">Are you sure you want to delete this Customer?</p>
        <form id="deleteCustomerForm" method="POST">
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