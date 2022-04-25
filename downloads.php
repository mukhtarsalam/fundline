<?php
require_once("includes/db_cons.php");
session_start();
$db = mysqli_connect($servername, $db_user, $db_password, $database);
// Downloads files
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // fetch file to download from database
    $sql = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($db, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'uploads/' . $file['filename'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('uploads/' . $file['filename']));
        readfile('uploads/' . $file['filename']);

        // Now update downloads count
    }

}
?>
