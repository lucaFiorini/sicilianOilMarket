<?php
  $conn = require("../classes/getConnection.php");
  $res = $conn->query("SELECT * FROM product WHERE ProductID = ".intval($_GET['id']));
  $products = $res->fetch_all(MYSQLI_ASSOC);
  var_dump($products);
?>