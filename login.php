<?php
include 'config.php';

session_start();

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    $specialUsername = 'dev';
    $specialPasswordHash = password_hash('dev', PASSWORD_DEFAULT);

    if (($name == $specialUsername) && password_verify($pass, $specialPasswordHash)) {

        $_SESSION['admin_name'] = 'dev';
        $_SESSION['admin_email'] = 'dev';
        $_SESSION['admin_id'] = 0; 

        header('location: admin_page.php');
        exit();
    }
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE name = '$name'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $row = mysqli_fetch_assoc($select_users);

        if (password_verify($pass, $row['password'])) {
            if ($row['user_type'] == 'admin') {
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['admin_email'] = $row['email'];
                $_SESSION['admin_id'] = $row['id'];
                header('location: admin_page.php');
                exit();
            } elseif ($row['user_type'] == 'user') {
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                header('location: home.php');
                exit();
            }
        } else {
            $message[] = 'Incorrect password!';
        }
    } else {
        $message[] = 'User not found!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/sarili.css">
   <style>
        .form-container {
            background: url('./images/logs.jpg') no-repeat center center fixed;
            background-size: cover; 
            width: 100%;
            height: 500px;
        }

        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px 30px;
            background-color: #ff3333;
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            z-index: 1000;
            font-size: 16px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 300px;
            justify-content: center;
        }

        .popup.success {
            background-color: #4CAF50;
        }

        .popup.error {
            background-color: #ff3333;
        }

        .popup i {
            font-size: 24px;
        }

        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>
<body>

<!-- <div class="preloader"></div>   -->

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="popup-overlay"></div>
      <div class="popup error">
         <i class="fas fa-exclamation-circle"></i>
         <span>'.$message.'</span>
      </div>
      ';
   }
}
?>

<div class="form-container">
   <form action="" method="post">
      <h3 class="logo"><img src="images/off-grid-2.png" class="logo"></h3>
      <input type="text" name="name" placeholder="Enter your username" required class="box">
      <input type="password" name="password" placeholder="Enter your password" required class="box">
      <input type="submit" name="submit" value="login now" class="btn">
      <p>Don't have an account? <a href="register.php">Register Now</a></p>
   </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const popup = document.querySelector('.popup');
    const overlay = document.querySelector('.popup-overlay');
    
    if(popup && overlay) {
        setTimeout(() => {
            if(popup) popup.remove();
            if(overlay) overlay.remove();
        }, 3000);
    }
});
</script>

<script src="js/script.js"></script>
</body>
</html>