<?php
require "../classes/popupHandler.php";
session_start();
if(!isset($_SESSION["profile"])){
    $_Popup->type = "error";
    $_Popup->msg = "Please log in before continuing";
    $_Popup->onCloseRedirect = "login";
    $_Popup->timeout = 2000;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link href="style.css" rel="stylesheet">
</head>
  <body>
    <?php require "../partials/header.php"?>
  </body>
</head>