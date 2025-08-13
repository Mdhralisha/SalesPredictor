<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Change Password</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to right, #1e3c72, #cfd1d5ff); 
      font-family: 'Roboto', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    .password-box {
      background-color: #ffffff;
      padding: 30px 40px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 400px;
    }

    .password-box h2 {
      text-align: center;
      color: #333;
      margin-bottom: 25px;
    }

    .form-group {
      margin-bottom: 20px;
      font-family: sans-serif;
      font-size: 15px;
    }

    label {
      display: block;
      color: #444;
      margin-bottom: 6px;
      font-weight: 500;
    }

    input[type="password"] {
      width: 80%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
      margin-left: 35px;
     
    }

    button {
      background-color: #28a745;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      width: 60%;
      cursor: pointer;
      margin-top: 15px;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #218838;
    }
       .back-login {
      margin-top: 30px;
      display: block;
      color: #6495ED;
      text-decoration: none;
      font-weight: 500;
      margin-left: 135px;
 
    }


    .back-login:hover {
      text-decoration: underline;
    }

  </style>
</head>
<body>

  <div class="password-box">
    <h2 style="font-family: sans-serif; color: #1e3c72;">Change Password</h2>
    <form method="POST" >
      <!-- @csrf in Laravel -->
      @csrf
      <div class="form-group">
       
        <input type="password" id="current_password" name="current_password" placeholder="Current Password" required>
      </div>

      <div class="form-group">
        
        <input type="password" id="new_password" name="new_password" placeholder="New Password" required>
      </div>

      <div class="form-group">
      
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm New Password" required >
      </div>

      <center><button type="submit">Change Password</button></center>
    </form>

     <a href="{{ route('adminlogin.login') }}" class="back-login">
        &larr; Back to Login
      </a>
  </div>

</body>
</html>
