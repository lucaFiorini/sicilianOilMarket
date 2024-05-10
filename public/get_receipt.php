<?php
session_start();
if(!isset($_SESSION['profile'])){
  echo "Forbidden,please log in";
  die(403);
}

if(!isset($_GET['receiptID'])){
  echo "no ID picked";
  die();
}

$ID = $_GET['receiptID'];

$conn = require("../classes/getConnection.php");

$res = $conn->query("SELECT reciptID,raw_recipt FROM recipt WHERE receiving_ProfileID = ".$_SESSION['profile']['ProfileID']. " AND reciptID = ".$ID);

if(!$receipt = $res->fetch_assoc()){
  echo 'invalid ID';
  die();
}

header("Content-Disposition: attachment; filename=\"". basename('receipt'.$ID,'.xml') ."\""); 
header("Content-Description: File Transfer"); 
header("Content-Type: text/XML"); 

readfile('../receipts/'.$receipt['raw_recipt']);
