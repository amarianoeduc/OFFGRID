<?php

include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

$id = $_GET['update'];
$sql = "SELECT * FROM `users` WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$name = $row['name'];
$email = $row['email'];
$user_type = $row['user_type'];

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $user_type = $_POST['user_type'];

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND id != $id") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $message[] = 'Email is already in use by another user!';
    } else {
        if (!empty($_POST['password']) || !empty($_POST['cpassword'])) {
            $password = $_POST['password'];
            $cpassword = $_POST['cpassword'];

            if (strlen($password) < 6) {
                $message[] = 'Password must be at least 6 characters long!';
            } else {
                $pass = mysqli_real_escape_string($conn, password_hash($password, PASSWORD_DEFAULT));
                $cpass = mysqli_real_escape_string($conn, password_hash($cpassword, PASSWORD_DEFAULT));

                mysqli_query($conn, "UPDATE `users` SET name = '$name', email = '$email', user_type = '$user_type', password = '$cpass' WHERE id = $id") or die('query failed');
                $message[] = 'Profile updated successfully!';
                header('location:admin_users.php');
            }
        } else {
            mysqli_query($conn, "UPDATE `users` SET name = '$name', email = '$email', user_type = '$user_type' WHERE id = $id") or die('query failed');
            $message[] = 'Profile updated successfully!';
            header('location:admin_users.php');
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
   <title>Update Profile</title>
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

   <form method="post">
      <h3>Update Profile</h3>
      <input type="text" name="name" placeholder="Your name" value="<?php echo $name; ?>" required class="box">
      <input type="email" name="email" placeholder="Your email" value="<?php echo $email; ?>" required class="box">
      <input type="password" name="password" placeholder="New password (optional)" class="box">
      <input type="password" name="cpassword" placeholder="Confirm new password (optional)" class="box">
      <select name="user_type" class="box">
         <option value="user" <?php echo ($user_type == 'user') ? 'selected' : ''; ?>>User</option>
         <option value="admin" <?php echo ($user_type == 'admin') ? 'selected' : ''; ?>>Admin</option>
      </select>
      <input type="submit" name="submit" value="Update Profile" class="btn">
   </form>

</div>

<script src="js/script-2.js"></script>

</body>
</html>
