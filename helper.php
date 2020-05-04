<?php
function install($home_dir_path, $connect_to_db){

  // run_command("rm -rf *"),
  // run_command("ls -la .."),
  // cp -a FlexFile-3/public/. public_html/
  // ln -s /usr/www/users/bluegpyuty  public_html

  $result = array();

  // --------

  $FindDir = shell_find_dir($home_dir_path,"home");
  if ( $FindDir[1] !== "Success") { return $result; }
  array_push($result,$FindDir);

  // --------

  $download_app = shell_write(
    $home_dir_path,
    "rm -rf 'FlexFile-3'",
    "Clear space for the app"
  );
  array_push($result,$download_app);

  // --------

  $download_app = shell_write(
    $home_dir_path,
    "git clone https://github.com/ivan006/FlexFile-3",
    "Download app"
  );
  array_push($result,$download_app);

  // --------

  $app_path = $home_dir_path."/FlexFile-3";
  $FindDir = shell_find_dir($home_dir_path."/FlexFile-3","app");
  if ( $FindDir[1] !== "Success") { return $result; }
  array_push($result,$FindDir);

  // --------

  $download_app = shell_write(
    $app_path,
    "composer install",
    "Download libraries"
  );
  array_push($result,$download_app);

  // --------

  $webroot_path = $home_dir_path."/public_html";
  $FindDir = shell_find_dir($webroot_path,"webroot");
  if ( $FindDir[1] !== "Success") { return $result; }
  array_push($result,$FindDir);

  // --------

  $download_app = shell_write(
    $webroot_path,
    "cp -a $app_path/public/* ./",
    "Deploy webroot files"
  );
  array_push($result,$download_app);

  // --------

  // $webroot_path = $home_dir_path."/public_html";
  // $FindDir = shell_find_dir($webroot_path,"webroot");
  // if ( $FindDir[1] !== "Success") { return $result; }
  // array_push($result,$FindDir);

  // --------

  $auto_loader_string_old = "__DIR__.'/..";
  $auto_loader_string_new = "'$app_path";
  $file = '../index.php';
  file_put_contents($file,str_replace($auto_loader_string_old,$auto_loader_string_new,file_get_contents($file)));
  array_push($result,array(
    "Fix paths",
    "Success"
  ));

  // --------

  $download_app = shell_write(
    $app_path,
    "cp .env.example .env",
    "Deploy .env"
  );
  array_push($result,$download_app);

  // --------

  $string_old_1 = "connect_to_db_name";
  $string_new_1 = $connect_to_db["name"];
  $string_old_2 = "connect_to_db_user";
  $string_new_2 = $connect_to_db["user"];
  $string_old_3 = "connect_to_db_password";
  $string_new_3 = $connect_to_db["password"];
  $download_app = shell_write(
    $app_path,
    "sed -i 's/$string_old_1/$string_new_1/g' .env;
    sed -i 's/$string_old_2/$string_new_2/g' .env;
    sed -i 's/$string_old_3/$string_new_3/g' .env",
    "Save DB logins"
  );
  array_push($result,$download_app);

  // --------

  $download_app = shell_write(
    $app_path,
    "php artisan key:generate",
    "Generate key"
  );
  array_push($result,$download_app);

  $html = status_html($result);

  return $html;
}

function status_html($elements) {
  ob_start();
  ?>
  <style media="screen">
    /* .td_Wi_50Per td {width: 50%;} */
    .Wi_100Per {width: 100%}
    .td_VA_To td {vertical-align: top;}
    .TaLa_Fix {table-layout: fixed;}

  </style>
  <table class="table table-striped td_VA_To TaLa_Fix Wi_100Per">
  <?php
  foreach ($elements as $key => $element) {
    // code...
    ?>
    <tr>
      <td>
        <?php echo $key+1 .". ".$element[0] ?>:
      </td>
      <td>
        <?php echo $element[1] ?>
      </td>
    </tr>
    <?php
  }

  ?>
  </table>
  <?php

  $result = ob_get_contents();

  ob_end_clean();
  return $result;
}

function shell_find_dir($dir,$label){
  $result = array(
    "Find $label dir",
  );
  $shell_result = rtrim(shell_exec("cd $dir; pwd"));
  if ($shell_result !== $dir) {
    array_push($result,"Fail");
  } else {
    array_push($result,"Success");
  }
  return $result;
}

function shell_write($dir,$cmd,$label){
  $result = array(
    $label,
  );

  exec(
    "cd $dir;
    $cmd 2>&1"
    , $outputs
  );

  $result = array(
    $label,
    "<pre>".json_encode($outputs,JSON_PRETTY_PRINT)."</pre>",
  );
  return $result;
}
?>
