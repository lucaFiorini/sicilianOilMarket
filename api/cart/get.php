<?php
$conn = require "../../classes/getConnection.php";

session_start();
header("content-type: application/json");

$products = null;

foreach($_SESSION["cart"] as $productID => $amount){
  
  $stmt = $conn->prepare("SELECT ProductID as ID, image, name, description, price FROM product WHERE ProductID = ?");
  $stmt->bind_param("i",$productID);
  $stmt->execute();
  $res = $stmt->get_result();
  $row = $res->fetch_assoc();
  $row["amount"] = $amount;
  $products[] = $row;

}

echo json_encode($products);