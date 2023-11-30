<?php
$conn = require("../classes/getConnection.php");
$res = $conn->query("SELECT ProductID as ID, image, name, description, price FROM product");
$products = $res->fetch_all(MYSQLI_ASSOC);
?>
<script>
    cart  = []
    function addToCart(id){
        cart.push(id);
    }
</script>
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
            <?php if(count($products)>0):?>
                <div id="products">
                    <?php foreach($products as $id => $product):?>
                        <div class="product">
                            <image class="image" src='https://helpx.adobe.com/content/dam/help/en/photoshop/using/convert-color-image-black-white/jcr_content/main-pars/before_and_after/image-before/Landscape-Color.jpg'>

                            <a class="title" href='product?id=<?=$product["ID"]?>'><?=$product["name"]?></a>
                            <a class="description" hred='product?id=<?=$product["ID"]?>'><?=$product["description"]?></a>
                            <div>€<?=floatval($product["price"]) / 100?></div>
                            <input type="button" value="Aggiungi al carrello" onclick='addToCart(<?=$product["ID"]?>)'>

                        </div>
                    <?php endforeach;?>
                </div>
            <?php else:?>
                <p>
                    Nessun prodotto trovato
                </p>
            <?php endif;?>
        </main>
        <?php //require "../partials/footer.php"?>
    </body>
</html>