<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}


try {

    if (isset($_POST['add'])) {
        $title = $_POST['cat-title'];
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $catdescription = $_POST['cat-description'];
        $catdescription = filter_var($catdescription, FILTER_SANITIZE_SPECIAL_CHARS);

        $select_category = $conn->prepare('SELECT * FROM `categories` where title = ?');
        $select_category->execute([$title]);

        if ($select_category->rowCount() > 0) {
            $errorMsg[] = 'Category Already Exist';
        } else {
            $insert_category = $conn->prepare('INSERT INTO `categories`(title,description) VALUES(?,?)');
            $insert_category->execute([$title, $catdescription]);
            // $message[] = 'Category Added';
            $successMsg[] = 'Category Added';
        }
    }

} catch (Exception $e) {
    $errorMsg[] = $e->getMessage();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>


    <?php include '../components/admin_header.php' ?>

    <section class="add-category">

        <h1 class="heading">add category</h1>

        <div class="category-container">
            <form action="" method="POST" enctype="multipart/form-data" class="category-box">
                <p>category name <span>*</span></p>
                <input type="text" name="cat-title" maxlength="100" required placeholder="add category name"
                    class="box">
                <p>category description <span>*</span></p>
                <input type="text" name="cat-description" maxlength="100" required
                    placeholder="add category description" class="box">
                <div class="buttons">
                    <input type="submit" name="add" value="Add" class="btn">
                </div>
            </form>
        </div>
    </section>










    <!-- custom js file link  -->
    <script src="../js/admin_script.js"></script>

</body>

</html>