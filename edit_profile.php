<?php
require_once("includes/functions.php");
require_once("includes/db_cons.php");
session_start();
$errors = [];
$id = $_SESSION['user_id'];
$db = mysqli_connect($servername, $db_user, $db_password, $database);

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}
if (isset($_POST['edit_profile'])) {
    $name =  $_POST['name'];
    $contact =  $_POST['contact'];
    $email =  $_POST['email'];
    $sql = "UPDATE users SET name='$name', contact='$contact', email='$email' WHERE id='$id'";
    mysqli_query($db, $sql);
    header("Location: dashboard.php");
}
?>
<?php include_once('includes/header.php'); ?>
<section class="coloured-section" id="top-section">
    <?php include_once('includes/nav.php'); ?>
</section>
<section id="home-main-body">
    <?php include_once('includes/search_panel.php'); ?>
    <div class="container-fluid home-body">
        <h2 class="">Edit Profile</h2>
        <form method="POST" action="">
            <?php include('includes/errors.php'); ?>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Full Name" name="name" value="<?php echo $_SESSION['name'] ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Phone Number" name="contact" value="<?php echo $_SESSION['contact'] ?>">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo $_SESSION['email'] ?>">
            </div>

            <button type="submit" class="btn btn-primary" name="edit_profile" onclick='return editprofile()'><i class="fas fa-user"></i> Edit Profile</button>

        </form>

    </div>
</section>
<script>
    function editprofile() {

        var del = confirm("Are you sure you want to edit profile?");
        if (del == true) {
            alert("Profile edited")
        } else {
            alert("Profile not edited")
        }
        return del;
    }
</script>
<?php include_once('includes/footer.php'); ?>