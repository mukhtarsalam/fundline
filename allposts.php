<?php
require_once("includes/functions.php");
require_once("includes/db_cons.php");
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
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

            <div class="col-lg-12 latest-post-section">

                <div class="col-lg-12">
                    <h2>All Uploads</h2>
                </div>
                <div class="row latest-uploads">
                    <?php
                    $db = mysqli_connect($servername, $db_user, $db_password, $database);
                    $query = "SELECT * FROM posts ORDER BY id desc";
                    $results = mysqli_query($db, $query);
                    if (mysqli_num_rows($results) < 1) {
                        echo "<div class='col-lg-12'>
                                <p>No Business Plan uploaded yet!</p>
                                <p>Be the first to uplaod a business plan, click <a href='create_listing.php'>here</a> to upload a business plan</p>
                                </div>	";
                    } else {
                        while ($row = $results->fetch_assoc()) {
                            $proposal_title = $row['proposal_title'];
                            $summary = $row['summary'];
                            $summary = nl2br($summary) . "\n";
                            $summary = substr($summary, 0, 50);
                            $post_date = $row['post_date'];
                            $id = $row['id'];
                            echo "
                        <div class='col-lg-3 col-md-4 col-sm-6 post-block mob-post-block'>
                        <div class='main-post-block'><p class='post-title'><a href='posts.php?id=$id'>$proposal_title</a></p>
                        <p class='small-text'> <i class='fa fa-calendar-o' aria-hidden='true'></i> $post_date</p>
                        <p class='post-summary'>$summary.....<a href='posts.php?id=$id'> View Detail</a> </p>
                    </div></div>
                        ";
                        }
                    }

                    ?>

                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once('includes/footer.php'); ?>