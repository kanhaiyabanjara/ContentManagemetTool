<?php

if (isset($successMsg)) {
   foreach ($successMsg as $successMsg) {
      echo '
         <div class="message successMsg">
            ' . $successMsg . '
            <i class="fas fa-xmark" onclick="this.parentElement.remove()"></i>
         </div>
         ';
   }

}

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


$select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
$select_profile->execute([$admin_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);


?>


<header class="header">

   <a href="dashboard.php" class="logo">Kanhaiya <span> Panel</span></a>


   <a href="add_posts.php" class="add-post-btn"><i class="fas fa-plus"></i> <span>add posts</span></a>

   <nav class="navbar">
      <a href="dashboard.php"><i class="fas fa-home"></i> <span>Home</span></a>
      <a href="manage_post.php"><i class="fas fa-pen"></i> <span>Manage posts</span></a>
      <a href="add_category.php"><i class="fas fa-tag"></i> <span>Add Categories</span></a>
      <a href="manage_category.php"><i class="fas fa-list"></i> <span>Manage Categories</span></a>
      <a href="../components/admin_logout.php" style="color:var(--orange);"
         onclick="return confirm('logout from the website?');"><i
            class="fas fa-right-from-bracket"></i><span>logout</span></a>
   </nav>




   <!-- <div class="flex-btn">
      <a href="admin_login.php" class="option-btn">login</a>
      <a href="register_admin.php" class="option-btn">register</a>
   </div> -->

</header>

<div id="menu-btn" class="fas fa-bars"></div>