<?php include('app_logic.php'); ?>
<?php include_once('includes/header.php'); ?>
<section class="coloured-section" id="top-section">
    <?php include_once('includes/nav.php'); ?>
</section>
<section id="home-main-body">
    <?php include_once('includes/search_panel.php'); ?>
    <div class="container-fluid home-body">
        <div class="listing-form">
            <h2>Recover password</h2>
            <form method="post" action="forgot_password.php">
                <p>
                    We sent an email to <b><?php echo $_GET['email'] ?></b> to help you recover your account.
                </p>
                <p>Please login into your email account and click on the link we sent to reset your password</p>
            </form>
        </div>
    </div>
</section>
<?php include_once('includes/footer.php'); ?>