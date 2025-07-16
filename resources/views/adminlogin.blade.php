<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Stylish Login Form</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

</head>
<style>
    @include("../css/style.css");
body{
    background-color: white;
}
.form-section {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  width: 160%;
  height: 350px;
  background-color: #f2f3f4 ;
}
.container {
  display:flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin-right: 80px;
}
.test {
  width: 30%;
  height: 382px;
  background-color: 
#6495ED ;
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
.textt{
    width: 100%;
    height: 90px;
    text-align: center;
    margin-top: 70px;
    background-color: white;
}
.sales {
  font-size: 25px;
  color: #6495ED ;
  padding: 20px;
  font-family: 'Roboto';
}
.foot{
    text-align: center;
    font-size: 17px;
    color: white;
    margin-top: 100px;
}


</style>
<body>
  <div class="container">
    <!-- Left Panel with Image -->
    <div class="test">
    <div class="textt">
        <h1 class="sales"> Sales Prediction in Inventory</h1>
    </div>
<footer>
  <p class="foot"> &copy; 2025 Alisha Manandhar, Kathmandu, Nepal. All rights reserved.</p>
</footer>
    </div>

    <!-- Right Panel with Form -->
     <center>
    <div class="form-section">
      <form>
        <h2>USER LOGIN</h2>

    

        <input type="text" id="username" placeholder="Username" required class="inputt">
        <br>

        <input type="password" id="password" placeholder="Password" required class="inputt">
        <br><br>

        <button type="submit" class="submit-btn">Log In</button> <br><br><br>

        <div class="form-options">
          <label>
            <input type="checkbox" checked>
            <span class="checkmark"></span>
            Remember Me
          </label><br><br>
          <a href="#">Forgot Password ?</a>
        </div>


      </form>
    </div>
    </center>
  </div>

  <!-- Font Awesome (for icons) -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>

