<?php
require_once("includes/functions.php");
require_once("includes/db_cons.php");
session_start();
$errors = [];
$db = mysqli_connect($servername, $db_user, $db_password, $database);
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}
$id = $_GET['id'];
$query = "SELECT * FROM posts WHERE id='$id'";
$results = mysqli_query($db, $query);
$post = mysqli_fetch_array($results);
$user_email = $post['email'];

if (isset($_POST['contact_us'])) {
    $email = $user_email;
    $subject = mysqli_real_escape_string($db, $_POST['subject']);
    $emailfrom = mysqli_real_escape_string($db, $_POST['emailfrom']);
    $msg = mysqli_real_escape_string($db, $_POST['msg']);

    // Send email to user with the token in a link they can click on
    $to = $email;
    $subject = $subject;
    $msg = $msg;
    $msg = wordwrap($msg, 70);
    $headers = "From: $emailfrom";
    mail($to, $subject, $msg, $headers);
    header('location: post.php?id=$id');
}
?>
<?php include_once('includes/header.php'); ?>
<section class="coloured-section" id="top-section">
    <?php include_once('includes/nav.php'); ?>
</section>
<section id="home-main-body">
    <?php include_once('includes/search_panel.php'); ?>
    <div class="container-fluid home-body">
        <h2 class="">Contact Us</h2>
        <form method="POST" action="">
            <?php include('includes/errors.php'); ?>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="Emter Email Address" name="emailfrom">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Subject" name="subject">
            </div>
            <div class="form-group">
                <textarea class="form-control form-control-sm" id="exampleFormControlTextarea1" rows="8" name="msg"> Enter your message</textarea>
            </div>

            <button type="submit" class="btn btn-primary" name="contact_us" onclick="return sendmessage()"> Send Message</button>

        </form>

    </div>
</section>
<script>
    function sendmessage() {

        var del = confirm("Are you sure you want to send this message?");
        if (del == true) {
            alert("Message sent")
        } else {
            alert("Message not sent")
        }
        return del;
    }
</script>

<?php include_once('includes/footer.php'); ?>