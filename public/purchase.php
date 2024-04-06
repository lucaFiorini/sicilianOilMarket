<?php
$conn = require("../classes/getConnection.php");
$res = $conn->query("SELECT ProductID as ID, image, name, description, price FROM product");
$products_db = $res->fetch_all(MYSQLI_ASSOC);
$products;
foreach($products_db as $product_db){
  $id = intval($product_db["ID"]);
  unset($product_db["ID"]);
  $product_db["price"] = floatval(intval($product_db["price"]) / 100);
  $products[$id] = $product_db;

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
    <div>
      <table>
        <thead>
          <tr>
            <th>
              Product name
            </th>
            <th>
              Price
            </th>
            <th>
              Amount
            </th>
            <th>
              Subtotal
            </th>
          </tr>
        </thead>
        <tbody>
          <?php $total = 0;?>
          <?php foreach($_SESSION["cart"] as $key => $amount):?>
            <tr> 
              <?php $total += $subtotal = $products[$key]["price"] * $amount?>
              <td> <?=$products[$key]["name"]?> </td>
              <td> €<?=$products[$key]["price"]?> </td> 
              <td> x<?=$amount?> </td> 
              <td> €<?=$subtotal?></td>
            </tr>
          <?php endforeach;?>
          <th>
            Total price:
          </th>
          <td colspan="3">
            <?=$total?>
          </td>
        </tbody>
      </table>
    </div>
    <hr>
    </input>
  </main>
  <input type="button" value="checkout" onclick="window.location.href='checkout'"></input>
</body>
