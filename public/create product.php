<?php
if(isset($_GET['name'],$_GET['description'])){
  $conn = require '../classes/getConnection.php';
  $stmt = $conn->prepare('INSERT INTO Product(name,description) VALUES (?,?)');
  $stmt->bind_param('ss', $_GET['name'],$_GET['description']);
  $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TEMP</title>
</head>
  <body>
    <form>
      <h1>Crea Prodotto</h1>
      <label for="name">Name : </label>
      <input type="text" name="name" id="name">
      <label for="description">Description : </label>
      <input type="text" name="description" id="description">
      <input type="submit" value="crea">
    </form>
  </body>
</html>