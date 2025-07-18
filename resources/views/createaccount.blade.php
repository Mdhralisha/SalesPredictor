<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Account</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/v4-shims.min.css">
  <style>
    body {
      background-color: white;
      font-family: 'Roboto', sans-serif;
    }
    .form-section {
      background-color: #f2f3f4;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      width: 160%;
      height: 530px;
    }
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin-right: 80px;
    }
    .test {
      width: 30%;
      height: 562px;
      background-color: #6495ED;
      border-radius: 8px;
    }
    .inputt {
      width: 70%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .submit-btn {
      background-color: #4CAF50;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      width: 50%;
    }
    .textt {
      width: 100%;
      height: 100px;
      text-align: center;
      margin-top: 70px;
      background-color: white;
    }
    .sales {
      font-size: 25px;
      color: #6495ED;
      padding: 20px;
      font-family: 'Roboto';
      margin-top: 10px;
    }
    .foot {
      text-align: center;
      font-size: 17px;
      color: white;
      margin-top: 200px;
    }
    .login-link {
      margin-top: 15px;
      font-size: 14px;
    }
    .login-link a {
      color: #4CAF50;
      text-decoration: none;
    }
    .login-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Left Panel -->
    <div class="test">
      <div class="textt">
        <h1 class="sales"> Sales Prediction in Inventory</h1>
      </div>
      <footer>
        <p class="foot">&copy; 2025 Alisha Manandhar, Kathmandu, Nepal. All rights reserved.</p>
      </footer>
    </div>

    <!-- Right Panel -->
    <center>
      <div class="form-section">
        <form>
          <h2>CREATE ACCOUNT</h2>

          <input type="text" id="fullname" placeholder="Full Name" required class="inputt"><br>
          <input type="email" id="email" placeholder="Email Address" required class="inputt"><br>
          <input type="text" id="username" placeholder="Username" required class="inputt"><br>
          <input type="password" id="password" placeholder="Password" required class="inputt"><br>
          <input type="password" id="confirm-password" placeholder="Confirm Password" required class="inputt"><br><br>

          <button type="submit" class="submit-btn">Create Account</button>

          <div class="login-link">
            Already have an account? <a href="adminlogin">Login here</a>
          </div>
        </form>
      </div>
    </center>
  </div>

  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
