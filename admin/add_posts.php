<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_POST['publish'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $title = $_POST['title'];
   $title = filter_var($title, FILTER_SANITIZE_STRING);
   $content = $_POST['content'];
   $content = filter_var($content, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/' . $image;

   $select_image = $conn->prepare("SELECT * FROM `posts` WHERE image = ? AND admin_id = ?");
   $select_image->execute([$image, $admin_id]);

   if (isset($image)) {
      if ($select_image->rowCount() > 0 and $image != '') {
         $errorMsg[] = 'image name repeated!';
      } elseif ($image_size > 2000000) {
         $errorMsg[] = 'images size is too large!';
      } else {
         move_uploaded_file($image_tmp_name, $image_folder);
      }
   } else {
      $image = '';
   }

   if ($select_image->rowCount() > 0 and $image != '') {
      $errorMsg[] = 'please rename your image!';
   } else {
      $insert_post = $conn->prepare("INSERT INTO `posts`(admin_id, name, title, content, category, image) VALUES(?,?,?,?,?,?)");
      $insert_post->execute([$admin_id, $name, $title, $content, $category, $image]);
      $successMsg[] = 'post published!';
   }

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Add Post</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>


   <?php include '../components/admin_header.php' ?>

   <section class="post-editor">

      <h1 class="heading">add new post</h1>

      <?php
      $select_category = $conn->prepare('SELECT * FROM `categories`');
      $select_category->execute();
      ?>

      <form action="" method="post" enctype="multipart/form-data">
         <input type="hidden" name="name" value="<?= $fetch_profile['name']; ?>">
         <p>post title <span>*</span></p>
         <input type="text" name="title" maxlength="100" required placeholder="add post title" class="box">
         <p>post content <span>*</span></p>
         <textarea name="content" class="box" required maxlength="10000" placeholder="write your content..." cols="30"
            rows="10"></textarea>
         <p>post category <span>*</span></p>
         <select name="category" class="box" required>
            <option value="" selected disabled>-- select category* </option>
            <?php
            if ($select_category->rowCount() > 0) {
               while ($fetch_category = $select_category->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                  <option value="<?= $fetch_category['title'] ?>">
                     <?= $fetch_category['title'] ?>
                  </option>
               <?php }
            } else {
               ?>
               <option>No Category Added</option>
            <?php } ?>
         </select>
         <p>post image</p>
         <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
         <div class="buttons">
            <input type="submit" value="publish post" name="publish" class="btn">
         </div>
      </form>

   </section>










   <!-- custom js file link  -->
   <script src="../js/admin_script.js"></script>

</body>

</html>