<?php
$conn = require("../classes/getConnection.php");
$res = $conn->query("SELECT ProductID as ID, image, name, description, price FROM product");
$products = $res->fetch_all(MYSQLI_ASSOC);
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
    <div>
    <?php foreach($_SESSION["cart"] as $key => $amount):?>
      <div>
        <?=$products[$key]["name"]?> x<?=$amount?> 
      </div>
    <?php endforeach;?>
    </div>
  </main>
</body>
