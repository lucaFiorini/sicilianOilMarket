
<?php

session_start();

$conn = require("../classes/getConnection.php");

if(isset($_POST['register'])){

  $query = "INSERT INTO profile(email,password_hash,status,name,surname)
    VALUES (?,PASSWORD(?),?,?,?)";

  $status = "OK";

  $stmt = $conn->prepare($query);
  $stmt->bind_param("sssss",
    $_POST['email'],
    $_POST['password'],
    $status,
    $_POST['name'],
    $_POST['surname']
    );
  $stmt->execute();

} 

else if (isset($_POST['login'])){

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
    
    echo "login successful";

  }else echo "Login failed: wrong email or password";

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link href="style.css" rel="stylesheet" >
</head>
<body>
    <?php require "../partials/header.php"?>
    <main>
      <?php if ( isset($_SESSION['userID']) ):?>
        


      <?php else: ?>

        <div class="form-box">
          <h2>Login</h2>
          <form method="post">
            <label for="login-email">Email: </label>
            <input id="login-email" type="email" name="email">
            <br>
            <label for="login-password">Password: </label>
            <input id="login-password" type="password" name="password">

            <input type="hidden" name="login">
            <input type="submit" value="login">
          
          </form>
          <hr>
          
          <h2>Register</h2>
          <form method="post">

            <label for="register-email">Email: </label>
            <input id="register-email" type="email" name="email">
            
            <label for="register-name">Name: </label>
            <input id="register-name" type="text" name="name">

            <label for="register-surame">Surname: </label>
            <input id="register-surname" type="text" name="surname">

            <label for="register-password">Password: </label>
            <input id="register-password" type="password" name="password">

            <label for="register-password-conf">Confirm password: </label>
            <input id="register-password-conf" type="password">

            <input type="hidden" name="register">
            <input type="submit" value="register">

          </form>

        </div>

      <?php endif; ?>
    </main>
</body>
    