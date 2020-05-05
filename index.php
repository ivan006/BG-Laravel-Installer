<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("password.php");
include("helper.php");
$title = "Startupify Installer - A online admin system for startups";



if (1==1) {
  ob_start();

  if (isset($_POST["password"])) {
    $password_value = $_POST["password"];
  } else {
    $password_value = "";
  }

  if (isset($_POST["home_dir_path"])) {
    $home_dir_path = $_POST["home_dir_path"];
  } else {
    $home_dir_path = "";
  }

  if (isset($_POST["connect_to_db_name"])) {
    $connect_to_db["name"] = $_POST["connect_to_db_name"];
  } else {
    $connect_to_db["name"] = "";
  }

  if (isset($_POST["connect_to_db_user"])) {
    $connect_to_db["user"] = $_POST["connect_to_db_user"];
  } else {
    $connect_to_db["user"] = "";
  }

  if (isset($_POST["connect_to_db_password"])) {
    $connect_to_db["password"] = $_POST["connect_to_db_password"];
  } else {
    $connect_to_db["password"] = "";
  }

  if (isset($_POST["connect_to_db_host"])) {
    $connect_to_db["host"] = $_POST["connect_to_db_host"];
  } else {
    $connect_to_db["host"] = "";
  }

  $step = 1;
  $step_value = 1;
  if (isset($_POST["step"])) {
    $step = $_POST["step"];
    if ($step == 1) {
      $step_value = 2;
    } elseif ($step >= 2) {
      $step_value = 3;
    }
  }

  ?>

  <form action="" method="post">
    <div class="form-group">
      <label for="pwd">
        <b>
          Login
        </b>
      </label>

      <input type="password" class="form-control" placeholder="Enter password" id="pwd" name="password" value="<?php echo $password_value ?>">
    </div>
    <div class="form-group">
      <label>
        <b>
          <!-- Resolve Home Directory Confusion -->
          Find home directory
        </b>
      </label>
      <input type="text" class="form-control" placeholder="E.g. /usr/home/bluegpyuty" name="home_dir_path" value="<?php echo $home_dir_path ?>">
    </div>
    <div class="form-group">
      <label>
        <b>
          <!-- Resolve Home Directory Confusion -->
          Connect to DB
        </b>
      </label>
      <input type="text" class="form-control" placeholder="Host (e.g. sql31.jnb1.host-h.net)" name="connect_to_db_host" value="<?php echo $connect_to_db["host"] ?>">
      <input type="text" class="form-control" placeholder="Name" name="connect_to_db_name" value="<?php echo $connect_to_db["name"] ?>">
      <input type="text" class="form-control" placeholder="User" name="connect_to_db_user" value="<?php echo $connect_to_db["user"] ?>">
      <input type="text" class="form-control" placeholder="Password" name="connect_to_db_password" value="<?php echo $connect_to_db["password"] ?>">
    </div>
    <div class="form-group">
      <label>
        <b>
          Step
        </b>
      </label>
      <p>Run all steps please, in order.</p>
      <input type="number" id="" name="step" min="1" max="3" value="<?php echo $step_value ?>">
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Submit</button>


  </form>
  <br>
  <br>

  <?php

  $form = ob_get_contents();

  ob_end_clean();
  // code...
}


$result = "";
if (isset($_POST["password"])) {
  if ($_POST["password"] == $password) {
    $step = $_POST["step"];
    $install = install($home_dir_path,$connect_to_db,$step);
    $result = $install;
  } else {
    $result = "Failed to login.";
  }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title><?php echo $title ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  </head>
  <body>
    <br>
    <div class="container">

      <h3><?php echo $title ?></h3>
      <?php echo $form ?>
      <details>
        <summary>
          Status
        </summary>
        <?php echo $result; ?>
      </details>
    </div>
  </body>
</html>
