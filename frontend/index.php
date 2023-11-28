
<?require "basic_start.php"?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <body>
        <?require "header.php"?>
        <main>
            Prodotti:
            <div class="product table" id="products-table">
                <?php foreach($products as $id => $product): ?>
                    <div class="product">
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
        <?require "footer.php"?>
    </body>
</html>