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
  ?>
  <div class="form-group">

        <label for="pwd">
          <b>
            Password:
          </b>
        </label>

      <input type="password" class="form-control" placeholder="Enter password" id="pwd" name="password" value="<?php echo $password_value ?>">


  </div>
  <br>
  <?php

  $form_hidable_content = ob_get_contents();

  ob_end_clean();
  // code...
}

if (1==1) {
  ob_start();

  if (isset($_POST["home_dir_path"])) {
    $home_dir_path = $_POST["home_dir_path"];
  } else {
    $home_dir_path = "";
  }
  ?>
  <div class="form-group">
    <label>
      <b>
        Resolve Home Directory Confusion
      </b>
    </label>
    <details>
      <summary>
        Help
      </summary>
      <ul>
        <li>
          As a security measure servers use a complicated file paths system.
        </li>
        <li>
          Because your webroot directory is quite vulnerable you are also provided with a home directory.
        </li>
        <li>
          A shortcut to your webroot is available in your home directory for your convenience.
        </li>
      </ul>
      <pre>
        .
        ├─ /usr/home/[username]       <-("home directory")
        | ├─ public_html              <-(link to "webroot directory")
        | └─ www_logs
        └─ /usr/www/users/[username]  <-("webroot directory")
      </pre>
      <ul>
        <li>
          However unfortunately this complication is not just an obstacle for hackers but is also confusing for us.
        </li>
        <li>
          Please help us resolve our confusing by adding your home directory path.
        </li>
      </ul>



    </details>
    <input type="text" class="form-control" placeholder="E.g. /usr/home/bluegpyuty" name="home_dir_path" value="<?php echo $home_dir_path ?>">
  </div>

  <?php

  $form_nonhidable_content = ob_get_contents();

  ob_end_clean();
  // code...
}

if (isset($_POST["password"])) {

  if ($_POST["password"] == $password) {
    ob_start();

    ?>
    <div class="">
      Install success.
    </div>

    <form action="" method="post">
      <div style="display:none;">
        <?php echo $form_hidable_content ?>
      </div>
      <?php echo $form_nonhidable_content ?>
      <button type="submit" class="btn btn-primary">Run</button>
    </form>
    <br>
    <br>
    <?php
    install($home_dir_path);

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
    <?php echo $form_hidable_content ?>
    <?php echo $form_nonhidable_content ?>
    <button type="submit" class="btn btn-primary">Run</button>
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
