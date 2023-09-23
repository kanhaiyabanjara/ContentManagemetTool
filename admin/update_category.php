<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_POST['update'])) {
    $cat_id = $_POST['cat-id'];
    $cat_title = $_POST['cat-title'];
    $cat_title = filter_var($cat_title, FILTER_SANITIZE_SPECIAL_CHARS);
    $cat_des = $_POST['cat-description'];
    $cat_des = filter_var($cat_des, FILTER_SANITIZE_SPECIAL_CHARS);

    $cat_update = $conn->prepare('UPDATE `categories` SET title = ?, description = ? WHERE id = ?');
    $cat_update->execute([$cat_title, $cat_des, $cat_id]);
    $message[] = "Category Updated";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>


    <?php include '../components/admin_header.php' ?>

    <section class="add-category">

        <h1 class="heading">Edit category</h1>

        <div class="category-container">
            <?php
            $ca_id = $_GET['id'];
            $update_select = $conn->prepare('SELECT * FROM `categories` WHERE id = ?');
            $update_select->execute([$ca_id]);
            if ($update_select->rowCount() > 0) {
                while ($fetch_category = $update_select->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <form action="" method="POST" enctype="multipart/form-data" class="category-box">
                        <input type="hidden" name="cat-id" value="<?= $ca_id; ?>">
                        <p>category name <span>*</span></p>
                        <input type="text" name="cat-title" maxlength="100" required placeholder="add category name" class="box"
                            value="<?= $fetch_category['title']; ?>">
                        <p>category description <span>*</span></p>
                        <input type="text" name="cat-description" maxlength="100" required
                            placeholder="add category description" class="box" value="<?= $fetch_category['description']; ?>">
                    <?php } ?>
                    <div class="buttons">
                        <input type="submit" name="update" value="Update" class="btn">
                    </div>
                </form>
            <?php } ?>
        </div>
    </section>










    <!-- custom js file link  -->
    <script src="../js/admin_script.js"></>

</body >

</html >