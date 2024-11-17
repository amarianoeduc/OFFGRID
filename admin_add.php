<?php
include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($_SESSION['admin_name'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if (strlen($password) < 6) {
        $message[] = 'Password must be at least 6 characters long!';
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

        if (mysqli_num_rows($select_users) > 0) {
            $message[] = 'User already exists!';
        } else {
            if (password_verify($cpassword, $hashedPassword)) {
                mysqli_query($conn, "INSERT INTO `users` (name, email, password) VALUES ('$name', '$email', '$hashedPassword')") or die('query failed');
                $message[] = 'Registered successfully!';
                header('location:login.php');
            } else {
                $message[] = 'Confirm password not matched!';
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/sarili.css">

</head>
<body>

<div class="preloader">
   </div>  

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
   
<div class="form-container">

   <form action="" method="post">
      <h3>ADD ACCOUNT</h3>
      <input type="text" name="name" placeholder="enter your name" required class="box">
      <input type="email" name="email" placeholder="enter your email" required class="box">
      <input type="password" name="password" placeholder="enter your password" required class="box">
      <input type="password" name="cpassword" placeholder="confirm your password" required class="box">
      <input type="submit" name="submit" value="register now" class="btn">
      <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn">Back</a>
   </form>


</div>
<script src="js/script-2.js"></script>
</body>
</html>