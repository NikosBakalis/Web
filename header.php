<?php

  session_start();

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="header">
      <div class="image_earth"></div>
      <div class="login_logout">
        <?php
          if (isset($_SESSION['userID'])) { //This one right here checks if we have a session with a user and fetches the appropriate message.
            echo '<a href="includes/logout.inc.php">Logout</a>';
          } else {
            echo '<a href="login.php">Login/Signup</a>';
          }
        ?>
      </div>
      <div class="inner_header">
        <div class="logo_container">
          <h1><span>MY</span>CROWDSOURCING<span>.</span>COM</h1>
        </div>
        <ul class="navigation">
          <?php
            if (isset($_SESSION['userID']) && $_SESSION['type'] == 'admin') {
              echo '<a href="admin.php" name="admin"><li>Admin</li></a>';
              // echo '<a href="dashboard.php"><li>Dashboard</li></a>';
            }
          ?>
          <a href="index.php" name="index"><li>Home</li></a>
          <?php
            if (isset($_SESSION['userID'])) {
              echo '<a href="dashboard.php"><li>Dashboard</li></a>';
            }
          ?>
          <!-- <a href="dashboard.php"><li>Dashboard</li></a> -->
          <a href="#"><li>About us</li></a>
          <a href="services.php"><li>Services</li></a>
          <a href="#"><li>Profile</li></a>
        </ul>
      </div>
    </div>
  </body>
</html>
