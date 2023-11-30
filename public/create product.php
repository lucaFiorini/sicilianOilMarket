<?php
if(isset($_GET['name'],$_GET['description'])){
  $priceInCents = intval(floatval($_GET['price'])*100);
  $conn = require '../classes/getConnection.php';
  $stmt = $conn->prepare('INSERT INTO Product(name,description,price) VALUES (?,?,?)');
  $stmt->bind_param('ssi', $_GET['name'],$_GET['description'],$priceInCents );
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
      <label for="price">Price : </label>
      <input type="number" step="0.01" name="price" id="price">
      <input type="submit" value="crea">
    </form>
  </body>
</html>