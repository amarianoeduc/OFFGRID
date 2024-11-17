<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/sarili.css">


   <style>
 
   </style>

</head>
<body>
   <div class="preloader">
   </div>  
   
<?php include 'header.php'; ?>

   

<section class="home">

   <div class="content">
      <h3>44' Matrix collection</h3>
      <p>Dive into bold street style with our 44' Matrix Collection – where unique designs redefine fashion. Make a statement effortlessly.</p>
      <a href="shop.php" class="white-btn">discover more</a>
   </div>

</section>

<section class="products">

   <h1 class="title">collection</h1>

   <div class="box-container">

      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <a href="prod_detail.php?id=<?php echo $fetch_products['id']; ?>" class="box-link">
      <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <!-- <div class="cats"><i class="fa-regular fa-heart"></i></div> -->
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <div class="semprice">₱ <?php echo $fetch_products['price']; ?></div>
      <!-- <input type="number" min="1" name="product_quantity" value="1" class="qty"> -->
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <!-- <input type="submit" value="add to cart" name="add_to_cart" class="btn"> -->
     </form>
      </a>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="option-btn">load more</a>
   </div>

</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/abts.png" alt="">
      </div>

      <div class="content">
         <h3>about us</h3>
         <p>
            Welcome to "OFF-GRID," your ultimate destination for cutting-edge streetwear that transcends boundaries and redefines urban fashion. At OFF-GRID, we celebrate the spirit of individuality and self-expression through a curated collection of street-inspired clothing that resonates with the pulse of the city.</p>
         <a href="about.php" class="btn">read more</a>
      </div>

   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>have any questions?</h3>
      <p>"Questions on your mind? Feel free to ask!"</p>
      <a href="contact.php" class="white-btn">contact us</a>
   </div>

</section>





<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>