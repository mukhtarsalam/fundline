<?php
include('app_logic.php');
if ((logged_in() == true)) {
    redirect_to("login.php");
}
?>
<?php include_once('includes/header.php'); ?> <section class="coloured-section" id="top-section">
    <?php include_once('includes/nav.php'); ?>
    <div class="row">
        <div class="col-lg-5 col-md-4 col-sm-2 my-form-img"><img class="form-img" src="images/peakvest.png"></div>
        <div class="col-lg-5 col-md-8 col-sm-10 my-form">
            <h2 class="form-header">Sign Up</h2>
            <p class="sign-up-note"><strong>Welcome! Please note that you will be charged a one-time registration fee of ₦2000 to complete your registration.</strong></p>
            <form method="POST" action="">
                <?php include('includes/errors.php'); ?>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Full Name" name="name">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Phone Number" name="contact">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" name="username">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" name="email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password1" placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password2" placeholder="Confirm Password">
                </div>

                <p class="sign-up-note">By Clicking Sign Up, you agree to our <a href="terms.php" class="service-link"> Terms of Service</a></p>
                <button type="submit" class="btn btn-primary btn-lg" name="register"><i class="fas fa-user"></i> Sign Up</button>

            </form>
            <p class="form-link">One of us? <a href="login.php" class="form-link"> <i class="fas fa-sign-in-alt"></i> Login</a></p>
        </div>
    </div>

</section>
<?php include_once('includes/footer.php'); ?>