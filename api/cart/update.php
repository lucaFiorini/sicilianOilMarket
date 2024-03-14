<?php
header("content-type: application/json");
session_start();
$productID = $_GET["ProductID"];
$amount = $_GET["amount"];
$data = null;

if( !isset($productID,$amount) || $amount < 0 ){
  $data["status"] = "error";
  $data["error"] = "invalid arguments";
  echo json_encode($data);
  exit();
}

if($amount == 0){
  unset($_SESSION["cart"][$productID]);
} else {
  $_SESSION["cart"][$productID] = $amount;
}

$data["status"] = "ok";
echo json_encode($data);
