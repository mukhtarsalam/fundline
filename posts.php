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
            <div class="col-lg-9 latest-post-section">
                <?php
                $id = $_GET['id'];
                $db = mysqli_connect($servername, $db_user, $db_password, $database);
                $query = "SELECT * FROM posts WHERE id=$id";
                $results = mysqli_query($db, $query);
                $post = mysqli_fetch_array($results);
                $id = $post['id'];
                $username = $post['username'];
                $name = $post['name'];
                $email = $post['email'];
                $contact = $post['contact'];
                $proposal_title = $post['proposal_title'];
                $categories = $post['categories'];
                $experience = $post['experience'];
                $summary = $post['summary'];
                $post_date = $post['post_date'];
                $filename = $post['filename'];
                $cat_id = $post['cat_id'];
                $download_type = $post['download_type'];
                if ($download_type === "Yes") {
                    $download = "<a href='downloads.php?id= $id' target=_blank class='shift-left'><button type='button' class='btn btn-primary btn-sm'>Download Proposal File</button></a>";
                } else {
                    $download = " ";
                }
                $summary = nl2br($summary) . "\n";
                ?>
                <h3 class="main-post-title"> <?php echo $proposal_title; ?></h3>
                <h6 class="shift-left small-text">POSTED ON: <?php echo $post_date; ?></h6>
                <p class="just"><?php echo $summary; ?></p>
                <p class="shift-left"><button type="button" class="btn btn-primary btn-sm">Combined Years of Experience</button> <strong><?php echo $experience; ?> Years</strong></p>
                <p class="shift-left"><a href="mailto:<?php echo $email; ?>"><button type="button" class="btn btn-primary btn-sm">Contact Author</button></a> <?php echo $download ?></p>

            </div>
            <div class="col-lg-3 category-section">
                <h3>Related Ideas</h3>
                <?php

                $db = mysqli_connect($servername, $db_user, $db_password, $database);
                $sql = mysqli_query($db, "SELECT * FROM posts WHERE categories='$categories' LIMIT 6");
                while ($row = $sql->fetch_assoc()) {
                    $proposal_title = $row['proposal_title'];
                    $id = $row['id'];
                    echo "<p class='shift-left'><a href='posts.php?id=$id'>$proposal_title</a></p>";
                }
                ?>
            </div>
        </div>

    </div>
    </div>
</section>
<?php include_once('includes/footer.php'); ?>