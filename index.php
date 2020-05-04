<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("password.php");
include("helper.php");
$title = "Reportify Installer";



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
  ?>

  <form action="" method="post">
    <div class="form-group">
      <label for="pwd">
        <b>
          Password:
        </b>
      </label>

      <input type="password" class="form-control" placeholder="Enter password" id="pwd" name="password" value="<?php echo $password_value ?>">
    </div>
    <div class="form-group">
      <label>
        <b>
          Resolve Home Directory Confusion
        </b>
      </label>
      <input type="text" class="form-control" placeholder="E.g. /usr/home/bluegpyuty" name="home_dir_path" value="<?php echo $home_dir_path ?>">
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


$result =  $form;
if (isset($_POST["password"])) {
  if ($_POST["password"] == $password) {
    $install = install($home_dir_path);
    $status = status_html($install);
    $result = $result.$status;
  } else {
    $result = $result."Failed to login.";
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
      <?php echo $result; ?>
    </div>
  </body>
</html>
