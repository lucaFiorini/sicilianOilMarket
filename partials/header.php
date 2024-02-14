<?php

 if(session_status() == PHP_SESSION_NONE) 
  session_start();

?>
<script>
  function goToCart(){
    let params = '';
    cart.forEach((item) => {
      params+='cart[]='+item+'&'
    })

    document.location.replace('cart?' + params);
  }
</script>
<header>
  <nav class="horizontal">
    <ul>
      <li>
        <a href="create product">Crea Prodotto</a>
      </li>
      <li>
        <a href="products">Prodotti</a>
      </li>
      <li>
        <a href="login.php">Login</a>
      </li>
    </ul>
    <div class="user-area">
      <a class="cart" onclick="goToCart()">

        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
          <circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle>
          <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg> 

      </a>

      <image class="profile-pic" src="https://helpx.adobe.com/content/dam/help/en/photoshop/using/convert-color-image-black-white/jcr_content/main-pars/before_and_after/image-before/Landscape-Color.jpg">

      </image>
      <div class="name">
        <?php if (isset($_SESSION['name'])):?>
          <?=$_SESSION['name']?>
        <?php else:?>
          Guest
        <?php endif;?>
      </div>
    </div>
  </nav>        
</header>  
