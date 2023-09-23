<?php

include '../components/connect.php';

session_start();

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);

   if ($select_admin->rowCount() > 0) {
      $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
      $_SESSION['admin_id'] = $fetch_admin_id['id'];
      header('location:dashboard.php');
   } else {
      $errorMsg[] = 'Incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body style="padding-left: 0 !important;">

   <?php
   if (isset($errorMsg)) {
      foreach ($errorMsg as $errorMsg) {
         echo '
            <div class="message errorMsg">
               ' . $errorMsg . '
               <i class="fas fa-xmark" onclick="this.parentElement.remove()"></i>
            </div>
            ';
      }

   }
   ?>

   <!-- admin login form section starts  -->

   <section class="form-container">

      <form action="" method="POST">
         <h3><span>Kanhaiya</span> Panel</h3>
         <input type="text" name="name" maxlength="20" required placeholder="username" class="box"
            oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="pass" maxlength="20" required placeholder="password" class="box"
            oninput="this.value = this.value.replace(/\s/g, '')">
         <div class="buttons">
            <input type="submit" value="login now" name="submit" class="btn">
         </div>
      </form>

   </section>

   <!-- admin login form section ends -->











</body>

</html>