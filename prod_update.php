<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}


$last_added_item_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1") or die('query failed');
$last_added_item = mysqli_fetch_assoc($last_added_item_query);

if (isset($_POST['update_cart'])) {
    if ($last_added_item) {
        $updated_size = $_POST['size'];
        $updated_quantity = $_POST['product_quantity'];
        $cart_id = $last_added_item['id'];
        mysqli_query($conn, "UPDATE `cart` SET size = '$updated_size', quantity = '$updated_quantity' WHERE id = '$cart_id' AND user_id = '$user_id'") or die('update query failed');
        header('location:cart.php');
        $message[] = 'Cart item updated successfully!';
    } else {
        $message[] = 'No cart item found for the user!';
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
                <option value="small" <?php echo ($last_added_item['size'] == 'small') ? 'selected' : ''; ?>>Small</option>
                <option value="medium" <?php echo ($last_added_item['size'] == 'medium') ? 'selected' : ''; ?>>Medium</option>
                <option value="large" <?php echo ($last_added_item['size'] == 'large') ? 'selected' : ''; ?>>Large</option>
            </select>

            <label for="quantity">Quantity:</label>
            <input type="number" min="1" name="product_quantity" value="<?php echo $last_added_item['quantity']; ?>" id="quantity">

            <input type="hidden" name="product_name" value="<?php echo $last_added_item['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $last_added_item['price']; ?>">
            <div class="ddd"></div>
            <input type="hidden" name="product_image" value="<?php echo $last_added_item['image']; ?>">
            <div class="shs"></div>
            <input type="hidden" name="update_cart" value="true">
            <input type="submit" value="Update Item" name="add_to_cart" class="btn">
            <input type="button" value="Back" name="back" class="btn-2" onclick="goBackToCart()">
        </form>
      </div>
      <?php
      } else {
         echo '<p class="empty">No product selected!</p>';
      }
      ?>

   </section>

   <script>
    function goBackToCart() {
        window.location.href = "cart.php";
    }
   </script>

   <?php include 'footer.php'; ?>

   <script src="js/script.js"></script>

</body>
</html>
