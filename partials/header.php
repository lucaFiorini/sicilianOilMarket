<?php

 if(session_status() == PHP_SESSION_NONE) 
  session_start();

?>

<header>
  <nav class="horizontal">
    <ul>
      <?php if(isset($_SESSION['profile']['employee'])):?>
      <li>
        <a href="product manager">Manage Products</a>
      </li>
      <?php endif;?>
      <li>
        <a href="products">Products</a>
      </li>
      <li>
        <a href="login.php">Login</a>
      </li>
      <?php if (isset($_SESSION['profile'])):?>
        <li>
          <a href="login.php?logout">Logout</a>
        </li>
      <?php endif?>
    </ul>
    <div class="user-area">
      <a class="cartIcon" onclick="toggleCart()">

        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
          <circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle>
          <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg> 

      </a>

      <image class="profile-pic" src="https://helpx.adobe.com/content/dam/help/en/photoshop/using/convert-color-image-black-white/jcr_content/main-pars/before_and_after/image-before/Landscape-Color.jpg">

      </image>
      <div class="name">
        <?php if (isset($_SESSION['profile'])):?>
          <?=$_SESSION['profile']['name']?>
        <?php else:?>
          Guest
        <?php endif;?>
      </div>
    </div>
  </nav>  
  
  <div class="cart" id="cart">
    <div class="items">

    </div>
    <button class="purchase" onclick='location.href="purchase"'>purchase</button>
  </div>

  <div class="item hidden" id="cart-item-model">
    <img class="image">
    <div class="name"></div>
    <input class="amount" type="number" value="1" min="0" maxlength="3">
    <input class="ID" type="hidden">
  </div>

</header>

<?php if (isset($_Popup->msg)):?>
  <div class="popup <?= $_Popup->type ?>" value-timeout=<?=$_Popup->timeout?> value-on_close_redirect=<?=$_Popup->onCloseRedirect?>>
    <?= $_Popup->msg ?>
  </div>  
<?php endif?>

<script>

  // Function to show the popup
  function showPopup(popup) {
    popup.style.top = '60px'; // Display the popup below the navbar
    
    // Hide the popup after 10 seconds
    setTimeout(() => {
      if(ppopup.dataset.on_close_redirect !== undefined && popup.dataset.on_close_redirect !== ""){
        window.location.href = popup.dataset.on_close_redirect;
      } else hidePopup(popup);
    }, popup.dataset.timeout); // 10 seconds in milliseconds
  }

  // Function to hide the popup
  function hidePopup(popup) {
    popup.style.top = '-100px'; // Hide the popup above the viewport
  }

  // Select all elements with the class "popup"
  const popups = document.querySelectorAll('.popup');

  document.addEventListener('DOMContentLoaded', function() {
    // Loop through each popup element
    popups.forEach(popup => {
    showPopup(popup);
    // Attach a click event listener to show the popup
    popup.addEventListener('click', () => hidePopup(popup));

  });

  }, false);

  cartElement = document.getElementById("cart");

  function addToCart(productID){
    updateCart(productID,1);
  }
  function updateCart(productID,amount){

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {

      const data = JSON.parse(this.responseText);

      if(data["status"] != "ok"){
        
        console.log(data["error"]);
      }

      loadCart();

    }

    xhttp.open("GET", "api/cart/update.php?ProductID="+productID.toString()+"&amount="+amount.toString());
    xhttp.send();

  }

  function loadCart(){
    const cart = document.getElementById("cart");

    const cartItems = cart.getElementsByClassName("items")[0];

    const cartItemModel = document.getElementById("cart-item-model");

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function(){
      
      const resp = JSON.parse(this.responseText);

      cartItems.innerHTML = '';
      const purchaseBTN = cart.getElementsByClassName("purchase")[0];

      if(resp === null){

        cartItems.innerHTML = "No products found in cart";
        purchaseBTN.classList.add("hidden");
        return;

      }

      resp.forEach(item => {

        purchaseBTN.classList.remove("hidden");

        const newNode = cartItemModel.cloneNode(true);
        newNode.classList.remove("hidden");

        const image = newNode.getElementsByClassName("image")[0];
        const name = newNode.getElementsByClassName("name")[0];
        const amount = newNode.getElementsByClassName("amount")[0];

        image.src =item["image"];
        name.innerHTML = item["name"];
        amount.value = item["amount"];
        
        amount.onchange = function(){
          updateCart(item["ID"],amount.value);
        }

        cartItems.appendChild(newNode);

      });


    }

    xhttp.open("GET", "api/cart/get.php");
    xhttp.send();
    
  }

  loadCart();

  function toggleCart(){
    const cart = document.getElementById("cart");
    cart.style.right = cart.style.right == "0px" ? "-300px" : "0px";
  }

</script>