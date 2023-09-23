<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="home.php" class="logo"><span>.Kan</span>haiya</a>

      <nav class="navbar">
         <a href="home.php">home</a>
         <a href="posts.php">posts</a>
         <a href="#">about</a>
         <a href="#">contact</a>
      </nav>

      <form action="search.php" method="POST" class="search-form">
         <input type="text" name="search_box" class="box" maxlength="100" placeholder="search for blogs" required>
         <button type="submit" class="fas fa-search" name="search_btn"></button>
      </form>

      <div class="icons">
         <div id="search-btn" class="fas fa-search"></div>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

     

   </section>

</header>