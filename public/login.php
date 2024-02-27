<?php
session_start();

require_once "../classes/popupHandler.php";

$conn = require("../classes/getConnection.php");

if(isset($_POST['register'])){
  // Check if the email already exists
  $check_query = "SELECT email FROM profile WHERE email = ?";
  $check_stmt = $conn->prepare($check_query);
  $check_stmt->bind_param("s", $_POST['email']);
  $check_stmt->execute();
  $check_stmt->store_result();

  if($check_stmt->num_rows > 0) {
    // Email already exists, set up error popup
    $_Popup->type = "error";
    $_Popup->msg = "Registration failed: Email is already registered.";
  } else {
    // Proceed with registration
    $query = "INSERT INTO profile(email,password_hash,status,name,surname)
      VALUES (?,PASSWORD(?),?,?,?)";

    $status = "OK"; //temp shit

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss",
      $_POST['email'],
      $_POST['password'],
      $status,
      $_POST['name'],
      $_POST['surname']
    );
    $stmt->execute();

    // Set up success popup
    $_Popup->type = "success";
    $_Popup->msg = "Registration successful";
  }

} else if (isset($_POST['login'])){

  $query = "SELECT * FROM profile WHERE email = ? AND password_hash = PASSWORD(?) ";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ss",
    $_POST['email'],
    $_POST['password'],
  );
  
  $stmt->execute();
  $res = $stmt->get_result();

  if($res->num_rows== 1){
    
    $user = $res->fetch_assoc();
    $_SESSION['ProfileID'] = $user['ProfileID'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['surname'] = $user['surname'];
    $_SESSION['email'] = $user['email'];

    $_Popup->type = "success";
    $_Popup->msg = "Login successful!";

  } else {
    $_Popup->type = "error";
    $_Popup->msg = "Login failed: wrong email or password";
  }

} else if (isset($_GET["logout"])){
  session_unset();
  $_Popup->type = "info";
  $_Popup->msg = "Logout completed";
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <script>
      function checkPw() {
        let pw1 = document.getElementById("register-password");
        let pw2 = document.getElementById("register-password-conf");
        
        if(pw1.value != pw2.value){
          pw2.setCustomValidity("The passwords do not match");
          pw2.reportValidity();
          pw2.setCustomValidity("");
          return false;
        } 
          
        return true;

      }


    </script>
  </head>
  <body>
    <?php require "../partials/header.php"?>
    <main>

        <div class="form-box">
          <h2>Login</h2>
          <form method="post">
            <label for="login-email">Email: </label>
            <input required id="login-email" type="email" name="email">
            <br>
            <label for="login-password">Password: </label>
            <input required id="login-password" type="password" name="password">

            <input type="hidden" name="login">
            <input required type="submit" value="login">
          
          </form>
          <hr>
          
          <h2>Register</h2>
          <form method="post" onsubmit='return checkPw()'>

            <label for="register-email">Email: </label>
            <input required id="register-email" type="email" name="email">
            
            <label for="register-name">Name: </label>
            <input required id="register-name" type="text" name="name">

            <label for="register-surame">Surname: </label>
            <input required id="register-surname" type="text" name="surname">

            <label for="register-password">Password: </label>
            <input required id="register-password" type="password" name="password">

            <label for="register-password-conf">Confirm password: </label>
            <input required id="register-password-conf" type="password">

            <input type="hidden" name="register">
            <input type="submit" value="register">

          </form>

        </div>

    </main>
    <?php require "../partials/footer.php"?>
  </body>
</html>