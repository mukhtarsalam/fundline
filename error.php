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

		<p>Failed to register please <a href="registration.php"> <i class="fa fa-refresh"></i> retry</a></p>

	</div>
</section>
<?php include("includes/footer.php") ?>