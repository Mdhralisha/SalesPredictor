<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Forgot Password</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <style>
    * {
      box-sizing: border-box;
    }

    body {
    background: linear-gradient(to right, #1e3c72, #cfd1d5ff); 
      font-family: 'Roboto', sans-serif;
      margin: 0;
      padding: 0;
      height: 100vh;
      overflow: hidden; /* Prevent scrollbars */
    }

    .wrapper {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      gap: 60px;
      padding: 40px;
    }

    .salestext h1 {
      color: #fff;
      font-size: 50px;
      margin: 0;
      font-family: sans-serif;
    }

    .forgot-section {
      background-color: #f2f3f4;
      padding: 30px 40px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      width: 360px;
      text-align: center;
      height:350px;
      width: 30%;
    }

    h2 {
      color: #062663;
      margin-bottom: 25px;
    }

    input[type="email"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0 20px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 16px;
    }

    button {
      background-color: green;
      color: white;
      padding: 12px 0;
      width: 80%;
      border: none;
      border-radius: 4px;
      font-size: 15px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin-top: 20px;
    }

    button:hover {
      background-color: #4a7ac7;
    }

    .back-login {
      margin-top: 30px;
      display: block;
      color: #6495ED;
      text-decoration: none;
      font-weight: 500;
 
    }


    .back-login:hover {
      text-decoration: underline;
    }

    footer {
      position: absolute;
      bottom: 10px;
      width: 100%;
      text-align: center;
      font-size: 14px;
      color: #ccc;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="salestext">
      <h1>Sales Prediction System</h1>
    </div>
    <div class="forgot-section">
      <h2>Forgot Password ?</h2>
      <form action="" method="POST">
        @csrf
        <input
          type="email"
          name="email"
          placeholder="Enter your email"
          required
          autocomplete="email"
        />
        <button type="submit">Reset Password</button>
      </form>

      <a href="{{ route('adminlogin.login') }}" class="back-login">
        &larr; Back to Login
      </a>
    </div>
  </div>

  <footer>
    &copy; 2025 Alisha Manandhar, Kathmandu, Nepal. All rights reserved.
  </footer>
</body>
</html>
