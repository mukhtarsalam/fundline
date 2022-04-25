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
                <?php include('includes/errors.php'); ?>
                <div class="form-group">
                    <input type="email" class="form-control form-control-lg" id="proposal-title" placeholder="Enter your email" name="email">
                </div>
                <button class="btn btn-primary btn-sm" type="submit" name="reset-password">Recover Password</button>
            </form>
        </div>
    </div>
</section>
<?php include_once('includes/footer.php'); ?>