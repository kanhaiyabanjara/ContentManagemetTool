<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

$get_id = $_GET['post_id'];



?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Post Read</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

   <?php include '../components/admin_header.php' ?>

   <section class="read-post">

      <?php
      $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE admin_id = ? AND id = ?");
      $select_posts->execute([$admin_id, $get_id]);
      if ($select_posts->rowCount() > 0) {
         while ($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)) {
            $post_id = $fetch_posts['id'];

            ?>
            <form method="post">
               <input type="hidden" name="post_id" value="<?= $post_id; ?>">
               <div class="title">
                  <?= $fetch_posts['title']; ?>
               </div>
               <?php if ($fetch_posts['image'] != '') { ?>
                  <img src="../uploaded_img/<?= $fetch_posts['image']; ?>" class="image" alt="">
               <?php } ?>
               <div class="content">
                  <?= $fetch_posts['content']; ?>
               </div>
            </form>
            <?php
         }
      } else {
         echo '<p class="empty">no posts added yet!</p>';
      }
      ?>

   </section>

   <!-- custom js file link  -->
   <script src="../js/admin_script.js"></script>

</body>

</html>