<?php

session_start();
if(!isset($_SESSION['profile'])){
  echo "Forbidden,please log in";
  die(403);
}


$conn = require("../classes/getConnection.php");


$res = $conn->query("SELECT reciptID FROM recipt WHERE receiving_ProfileID = ".$_SESSION['profile']['ProfileID']);
$receipts = $res->fetch_all(MYSQLI_ASSOC);

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
      Thank you for your purchase, your can find your receipts here:<br>
      <?php foreach($receipts as $receipt):?>
        <a class="link" href="get_receipt.php?receiptID=<?=$receipt['reciptID']?>">download recipt <?=$receipt['reciptID']?></a><br>
      <?php endforeach?>
    </main>
    <?php //require "../partials/footer.php"?>
  </body>
  <?php require "../partials/footer.php"?>
</html>