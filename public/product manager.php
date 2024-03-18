<?php
  session_start();
  
  if(!isset($_SESSION["profile"]["employee"]))
    die("User not validated");

  $conn = require("../classes/getConnection.php");
  $res = $conn->query("SELECT ProductID as ID, image, name, description, price FROM product WHERE ProducerID = ".intval($_SESSION['profile']['employee']['ProducerID']));
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
      <div class="form-box centered" id="product-edit-area">

        <h2>Edit [Product name] / new Product</h2>
        <form id="product-edit-form" onsubmit="return false;">

          <input type="hidden" id="product-id">

          <label for="product-name">Product name:</label>
          <input id="product-name" required type="text">
          
          <label for="product-image">Product image:</label>
          <input id="product-image" type="file" accept="image/*">

          <label for="product-price">Product price:</label>
          <input id="product-price" required type="number" step="0.01" min="0">

          <label for="product-amount">Amount in stock:</label>
          <input id="product-amount" required type="number" min="0">

          <label for="product-description">Product description:</label>
          <textarea id="product-description" required name="product-description"></textarea>
          
          <input type="submit" value="Save / Add product" onclick="sendData()">
        </form>
      </div>
      <button>Add a new product</button>
      <?php if(count($products)>0):?>
        <div id="products">
          <?php foreach($products as $id => $product):?>
            <div class="product">
              <image class="image" src='https://helpx.adobe.com/content/dam/help/en/photoshop/using/convert-color-image-black-white/jcr_content/main-pars/before_and_after/image-before/Landscape-Color.jpg'>

              <a class="title" href='product?id=<?=$product["ID"]?>'><?=$product["name"]?></a>
              <a class="description" hred='product?id=<?=$product["ID"]?>'><?=$product["description"]?></a>
              <div>€<?=floatval($product["price"]) / 100?></div>
              <input type="button" value="Aggiungi al carrello" onclick='manageProduct(<?=$product["ID"]?>)'>

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
  function sendData(){
    
    var productID = document.getElementById("product-id").value;
    var productName = document.getElementById("product-name").value;
    //TODO: #1 var productImage = document.getElementById("product-image").files[0]; // For file inputs, get the file object
    var productPrice = document.getElementById("product-price").value;
    var productAmount = document.getElementById("product-amount").value;
    var productDescription = document.getElementById("product-description").value;
    
    var formData = new FormData();
    formData.append("product-id", productID);
    formData.append("product-name", productName);
    //TODO: #1 formData.append("product-image", productImage);
    formData.append("product-price", productPrice);
    formData.append("product-amount", productAmount);
    formData.append("product-description", productDescription);

    // Send form data to the server using fetch API
    fetch('api/products/handler.php', {
      method: 'POST',
      body: formData
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.text();
    })
    .then(data => {
      document.getElementById("product-edit-form").reset();
    })
    .catch(error => {
      console.error('There was an error with the fetch operation:', error);
    });
  }

  

</script>