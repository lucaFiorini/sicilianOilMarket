<?php
  session_start();
  if(!isset($_SESSION["profile"]["employee"]))
    die("User not validated");

  $conn = require("../classes/getConnection.php");

  $ProducerID= $_SESSION['profile']['employee']['ProducerID'];

  $res = $conn->query("SELECT ProductID as ID, image, name, description, price FROM product WHERE ProducerID = ".intval($ProducerID));
  $products = $res->fetch_all(MYSQLI_ASSOC);

  if(isset($_POST["name"])) {

    $amount = intval($_POST["price"] * 100);
    $query = "INSERT INTO product(ProducerID,name,image,price,availableAmount,description) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issiis",
      $ProducerID,
      $_POST["name"],
      $_POST["image"],
      $amount,
      $_POST["amount"],
      $_POST["description"]
    );

    $stmt->execute();

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
      <div class="form-box centered" id="product-edit-area">

        <h2>Edit [Product name] / new Product</h2>
        <form id="product-edit-form" action="#" method="post">

          <input type="hidden" id="product-id" name="id">

          <label for="product-name">Product name:</label>
          <input id="product-name" required type="text" name="name">
          
          <label for="product-image">Product image:</label>
          <!--<input id="product-image" type="file" accept="image/*">-->
          <input id="product-image" name="image">


          <label for="product-price">Product price:</label>
          <input id="product-price" required type="number" name="price" step="0.01" min="0">

          <label for="product-amount">Amount in stock:</label>
          <input id="product-amount" required type="number" name="amount" min="0">

          <label for="product-description">Product description:</label>
          <textarea id="product-description" required name="description"></textarea>
          
          <input type="submit" value="Save / Add product">
        </form>
      </div>
      <button>Add a new product</button>
      <?php if(count($products)>0):?>
        <div id="products">
          <?php foreach($products as $id => $product):?>
            <div class="product">
              <image class="image" src=<?=$product["image"]?> >

              <a class="title" href='product?id=<?=$product["ID"]?>'><?=$product["name"]?></a>
              <a class="description" hred='product?id=<?=$product["ID"]?>'><?=$product["description"]?></a>
              <div>€<?=floatval($product["price"]) / 100?></div>
              <input type="button" value="Manage product" onclick='manageProduct(<?=$product["ID"]?>)'>

            </div>
          <?php endforeach;?>
        </div>
      <?php else:?>
        <p>
          No products found
        </p>
      <?php endif;?>
    </main>
    <?php //require "../partials/footer.php"?>
  </body>
  <?php require "../partials/footer.php"?>
  
</html>
<script>


  

</script>