<?php
require "../classes/popupHandler.php";
$conn = require "../classes/getConnection.php";

date_default_timezone_set('Europe/Rome');

session_start();
if(!isset($_SESSION["profile"])){
    $_Popup->type = "error";
    $_Popup->msg = "Please log in before continuing";
    $_Popup->onCloseRedirect = "login";
    $_Popup->timeout = 3000;
} else if($_SERVER['REQUEST_METHOD'] === 'POST'){
  
  $required_fields = array('email', 'codice_fiscale', 'name', 'surname', 'phone', 'address');
  $missing_fields = array();

  foreach ($required_fields as $field) {
    if (!isset($_POST[$field])) {
      $missing_fields[] = $field;
    }
  }

  if (!empty($missing_fields)) {
  
    $_Popup->type = "error";
    $_Popup->msg = "Please fill in all required fields: " . implode(", ", $missing_fields);
    $_Popup->timeout = 5000;
  
  } else {
      
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $codice_fiscale = $_POST['codice_fiscale']; 
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $recipts = array();
    $totalpayedPerCompany[] = array();

    foreach($_SESSION["cart"] as $productID => $amount){
      
      $stmt = $conn->prepare("SELECT ProductID,ProducerID,name,price FROM product WHERE ProductID = ?");
      $stmt->bind_param("i",$productID);
      $stmt->execute();
      $res = $stmt->get_result();
      $product = $res->fetch_assoc();
      $product["amount"] = $amount;
      $producerID = $product["ProducerID"];
      
      $recipts[$producerID][] = $product;

      if(!isset($payedToEachProducer[$producerID])) $payedToEachProducer[$producerID] = 0; //ensure value is initialized
      
      $payedToEachProducer[$producerID] += $product['price'] * $amount;
    }

    foreach($recipts as $producerID => $products){

      $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><receipts></receipts>');
      
      $XMLreceipt = $xml->addChild("receipt");

      $XMLreceipt->addChild("issue_date",date('m/d/Y H:i:s', time()));

      $res = $conn->query("SELECT * FROM producer WHERE ProducerID = ".intval($producerID));

      $producer = $res->fetch_assoc();

      $XMLProducer = $XMLreceipt->addChild("producer");

      $XMLProducer->addChild("ragione_sociale",$producer['ragione_sociale']);
      $XMLProducer->addChild("address",$producer["address"]);
      $XMLProducer->addChild("phone_nmber",$producer["phoneNumber"]);
      $XMLProducer->addChild("email",$producer["email"]);
      $XMLProducer->addChild("PEC",$producer["PEC"]);
      $XMLProducer->addChild("partita_IVA",$producer["partita_IVA"]);
      $XMLProducer->addChild("codice_fiscale",$producer["codice_fiscale"]);

      $XMLcustomer = $XMLreceipt->addChild("customer");
      
      $XMLcustomer->addChild("surname",$_SESSION['profile']['name']);
      $XMLcustomer->addChild("name",$_SESSION['profile']['surname']);
      $XMLcustomer->addChild("email",$_SESSION['profile']['email']);
      $XMLcustomer->addChild("codice_fiscale",$_SESSION['profile']['codice_fiscale']);
      $XMLcustomer->addChild("address",$_SESSION['profile']['address']);
      $XMLcustomer->addChild("phone",$_SESSION['profile']['phone']);
      
      $XMLProducts = $XMLreceipt->addChild("products");


      $q = "INSERT INTO recipt(ProducerID,receiving_ProfileID,total_payed) VALUES (?,?,?)";
      $stmt = $conn->prepare($q);
      $stmt->bind_param("iii",$producerID,$_SESSION['profile']['ProfileID'],$payedToEachProducer[$producerID]);
      $stmt->execute();
      $curr_id = $stmt->insert_id;

      $XMLfilename = $curr_id.'.xml';

      $q = 'UPDATE recipt SET raw_recipt = "'.$XMLfilename.'" WHERE reciptID =  '.intval($curr_id);
      $conn->query($q);

      foreach($products as $product){
        
        $q = "INSERT INTO receipt_product(ReceiptID,ProductID,amount) VALUES (".intval($curr_id).",".intval($product['ProductID']).",".intval($product['amount']).")";
        echo $q;
        $conn->query($q);
        
        $XMLProduct = $XMLProducts->addChild("product");
        
        $XMLProduct->addChild('name',$product['name']);
        $XMLProduct->addChild('unit_price',floatval($product['price'] / 100));
        $XMLProduct->addChild('amount',$product['amount']);
        $XMLProduct->addChild('total_price',floatval(($product['price'] * $product['amount']) / 100));

      }

      $dom = new DOMDocument("1.0");
      $dom->preserveWhiteSpace = false;
      $dom->formatOutput = true;
      $dom->loadXML($XMLreceipt->asXML());
      $dom->save('../receipts/'.$XMLfilename);
      
    }

    header("Location: purchase completed");
    exit();
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <link href="style.css" rel="stylesheet">
</head>
  <body>
    <?php require "../partials/header.php"?>
    <main>
      <?if(isset($_SESSION["profile"])):?>
        <div class="form-box">
          <h2>Checkout</h2>
          <h3>Please confirm your personal information</h3>
          <form method="post">
            <label for="email">Email: </label>
            <input required id="email" type="email" name="email" value="<?=$_SESSION['profile']['email']?>">
            <br>
            <label for="codice_fiscale">codice fiscale: </label>
            <input required id="codice_fiscale" type="text" name="codice_fiscale" value="<?=$_SESSION['profile']['codice_fiscale']?>">
            <br>
            <label for="name">name: </label>
            <input required id="name" type="text" name="name" value="<?=$_SESSION['profile']['name']?>">
            <br>
            <label for="suname">surname: </label>
            <input required id="surname" type="text" name="surname" value="<?=$_SESSION['profile']['surname']?>">
            <br>
            <label for="phone">phone number:</label>
            <input required id="phone" type="text" name="phone" value="<?=$_SESSION['profile']['phone']?>">
            <br>
            <label for="address">addres: </label>
            <input required id="address" type="text" name="address" value="<?=$_SESSION['profile']['address']?>">
            <br>
            <input type="submit" value="confirm purchase">
          </form>
        </div>
      <?endif;?>
    </main>
  </body>
</head>