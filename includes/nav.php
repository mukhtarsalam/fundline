<?php
if ((logged_in() == true)) {
    $login_logout = "<li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle' href='#' id='navbarScrollingDropdown' role='button' data-toggle='dropdown' aria-expanded='false'>
          Settings
        </a>
        <ul class='dropdown-menu' aria-labelledby='navbarScrollingDropdown'>
          <li><a class='dropdown-item' href='dashboard.php'>Dashboard</a></li>
          <li><a class='dropdown-item' href='home.php?logout='1''>Logout</a></li>
          <li><hr class='dropdown-divider'></li>
        </ul>
      </li>";
    // $login_logout = "<a class='nav-link' href='home.php?logout='1''>Logout</a>";
} else {
    $login_logout =  "<a class='nav-link' href='login.php'>Login</a>";
}
?>
<nav class="navbar navbar-expand-lg navbar-dark">

    <a class="navbar-brand" href="index.php">Fundline<sup><i class="fas fa-check-circle "></i></sup></a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="home.php">Business Ideas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="mailto:mukhtarpeace@gmail.com">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php">About Us</a>
            </li>
            <li class="nav-item">
                <?php echo $login_logout; ?>
            </li>
        </ul>

    </div>
</nav>