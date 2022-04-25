<?php
require_once("includes/functions.php");
require_once("includes/db_cons.php");
session_start();
?>
<?php include("includes/header.php") ?>
<section class="coloured-section" id="top-section">
	<?php include_once('includes/nav.php'); ?>
</section>

</section>
<section id="success-section">
	<div class="registration-success">

		<p>Registration successful please<a href="login.php"> <i class="fas fa-sign-in-alt"></i> Login</a> to continue</p>

	</div>
</section>
<?php include("includes/footer.php") ?>