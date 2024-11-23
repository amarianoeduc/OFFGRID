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

$select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Product Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .heading {
            text-align: center;
            margin-bottom: 2rem;
            padding: 1.2rem;
            background: #f8f9fa;
        }

        .heading h3 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .heading p {
            font-size: 1.5rem;
            color: #666;
        }

        .heading p a {
            color: #3498db;
            text-decoration: none;
        }

        .heading p a:hover {
            text-decoration: underline;
        }

        .product-details {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .product-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 30px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .image-container {
            flex: 0 0 50%;
            max-width: 600px;
        }

        .image-container .image {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 8px;
            display: block;
        }

        .details-container {
            flex: 0 0 45%;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .details-container .name {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }

        .details-container .price {
            font-size: 22px;
            color: #e74c3c;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .details-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .details-container label {
            font-weight: 500;
            color: #444;
            margin-bottom: 5px;
        }

        .details-container select,
        .details-container input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }

        .details-container .btn,
        .details-container .btn-2 {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .details-container .btn {
            background-color: #27ae60;
            color: white;
            margin-bottom: 10px;
        }

        .details-container .btn-2 {
            background-color: #3498db;
            color: white;
        }

        .details-container .btn:hover {
            background-color: #219a52;
        }

        .details-container .btn-2:hover {
            background-color: #2980b9;
        }

        .empty {
            text-align: center;
            padding: 20px;
            font-size: 18px;
            color: #666;
        }

        /* Ensuring side by side layout is maintained */
        @media (max-width: 768px) {
            .product-info {
                flex-direction: row;
                flex-wrap: nowrap;
            }

            .image-container,
            .details-container {
                flex: 0 0 50%;
                min-width: 0;
            }

            .details-container {
                padding: 10px;
            }

            .details-container .name {
                font-size: 20px;
            }

            .details-container .price {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>Product Details</h3>
        <p><a href="home.php">Home</a> / <a href="shop.php">Shop</a> / Product Details</p>
    </div>

    <section class="product-details">
        <?php
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $product_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = $id") or die('query failed');
            $fetch_product = mysqli_fetch_assoc($product_query);
        ?>
        <div class="product-info">
            <div class="image-container">
                <img class="image" src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="<?php echo $fetch_product['name']; ?>">
            </div>
            <div class="details-container">
                <div class="name"><?php echo $fetch_product['name']; ?></div>
                <div class="price">₱<?php echo number_format($fetch_product['price'], 2); ?></div>

                <form action="" method="post">
                    <label for="size">Size:</label>
                    <select name="size" id="size" required>
                        <option value="small">Small</option>
                        <option value="medium">Medium</option>
                        <option value="large">Large</option>
                    </select>

                    <label for="quantity">Quantity:</label>
                    <input type="number" min="1" name="product_quantity" value="1" id="quantity" required>

                    <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                    
                    <input type="submit" value="Add to Cart" name="add_to_cart" class="btn">
                    <input type="button" value="Back to Shop" name="back" class="btn-2" onclick="goBackToShop()">
                </form>
            </div>
        </div>
        <?php
        } else {
            echo '<p class="empty">No product selected!</p>';
        }
        ?>
    </section>

    <?php include 'footer.php'; ?>

    <script>
        function goBackToShop() {
            window.location.href = "shop.php";
        }
    </script>

    <script src="js/script.js"></script>
</body>
</html>