<?php

session_start();
if(!isset($_SESSION["profile"]["employee"])){
  echo "User not validated";
  die(403);
}

if(!isset($_POST['productID'])){
  echo 'no ID provided';
  die();
}



$ProducerID= $_SESSION['profile']['employee']['ProducerID'];

$conn = require("../classes/getConnection.php");

$res = $conn->query("SELECT ProductID as ID, image, name, description, price FROM product WHERE ProducerID = ".intval($ProducerID)."AND ProductID = ".intval($_POST['productID']));
$product = $res->fetch_assoc();

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

      <div class="form-box centered" id="product-edit-area">

        <h2>Edit [Product name] / new Product</h2>
        <form id="product-edit-form" action="#" method="post">

          <input type="hidden" id="product-id" name="id">

          <label for="product-name">Product name:</label>
          <input id="product-name" required type="text" name="name" value="<?=$product['name']?>">
          
          <label for="product-image">Product image:</label>
          <input id="product-image" type="file" accept="image/*">

          <label for="product-price">Product price:</label>
          <input id="product-price" required type="number" name="price" step="0.01" min="0" value="<?=$product['price'] / 100?>">

          <label for="product-amount">Amount in stock:</label>
          <input id="product-amount" required type="number" name="amount" min="0" value="<?=$product['price'] / 100?>">

          <label for="product-description">Product description:</label>
          <textarea id="product-description" required name="description"><?$product['price'] / 100?></textarea>
          
          <input type="button" class="delete" value="Close" onclick="hideProductEditWindow()">
          <input type="submit" value="Save / Add product">

        </form>
      </div>
    </main>
  </body>
</html>