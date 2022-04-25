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
            <form method="post" action="new_pass.php">
                <?php include('includes/errors.php'); ?>
                <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="proposal-title" placeholder="Enter new password" name="new_pass">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="proposal-title" placeholder="Confirm new password" name="new_pass_c">
                </div>
                <button class="btn btn-primary btn-sm" type="submit" name="new_password">Recover Password</button>
            </form>
        </div>
    </div>
</section>
<?php include_once('includes/footer.php'); ?>