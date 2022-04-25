<?php
require_once("includes/functions.php");
require_once("includes/db_cons.php");
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}
$id = $_SESSION['user_id'];
$db = mysqli_connect($servername, $db_user, $db_password, $database);
$query = "SELECT * FROM users WHERE id='$id'";
$results = mysqli_query($db, $query);
if (mysqli_num_rows($results) == 1) {
    $user = mysqli_fetch_array($results);
    $fullname = $user['name'];
}

?>
<?php include_once('includes/header.php'); ?>
<section class="coloured-section" id="top-section">
    <?php include_once('includes/nav.php'); ?>
</section>
<section id="home-main-body">
    <?php include_once('includes/search_panel.php'); ?>
    <div class="container-fluid home-body">
        <div class="row home-body">
            <div class="col-lg-2 col-md-3 col-sm-3 dashboard-left">

                <nav class="navbar navbar-expand-lg navbar-dark">

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse dashboard-name" id="navbarTogglerDemo03">

                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#"><?php echo $fullname; ?></a>
                                <hr>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">My Propsals</a>
                                <hr>
                            </li>
                            <li class="nav-item">
                            <li class='nav-item dropdown'>
                                <a class='nav-link dropdown-toggle' href='#' id='navbarScrollingDropdown' role='button' data-toggle='dropdown' aria-expanded='false'>
                                    <i class="fas fa-user"></i> Account
                                </a>
                                <hr>
                                <ul class='dropdown-menu' aria-labelledby='navbarScrollingDropdown'>
                                    <li><a class='dropdown-item' href='edit_profile.php'>Edit Profile</a></li>
                                    <li><a class='dropdown-item' href='home.php?logout=' 1''>Logout</a></li>
                                    <li>
                                        <hr class='dropdown-divider'>
                                    </li>
                                </ul>
                            </li>
                            <hr>
                            </li>
                            <li class="nav-item">
                                <a class='nav-link' href='create_listing.php'><i class="fa fa-plus-square" aria-hidden="true"></i> Upload</a>
                                <hr>
                            </li>
                        </ul>

                    </div>
                </nav>
            </div>
            <div class="col-lg-10 col-md-9 col-sm-9 dashboard-right">
                <div class="col-lg-12">
                    <h2>My Proposals</h2>
                </div>
                <div class="row latest-uploads">
                    <?php
                    $db = mysqli_connect($servername, $db_user, $db_password, $database);
                    $username = $_SESSION['username'];
                    $query = "SELECT * FROM posts WHERE username='$username' ORDER BY id desc";
                    $results = mysqli_query($db, $query);
                    if (mysqli_num_rows($results) < 1) {
                        echo "<div class='col-lg-12'>
                                <p>No Business Plan uploaded yet!</p>
                                </div>	";
                    } else {
                        while ($row = $results->fetch_assoc()) {
                            $proposal_title = $row['proposal_title'];
                            $summary = $row['summary'];
                            $summary = nl2br($summary) . "\n";
                            $summary = substr($summary, 0, 100);
                            $post_date = $row['post_date'];
                            $id = $row['id'];

                            echo "
                        <div class='col-lg-3 col-md-4 col-sm-6 post-block mob-post-block'>
                        <div class='main-post-block'><p class='post-title'><a href='posts.php?id=$id'>$proposal_title</a></p>
                        <p class='small-text'> <i class='fa fa-calendar-o' aria-hidden='true'></i> $post_date</p>
                        <p class='post-summary'>$summary.....<a href='posts.php?id=$id'> View Detail</a> </p>
                        <p>
                        <div class='row'>
                        <div class='col-lg-6 col-md-6 col-sm-6 edit-button'>
                        <a href='edit_post.php?id=$id'><button type='button' class='btn btn-primary' >Edit</button></a>
                        </div>
                        <div class='col-lg-6 col-md-6 col-sm-6 delete-button'>
                        <form action='delete_post.php' method='POST'>
                        <input type='hidden' name='id' value='$id'>
                        <button type='submit' class='btn btn-primary' name='delete_post' onclick='return deleletconfig()'>Delete</button></form></p></div>
                        </div>
                    </div></div>
                        ";
                        }
                    }

                    ?>
                    <script>
                        function deleletconfig() {

                            var del = confirm("Are you sure you want to delete this record? This processis irreversible");
                            if (del == true) {
                                alert("record deleted")
                            } else {
                                alert("Record Not Deleted")
                            }
                            return del;
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once('includes/footer.php'); ?>