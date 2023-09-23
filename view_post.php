<?php

include 'components/connect.php';

$get_id = $_GET['post_id'];

$select_title = $conn->prepare('SELECT title FROM `posts` WHERE id = ?');
$select_title->execute([$get_id]);
$fetch_title = $select_title->fetch(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>
      <?= $fetch_title['title']; ?>
   </title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <!-- header section starts  -->
   <?php include 'components/user_header.php'; ?>
   <!-- header section ends -->


   <section class="posts-container" style="padding-bottom: 0;">

      <div class="box-container">

         <?php
         $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE id = ?");
         $select_posts->execute([$get_id]);
         if ($select_posts->rowCount() > 0) {
            while ($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)) {

               $post_id = $fetch_posts['id'];
               ?>
               <form class="box" method="post">
                  <input type="hidden" name="post_id" value="<?= $post_id; ?>">
                  <input type="hidden" name="admin_id" value="<?= $fetch_posts['admin_id']; ?>">
                  <div class="post-title">
                     <?= $fetch_posts['title']; ?>
                  </div>
                  <div class="post-page-admin">
                     <div class="post-admin">
                        <i class="fas fa-user"></i>
                        <div>
                           <a href="author_posts.php?author=<?= $fetch_posts['name']; ?>">
                              <?= $fetch_posts['name']; ?>
                           </a>
                           <div>
                              <?= $fetch_posts['date']; ?>
                           </div>
                        </div>
                     </div>
                     <div>
                        <a href="category.php?category=<?= $fetch_posts['category']; ?>" class="post-cat category"> <i
                              class="fas fa-tag"></i> <span>
                              <?= $fetch_posts['category']; ?>
                           </span></a>
                     </div>
                  </div>

                  <?php
                  if ($fetch_posts['image'] != '') {
                     ?>
                     <img src="uploaded_img/<?= $fetch_posts['image']; ?>" class="post-image" alt="">
                     <?php
                  }
                  ?>
                  <div class="post-content">
                     <?= $fetch_posts['content']; ?>
                  </div>
               </form>
               <?php
            }
         } else {
            echo '<p class="empty">no posts found!</p>';
         }
         ?>
      </div>

   </section>




   <?php include 'components/footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>


</body>

</html>