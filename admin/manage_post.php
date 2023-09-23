<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_POST['delete'])) {

    $p_id = $_POST['post_id'];
    $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);
    $delete_image = $conn->prepare("SELECT * FROM `posts` WHERE id = ?");
    $delete_image->execute([$p_id]);
    $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
    if ($fetch_delete_image['image'] != '') {
        unlink('../uploaded_img/' . $fetch_delete_image['image']);
    }
    $delete_post = $conn->prepare("DELETE FROM `posts` WHERE id = ?");
    $delete_post->execute([$p_id]);
    $successMsg[] = 'post deleted successfully!';

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Posts</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

    <?php include '../components/admin_header.php' ?>

    <section class="show-posts">

        <h1 class="heading">Manage posts</h1>

        <div class="table-container">
            <table width=100%>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE admin_id = ?");
                    $select_posts->execute([$admin_id]);
                    if ($select_posts->rowCount() > 0) {
                        while ($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)) {
                            $post_id = $fetch_posts['id'];
                            ?>
                            <form method="post" class="box">
                                <input type="hidden" name="post_id" value="<?= $post_id; ?>">
                                <tr>
                                    <td>
                                        <?= $fetch_posts['id']; ?>
                                    </td>
                                    <td>
                                        <?php if ($fetch_posts['image'] != '') { ?>
                                            <img src="../uploaded_img/<?= $fetch_posts['image']; ?>" class="table-image" alt="">
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?= $fetch_posts['title']; ?>
                                    </td>
                                    <td>
                                        <?= $fetch_posts['category']; ?>
                                    </td>
                                    <td>
                                        <a href="edit_post.php?id=<?= $post_id; ?>" class="post-btn post-edit"><i
                                                class="fas fa-pen"></i></a>
                                    </td>
                                    <td>
                                        <button type="submit" name="delete" class="post-btn post-delete"
                                            onclick="return confirm('delete this post?');"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>

                                <!-- <a href="read_post.php?post_id=<?= $post_id; ?>" class="btn">view post</a> -->
                            </form>


                            <?php
                        }
                    } else {
                        echo '<p class="empty">no posts added yet! <a href="add_posts.php" class="btn" style="margin-top:1.5rem;">add post</a></p>';
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