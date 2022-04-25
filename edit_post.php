<?php
require_once("includes/functions.php");
require_once("includes/db_cons.php");
session_start();
$errors = array();
$post_id = $_GET['id'];
$db = mysqli_connect($servername, $db_user, $db_password, $database);
$query = "SELECT * FROM posts WHERE id='$post_id'";
$results = mysqli_query($db, $query);
if (mysqli_num_rows($results) == 1) {
    $post = mysqli_fetch_array($results);
    $post_id = $post['id'];
    $post_proposal_title = $post['proposal_title'];
    $post_categories = $post['categories'];
    $post_experience = $post['experience'];
    $post_filename = $post['filename'];
    $post_summary = $post['summary'];
}
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: listing_login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}

// Uploads files
if (isset($_POST['save'])) { // if save button on the form is clicked
    // name of the uploaded file
    //receive all input value from
    if (isset($_POST['download_type'])) {
        $download_type = "Yes";
    } else {
        $download_type = "no";
    }

    $categories =  $_POST['categories'];
    $experience = $_POST['experience'];
    $summary =  $_POST['summary'];
    $filename = $_FILES['myfile']['name'];
    if ($categories == "Agriculture") {
        $cat_id = 1;
    } elseif ($categories == "Architecture and Construction") {
        $cat_id = 2;
    } elseif ($categories == "Arts") {
        $cat_id = 3;
    } elseif ($categories == "Audio and Video Technology") {
        $cat_id = 4;
    } elseif ($categories == "Business Administration") {
        $cat_id = 5;
    } elseif ($categories == "Business Management") {
        $cat_id = 6;
    } elseif ($categories == "Education") {
        $cat_id = 7;
    } elseif ($categories == "Engineering") {
        $cat_id = 8;
    } elseif ($categories == "Finance") {
        $cat_id = 9;
    } elseif ($categories == "Food and Natural Resources") {
        $cat_id = 10;
    } elseif ($categories == "Gaming and Sport Gambling") {
        $cat_id = 11;
    } elseif ($categories == "Health Science") {
        $cat_id = 12;
    } elseif ($categories == "Hospitality and Tourism") {
        $cat_id = 13;
    } elseif ($categories == "Human Services") {
        $cat_id = 14;
    } elseif ($categories == "Information Technology") {
        $cat_id = 15;
    } elseif ($categories == "Law and Legal Services") {
        $cat_id = 16;
    } elseif ($categories == "Manufacturing") {
        $cat_id = 17;
    } elseif ($categories == "Marketing and Advertising") {
        $cat_id = 18;
    } elseif ($categories == "Public Safety") {
        $cat_id = 19;
    } elseif ($categories == "Science and Technology") {
        $cat_id = 20;
    } elseif ($categories == "Transportation Distribution and Logistics") {
        $cat_id = 21;
    } else {
        $cat_id = 22;
    }
    // destination of the file on the server
    $destination = 'uploads/' . $filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];

    if (!in_array($extension, ['pdf', 'docx'])) {
        array_push($errors, "You file extension must be .pdf or .docx!");
    } elseif ($_FILES['myfile']['size'] > 5000000) { // file shouldn't be larger than 5Megabyte
        array_push($errors, "File too large! File cannot exceed 5MB");
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $sql = "UPDATE posts SET proposal_title='$proposal_title', categories='$categories', experience='$experience', summary='$summary', filename='$filename', cat_id='$cat_id', download_type='$download_type' WHERE id='$post_id'";
            mysqli_query($db, $sql);
            header("Location: dashboard.php");
        }
    }
}
?>
<?php include_once('includes/header.php'); ?>
<section class="coloured-section" id="top-section">
    <?php include_once('includes/nav.php'); ?>
</section>
<section id="home-main-body">
    <?php include_once('includes/search_panel.php'); ?>
    <div class="container-fluid home-body">
        <div class="listing-form">
            <h2>Edit Idea</h2>
            <form method="post" action="" enctype="multipart/form-data">
                <?php include('includes/errors.php'); ?>
                <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="proposal-title" placeholder="Proposal Title" name="proposal_title" value="<?php echo  $post_proposal_title; ?>">
                </div>
                <div class="form-group">
                    <select class="form-control form-control-sm" id="categories" name="categories">
                        <option value="<?php echo  $post_categories; ?>">Categories</option>
                        <?php
                        $db = mysqli_connect($servername, $db_user, $db_password, $database);
                        $sql = mysqli_query($db, "SELECT * FROM categories");
                        while ($row = $sql->fetch_assoc()) {
                            $slug = $row['slug'];
                            echo "<option value='$slug'>" . $row['description'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="proposal-title" placeholder="Years of Experience in figures only" name="experience" value="<?php echo  $post_experience; ?>">
                </div>
                <div class="form-group">
                    <textarea class="form-control form-control-sm" id="exampleFormControlTextarea1" rows="5" name="summary"> <?php echo  $post_summary; ?></textarea>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFile" name="myfile" value="<?php echo  $post_filename; ?>">
                    <label class="custom-file-label" for="customFile">Upload idea File (Summary)</label>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="download_type">
                    <label class="form-check-label" for="exampleCheck1">Make attached idea file downloadable</label>
                </div>
                <button class="btn btn-primary download-button" type="submit" name="save" onclick='return editpost()'>Update Proposal</button>
            </form>
        </div>
    </div>
</section>
<script>
    function editpost() {

        var del = confirm("Are you sure you want to update this upload?");
        if (del == true) {
            alert("Upload updated")
        } else {
            alert("Upload Not updated")
        }
        return del;
    }
</script>
<?php include_once('includes/footer.php'); ?>