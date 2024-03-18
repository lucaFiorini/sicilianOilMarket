<?php
header("Content-Type: application/json");

session_start();

if(!isset($_SESSION["profile"]["employee"])) {
    http_response_code(403); // Forbidden
    echo json_encode(["error" => "User not validated"]);
    exit;
}

$conn = require("../../classes/getConnection.php");

$productID = $_POST["product-id"];
$productName = $_POST["product-name"];
$productPrice = floatval($_POST["product-price"])*100;
$productAmount = $_POST["product-amount"];
$productDescription = $_POST["product-description"];

$ProducerID = $_SESSION["profile"]["employee"]['ProducerID'];
if (!isset($ProductID) || $productID === -1) {
    // Insert new product
    $sql = "INSERT INTO product (name, price, amount, description, ProducerID) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiis", $productName, $productPrice, $productAmount, $productDescription, $ProducerID);
} else {
    // Update existing product
    $sql = "UPDATE product SET name = ?, price = ?, amount = ?, description = ? WHERE ProductID = ? AND ProducerID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdiisi", $productName, $productPrice, $productAmount, $productDescription, $productID, $ProducerID);
}

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Unable to update product"]);
}

$stmt->close();
$conn->close();
?>
