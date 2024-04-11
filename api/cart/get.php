<?php
$conn = require "../../classes/getConnection.php";

session_start();
header("content-type: application/json");

$products = null;
if(isset($_SESSION['cart'])){
  foreach($_SESSION["cart"] as $productID => $amount){
    
    $stmt = $conn->prepare("SELECT ProductID as ID, image, name, description, price FROM product WHERE ProductID = ?");
    $stmt->bind_param("i",$productID);
    $stmt->execute();
    $res = $stmt->get_result();
    $product = $res->fetch_assoc();
    $product["amount"] = $amount;
    $products[] = $product;

  }
}

echo json_encode($products);