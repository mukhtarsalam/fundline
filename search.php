<?php require_once("includes/functions.php");
require_once("includes/db_cons.php");
session_start();
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
                    <h2>Search Result</h2>
                </div>
                <div class="row latest-uploads">
                    <?php
                    if (isset($_POST['search_submit'])) {
                        $search = $_POST['search'];
                        $search = htmlspecialchars($search);
                        $db = mysqli_connect($servername, $db_user, $db_password, $database);
                        $query = "SELECT * FROM posts WHERE (`categories` LIKE '%" . $search . "%') OR (`proposal_title` LIKE '%" . $search . "%') OR (`experience` LIKE '%" . $search . "%') OR (`summary` LIKE '%" . $search . "%') OR (`post_date` LIKE '%" . $search . "%') OR (`filename` LIKE '%" . $search . "%')";
                        $results = mysqli_query($db, $query);
                        if (mysqli_num_rows($results) < 1) {
                            echo "<div class='col-lg-12'>
                                <p>No result found for " . '"' . $search . '"' . "</p>
                                <p>Please try another search term</p>
                                </div>	";
                        } else {
                            while ($row = $results->fetch_assoc()) {
                                $proposal_title = $row['proposal_title'];
                                $summary = $row['summary'];
                                $summary = nl2br($summary) . "\n";
                                $summary = substr($summary, 0, 50);
                                $id = $row['id'];
                                $post_date = $row['post_date'];
                                echo "
                        <div class='col-lg-3 col-md-4 col-sm-6 post-block mob-post-block'>
                        <div class='main-post-block'><p class='post-title'><a href='posts.php?id=$id'>$proposal_title</a></p>
                        <p class='small-text'> <i class='fa fa-calendar-o' aria-hidden='true'></i> $post_date</p>
                        <p class='post-summary'>$summary.....<a href='posts.php?id=$id'> View Detail</a> </p>
                    </div></div>
                        ";
                            }
                        }
                    }

                    ?>

                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once('includes/footer.php'); ?>