<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if (isset($_POST['add_to_cart'])) {
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];
   $product_size = $_POST['size'];

   $product_query = mysqli_query($conn, "SELECT id FROM `products` WHERE name = '$product_name'");
   
   if ($product_query && $product_data = mysqli_fetch_assoc($product_query)) {
       $product_id = $product_data['id'];

       $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE product_id = '$product_id' AND user_id = '$user_id'");
       
       if (mysqli_num_rows($check_cart_numbers) > 0) {
           $message[] = 'already added to cart!';
       } else {
           mysqli_query($conn, "INSERT INTO `cart`(user_id, product_id, name, price, quantity, image, size) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image', '$product_size')") or die('query failed');
           $message[] = 'product added to cart!';
       }
   } else {
       $message[] = 'Product not found!';
   }
}

if (isset($_POST['buy_now'])) {
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];
   $product_size = $_POST['size'];

   $move_to_previous_cart_query = mysqli_query($conn, "INSERT INTO `previous_cart` (user_id, name, price, quantity, image, size) SELECT user_id, name, price, quantity, image, size FROM `cart` WHERE user_id = '$user_id'") or die('query failed');

   if ($move_to_previous_cart_query) {
       mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');

       mysqli_query($conn, "INSERT INTO `cart` (user_id, name, price, quantity, image, size) VALUES ('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image', '$product_size')") or die('query failed');

       header("Location: checkout.php?name=$product_name&price=$product_price&image=$product_image&quantity=$product_quantity&size=$product_size");
       exit();
   } else {
       die('Failed to move items to previous_cart table');
   }
}

$last_added_item_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1") or die('query failed');
$last_added_item = mysqli_fetch_assoc($last_added_item_query);

$category_query = mysqli_query($conn, "SELECT DISTINCT category FROM `products`") or die('query failed');
$categories = mysqli_fetch_all($category_query, MYSQLI_ASSOC);

$selected_category = isset($_GET['category']) ? $_GET['category'] : '';
$category_filter = !empty($selected_category) ? "WHERE category = '$selected_category'" : '';

$select_products = mysqli_query($conn, "SELECT * FROM `products` $category_filter") or die('query failed');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/sarili.css">
</head>
<body>
    <div class="preloader">
   </div>  

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>Product Details</h3>
      <p> <a href="home.php">Home</a> / <a href="shop.php">Shop</a> / Product Details</p>
   </div>

   <section class="product-details">

      <?php
      if(isset($_GET['id'])){
         $id = $_GET['id'];
         $product_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = $id") or die('query failed');
         $fetch_product = mysqli_fetch_assoc($product_query);
      ?>
      <div class="product-info">
         <img class="image" src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="">
         <div class="name" style="text-align: left;"><?php echo $fetch_product['name']; ?></div>
         <div class="price" style="text-align: left;">PRICE: ₱ <?php echo $fetch_product['price']; ?></div>

         <form action="" method="post">
            <label for="size">Size:</label>
            <select name="size" id="size">
               <option value="small">Small</option>
               <option value="medium">Medium</option>
               <option value="large">Large</option>
            </select>

            <label for="quantity">Quantity:</label>
            <input type="number" min="1" name="product_quantity" value="1" id="quantity">

            <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
            <div class="ddd"></div>
            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
            <div class="shs"></div>
            <input type="submit" value="Add to Cart" name="add_to_cart" class="btn">
            <input type="button" value="Back" name="back" class="btn-2" onclick="goBackToShop()">
            <!-- <input type="submit" value="Buy Now" name="buy_now" class="btn"> -->
         </form>
      </div>
      <?php
      } else {
         echo '<p class="empty">No product selected!</p>';
      }
      ?>

   </section>

   <script>
    function goBackToShop() {
        window.location.href = "shop.php";
    }
   </script>

   <?php include 'footer.php'; ?>

   <script src="js/script.js"></script>

</body>
</html>
