<?php

 if(session_status() == PHP_SESSION_NONE) 
  session_start();

?>

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
      <?php if (isset($_SESSION["ProfileID"])):?>
      <li>
        <a href="login.php?logout">Logout</a>
      </li>
      <?php endif?>
    </ul>
    <div class="user-area">
      <a class="cart">

        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
          <circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle>
          <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg> 

      </a>

      <image class="profile-pic" src="https://helpx.adobe.com/content/dam/help/en/photoshop/using/convert-color-image-black-white/jcr_content/main-pars/before_and_after/image-before/Landscape-Color.jpg">

      </image>
      <div class="name">
        <?php if (isset($_SESSION['ProfileID'])):?>
          <?=$_SESSION['name']?>
        <?php else:?>
          Guest
        <?php endif;?>
      </div>
    </div>
  </nav>        
</header>

<?php if (isset($_Popup->msg)):?>
  <div class="popup <?= $_Popup->type ?>">
    <?= $_Popup->msg ?>
  </div>  
<?php endif?>

<script>
  // Function to show the popup
  function showPopup(popup) {
    popup.style.top = '60px'; // Display the popup below the navbar
    
    // Hide the popup after 10 seconds
    setTimeout(() => {
      hidePopup(popup);
    }, 10000); // 10 seconds in milliseconds
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

</script>