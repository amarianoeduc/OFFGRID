<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
      </div>
      ';
   }
}
?>

<script>
   document.addEventListener('DOMContentLoaded', function() {
      var messages = document.querySelectorAll('.message');

      messages.forEach(function(message) {
         setTimeout(function() {
            message.style.display = 'none';
         }, 3000); 
      });
   });
</script>

<header class="header">
   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo"><img src="images/off-grid-2.png" class="logo"></a>

         <nav class="navbar">
            <a href="home.php" style="font-size: 13px;">HOME</a>
            <a href="about.php" style="font-size: 13px;">ABOUT</a>
            <a href="shop.php" style="font-size: 13px;">SHOP</a>
            <a href="collection.php" style="font-size: 13px;">VAULT</a>
            <a href="contact.php" style="font-size: 13px;">CONTACT</a>
            <a href="orders.php" style="font-size: 13px;">ORDERS</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>  
            <div id="user-btn" class="fas fa-user"></div>
            <?php
               $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
               $cart_rows_number = mysqli_num_rows($select_cart_number); 
            ?>
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
         </div>

         <div class="user-box">
            <p style="text-align: left;">Username : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p style="text-align: left;">Email : <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">Logout</a>
         </div>
      </div>
   </div>

</header>