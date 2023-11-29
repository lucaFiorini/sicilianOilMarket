<?php
    $query = $_GET['query'];
    $tags = $_GET['tags'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <body>
        <?php require "header.php"?>
        <main>
            Prodotti:
            <div class="product table" id="products-table">
                <?php foreach($products as $id => $product): ?>
                    <div class="row">
                        <div class="prod-image">
                            <image src='<?=$product->image?>'>
                        </div>
                        <div class="prod-name">
                            <h2><a href='products/<?=$product->id?>'><?=$product->name?></a></h2>
                        </div>
                        <div class="prod-description">
                            <p>
                                <a hred='products/<?=$product->id?>'><?=$product->description?></a>
                            </p>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </main>
        <?php require "footer.php"?>
    </body>
</html>