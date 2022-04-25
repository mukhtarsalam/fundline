<?php
include('app_logic.php');
if ((logged_in() == true)) {
    redirect_to("dashboard.php");
}
?>
<?php include_once('includes/header.php'); ?>
<section class="coloured-section" id="top-section">
    <?php include_once('includes/nav.php'); ?>
    <div class="row">
        <div class="col-lg-5 col-md-4 col-sm-2 my-form-img"><img class="form-img" src="images/peakvest.png"></div>
        <div class="col-lg-5 col-md-8 col-sm-10 my-form">
            <h2 class="form-header">Login</h2>
            <p class="error">Only logged in users can upload business ideas! <br> Please login to continue </p>
            <form method="POST" action="">
                <?php include('includes/errors.php'); ?>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Email/Phone Number" name="username">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember">
                    <label class="form-check-label" for="exampleCheck1">Remember me</label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg" name="login_user"><i class="fas fa-sign-in-alt"></i> Login</button>

            </form>
            <p class="form-link"><a href="forgot_password.php" class="form-link"> Forgot Password?</a></p>
            <p class="form-link">Not a member? <a href="registration.php" class="form-link"> <i class="fas fa-user"></i> Join Us</a></p>
        </div>
    </div>

</section>
<?php include_once('includes/footer.php'); ?>