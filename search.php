<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}
;

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>search page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <?php
   if (isset($_POST['search_box']) or isset($_POST['search_btn'])) {
      ?>
      <section class="posts-container">

         <div class="box-container">

            <?php
            $search_box = $_POST['search_box'];
            $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE title LIKE '%{$search_box}%' OR category LIKE '%{$search_box}%' OR name LIKE '%{$search_box}%'");
            $select_posts->execute();
            if ($select_posts->rowCount() > 0) {
               while ($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)) {

                  $post_id = $fetch_posts['id'];
                  ?>
                  <form class="box" method="post">
                     <input type="hidden" name="post_id" value="<?= $post_id; ?>">
                     <input type="hidden" name="admin_id" value="<?= $fetch_posts['admin_id']; ?>">
                     <?php
                     if ($fetch_posts['image'] != '') {
                        ?>
                        <a href="view_post.php?post_id=<?= $post_id; ?>">
                           <img src="uploaded_img/<?= $fetch_posts['image']; ?>" class="post-image" alt="">
                        </a>
                        <?php
                     }
                     ?>
                     <div class="post-title">
                        <a href="view_post.php?post_id=<?= $post_id; ?>">
                           <?= $fetch_posts['title']; ?>
                        </a>
                     </div>
                     <div class="post-admin">
                        <a href="author_posts.php?author=<?= $fetch_posts['name']; ?>">
                           <?= $fetch_posts['name']; ?>
                        </a>
                        <div>
                           <?= $fetch_posts['date']; ?>
                        </div>
                     </div>
                     <div class="post-content content-150">
                        <?= $fetch_posts['content']; ?>
                     </div>
                     <a href="category.php?category=<?= $fetch_posts['category']; ?>" class="post-cat"> <i
                           class="fas fa-tag"></i> <span>
                           <?= $fetch_posts['category']; ?>
                        </span></a>
                  </form>
                  <?php
               }
            } else {
               echo '<p class="empty">no result found!</p>';
            }
            ?>
         </div>

      </section>

      <?php
   } else {
      echo '<section><p class="empty">search something!</p></section>';
   }
   ?>

   <?php include 'components/footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>