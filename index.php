<?php
include("password.php");
include("helper.php");
$title = "Reportify Installer";

if (isset($_POST["password"])) {

  if ($_POST["password"] == $password) {
    ob_start();

    install();
    ?>
    <div class="">
      Install success.
    </div>
    <form action="" method="post">
      <div class="form-group" style="display:none;">
        <label for="pwd">Password:</label>
        <input type="password" class="form-control" placeholder="Enter password" id="pwd" name="password" value="<?php echo $_POST["password"] ?>">
      </div>
      <button type="submit" class="btn btn-primary">Rerun</button>
    </form>

    <?php

    $result = ob_get_contents();

    ob_end_clean();
  } else {
    ob_start();

    ?>
    <div class="">
      Failed to login.
    </div>
    <?php

    $result = ob_get_contents();

    ob_end_clean();

  }
} else {
  ob_start();

  ?>

  <form action="" method="post">
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" placeholder="Enter password" id="pwd" name="password">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  <?php

  $result = ob_get_contents();

  ob_end_clean();
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
