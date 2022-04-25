<?php require_once("includes/functions.php");
require_once("includes/db_cons.php");
session_start();
$errors = array();
if ((logged_in() == true)) {
  redirect_to("home.php");
}
?>
<?php include_once('includes/header.php'); ?>
<section class="coloured-section" id="top-section">
  <div class="container-fluid">
    <?php include_once('includes/nav.php'); ?>
    <div class="row top-section">
      <div class="col-lg-7">
        <h1 class="big-heading">Do you have amazing business ideas and in need of funding?</h1>
        <h1 class="big-heading">Sign up today, upload your business idea and be a step closer to meeting potential
          investors!! </h1>
        <div class="down-button">
          <a href="login.php"> <button type="button" class="btn btn-dark btn-lg download-button"> <i class="fas fa-sign-in-alt"></i> Login</button></a>
          <a href="registration.php"><button type="button" class="btn btn-outline-light btn-lg download-button"><i class="fas fa-user"></i> Sign Up</button></a>
          <a href="home.php"> <button type="button" class="btn btn-primary btn-lg download-button"><i class="fa fa-file" aria-hidden="true"></i> Business
              Ideas</button></a>
        </div>
      </div>

      <div class="col-lg-5 col-md-7 col-sm-7 top-section-img">
        <img class="title-image" src="images/peakvest.png" alt="peakvest-mockup">
      </div>
    </div>
  </div>
</section>
<!-- Features -->

<section class="white-section" id="features">

  <div class="container-fluid">

    <div class="row">
      <div class="feature-box col-lg-4">
        <i class="icon fas fa-check-circle fa-4x"></i>
        <h3 class="feature-title">Easy to use.</h3>
        <p>So easy to use, takes a minute to get it.</p>
      </div>

      <div class="feature-box col-lg-4">
        <i class="icon fas fa-suitcase fa-4x"></i>
        <h3 class="feature-title">Elite Clientele</h3>
        <p>Elite entreprenures, amazing investors</p>
      </div>

      <div class="feature-box col-lg-4">
        <i class="icon fas fa-globe fa-4x"></i>
        <h3 class="feature-title">World Wide Connections</h3>
        <p>Get investors locally and Internationally.</p>
      </div>
    </div>


  </div>
</section>

<!-- Testimonials -->

<!-- <section class="coloured-section" id="testimonials">

  <div id="testimonial-carousel" class="carousel slide" data-ride="false">
    <div class="carousel-inner">
      <div class="carousel-item active container-fluid">
        <h2 class="testimonial-text">My business plan became a reality after signing up on WeCon.</h2>
        <img class="testimonial-image" src="images/dog-img.jpg" alt="dog-profile">
        <em>Abba, Kaduna</em>
      </div>
      <div class="carousel-item container-fluid">
        <h2 class="testimonial-text">It's amazing how Wecon has helped in making my dreams come true. Amazing platform
          for future entreprenures and investors</h2>
        <img class="testimonial-image" src="images/lady-img.jpg" alt="lady-profile">
        <em>Gbenga, Lagos</em>
      </div>
    </div>
    <a class="carousel-control-prev" href="#testimonial-carousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#testimonial-carousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon"></span>
    </a>
  </div>

</section> -->
<?php include_once('includes/footer.php'); ?>