<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_POST['delete'])) {

    $c_id = $_POST['catid'];
    $delete_cat = $conn->prepare("DELETE FROM `categories` WHERE id = ?");
    $delete_cat->execute([$c_id]);
    $successMsg[] = 'Category Deleted Successfully!';

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Category</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

    <?php include '../components/admin_header.php' ?>

    <section class="show-posts">

        <h1 class="heading">Manage Category</h1>

        <div class="table-container">
            <table width=100%>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $select_category = $conn->prepare("SELECT * FROM `categories`");
                    $select_category->execute();
                    if ($select_category->rowCount() > 0) {
                        while ($fetch_category = $select_category->fetch(PDO::FETCH_ASSOC)) {
                            $cat_id = $fetch_category['id'];
                            ?>
                            <form method="post" class="box">
                                <input type="hidden" name="catid" value="<?= $cat_id; ?>">
                                <tr>
                                    <td>
                                        <?= $fetch_category['id']; ?>
                                    </td>
                                    <td>
                                        <?= $fetch_category['title']; ?>
                                    </td>
                                    <td>
                                        <?= $fetch_category['description']; ?>
                                    </td>
                                    <td>
                                        <a href="update_category.php?id=<?= $cat_id; ?>" class="post-btn post-edit"><i
                                                class="fas fa-pen"></i></a>
                                    </td>
                                    <td>
                                        <button type="submit" name="delete" class="post-btn post-delete"
                                            onclick="return confirm('delete this category?');"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>

                                <!-- <a href="read_post.php?post_id=<?= $post_id; ?>" class="btn">view post</a> -->
                            </form>


                            <?php
                        }
                    } else {
                        echo '<p class="empty">no category added yet! <a href="add_category.php" class="btn" style="margin-top:1.5rem;">Add Category</a></p>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>









    <!-- custom js file link  -->
    <script src="../js/admin_script.js"></script>

</body>

</html>