
<?php
include('includes/db_cons.php');
if (isset($_POST['delete_post'])) {
    $id = $_POST['id'];
    $db = mysqli_connect($servername, $db_user, $db_password, $database);
    $query = "DELETE FROM posts WHERE id='$id'";
    if (mysqli_query($db, $query)) {
        header('Location: dashboard.php');
    } else {
        echo "error deleting post";
        mysqli_error($db);
    }
}
