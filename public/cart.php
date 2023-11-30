<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="style.css" rel="stylesheet" >
  <title>Document</title>
  <script>
    const searchParams = new URLSearchParams(window.location.search);
    let cart = searchParams.getAll('cart[]');
    console.log(cart);
  </script>
</head>
<body>
  <?=require "../partials/header.php"?>
  <main>

  </main>
</body>
</html>