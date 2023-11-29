<?php
$conn = require("../classes/getConnection.php");
$res = $conn->query("SELECT ProductID as ID, image, name , description FROM product");
$products = $res->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
</head>
    <body>
        <main>
            <?php require "../partials/header.php"?>
            <h2><a href="create product">Crea Prodotto</a></2><br>
            <?php if(count($products)>0):?>
                Prodotti:
                <div class="product table" id="products-table">
                    <?php foreach($products as $id => $product):?>
                        <div class="row">
                            <div class="prod-image">
                                <image src='<?=$product["image"]?>'>
                            </div>
                            <div class="prod-name">
                                <h2><a href='product/?id=<?=$product["ID"]?>'><?=$product["name"]?></a></h2>
                            </div>
                            <div class="prod-description">
                                <p>
                                    <a hred='product/?id=<?=$product["ID"]?>'><?=$product["description"]?></a>
                                </p>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            <?php else:?>
                <p>
                    Nessun prodotto trovato
                </p>
            <?php endif;?>
        </main>
        <?php require "../partials/footer.php"?>
    </body>
</html>