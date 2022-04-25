<?php
require_once("includes/functions.php");
require_once("includes/db_cons.php");
session_start();
$errors = array();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: listing_login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}

$db = mysqli_connect($servername, $db_user, $db_password, $database);
$_SESSION['success'] = "";
// Uploads files
if (isset($_POST['save'])) { // if save button on the form is clicked
    // name of the uploaded file
    //receive all input value from
    if (isset($_POST['download_type'])) {
        $download_type = "Yes";
    } else {
        $download_type = "no";
    }
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $contact = mysqli_real_escape_string($db, $_POST['contact']);
    $proposal_title = mysqli_real_escape_string($db, $_POST['proposal_title']);
    $categories = mysqli_real_escape_string($db, $_POST['categories']);
    $experience = mysqli_real_escape_string($db, $_POST['experience']);
    $summary = mysqli_real_escape_string($db, $_POST['summary']);
    $post_date = date("d/m/Y");
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
    } elseif ($_FILES['myfile']['size'] > 5000000) { // file shouldn't be larger than 1Megabyte
        array_push($errors, "File too large! File cannot exceed 5MB");
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO posts (username, name, email, contact, proposal_title, categories, experience, summary, post_date, filename,cat_id,download_type) VALUES ('$username','$name','$email','$contact','$proposal_title','$categories','$experience','$summary',
						'$post_date','$filename','$cat_id','$download_type')";
            if (mysqli_query($db, $sql)) {
                echo "<p class='proposal-successful'>Propsal uploaded successfully</p>";
                redirect_to("dashboard.php");
            }
        } else {
            echo "<p class='proposal-failed'>Failed to upload proposal.</p>";
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
        <?php if (isset($_SESSION['email']) || isset($_SESSION['name']) || isset($_SESSION['contact']) || isset($_SESSION['username'])) : ?>
            <div class="listing-form">
                <h2>Create New Proposal</h2>
                <form method="post" action="create_listing.php" enctype="multipart/form-data">
                    <?php include('includes/errors.php'); ?>
                    <div class="form-group">
                        <input type="hidden" class="form-control form-control-lg" id="proposal-title" placeholder="Username" name="username" value="<?php echo  $_SESSION['username']; ?>">
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control form-control-lg" id="proposal-title" placeholder="Username" name="name" value="<?php echo  $_SESSION['name']; ?>">
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control form-control-lg" id="proposal-title" placeholder="Username" name="email" value="<?php echo  $_SESSION['email']; ?>">
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control form-control-lg" id="proposal-title" placeholder="Username" name="contact" value="<?php echo  $_SESSION['contact']; ?>">
                    <?php endif ?>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-lg" id="proposal-title" placeholder="Proposal Title" name="proposal_title" required>
                    </div>
                    <div class="form-group">
                        <select class="form-control form-control-sm" id="categories" name="categories">
                            <option value="">Categories</option>
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
                        <input type="text" class="form-control form-control-lg" id="proposal-title" placeholder="Years of Experience in figures only" name="experience" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control form-control-sm" id="exampleFormControlTextarea1" rows="5" name="summary" required> Proposal Summary</textarea>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" name="myfile">
                        <label class="custom-file-label" for="customFile">Upload Proposal File (Summary)</label>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="download_type">
                        <label class="form-check-label" for="exampleCheck1">Make attached proposal file downloadable</label>
                    </div>
                    <button class="btn btn-primary download-button btn-lg" type="submit" name="save">Submit Proposal</button>
                </form>
            </div>
    </div>
</section>
<?php include_once('includes/footer.php'); ?>