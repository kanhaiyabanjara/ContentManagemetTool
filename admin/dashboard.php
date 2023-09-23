<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

   <?php include '../components/admin_header.php' ?>

   <section class="show-posts">

      <h1 class="heading">Dashboard</h1>

      <div class="box-container">

         <?php
         $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE admin_id = ?");
         $select_posts->execute([$admin_id]);
         if ($select_posts->rowCount() > 0) {
            while ($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)) {
               $post_id = $fetch_posts['id'];
               ?>
               <form method="post" class="box">
                  <input type="hidden" name="post_id" value="<?= $post_id; ?>">
                  <?php if ($fetch_posts['image'] != '') { ?>
                     <a href="read_post.php?post_id=<?= $post_id; ?>">
                        <img src="../uploaded_img/<?= $fetch_posts['image']; ?>" class="image" alt="">
                     </a>
                  <?php } ?>
                  <div class="post-container">
                     <a href="read_post.php?post_id=<?= $post_id; ?>">
                        <div class="title">
                           <?= $fetch_posts['title']; ?>
                        </div>
                     </a>
                     <div>
                        <div class="post-date">Published.
                           <?= $fetch_posts['date']; ?>
                        </div>
                        <div class="post-category">
                           <?= $fetch_posts['category']; ?>
                        </div>
                     </div>
                  </div>
               </form>
               <?php
            }
         } else {
            echo '<p class="empty">no posts added yet!</p>';
         }
         ?>

      </div>


   </section>









   <!-- custom js file link  -->
   <script src="../js/admin_script.js"></script>

</body>

</html>