<?php
function install($home_path, $connect_to_db, $step){

  // run_command("rm -rf *"),
  // run_command("ls -la .."),
  // cp -a FlexFile-3/public/. public_html/
  // ln -s /usr/www/users/bluegpyuty  public_html

  $form = array(
    "connect_to_db" => $connect_to_db,
    "step" => $step,
  );

  $result = array();
  $dir = array(
    "app_path" => $home_path."/FlexFile-3",
    // /usr/home/bluegpyuty/FlexFile-3
    "webroot_path" => $home_path."/public_html",
    "home_path" => $home_path,
  );

  // download core assets
  if ($form["step"] == 1) {
    $result = cmd_find_dir_home($result,$dir,$form);
    $result = cmd_find_webroot($result,$dir,$form);
    // $result = cmd_depopulate_database($result,$dir,$form);
    $result = cmd_clear_space_for_the_app($result,$dir,$form);
    $result = cmd_download_app($result,$dir,$form);
    $result = cmd_find_app_path($result,$dir,$form);
    $result = cmd_deploy_webroot_files_part_1($result,$dir,$form);
    $result = cmd_deploy_webroot_files_part_2($result,$dir,$form);
    $result = cmd_fix_paths_part_1($result,$dir,$form);
    // $result = cmd_fix_paths_part_2($result,$dir,$form);
    $result = cmd_fix_file_permissions($result,$dir,$form);
    $result = cmd_deploy_env($result,$dir,$form);
    $result = cmd_save_db_logins($result,$dir,$form);
    $result = cmd_generate_key($result,$dir,$form);
  }

  // deploy perifery assets part 1 (libraries)
  if ($form["step"] == 2) {
    $result = cmd_find_app_path($result,$dir,$form);
    $result = cmd_download_libraries($result,$dir,$form);
  }

  // deploy perifery assets part 2 (db structure)
  if ($form["step"] == 3) {
    $result = cmd_find_app_path($result,$dir,$form);
    $result = cmd_populate_database($result,$dir,$form);
  }

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

function abort_install($error){
  header("Location: /Reportify_Installer/index.php?error=$error");
  exit();
}


function cmd_find_dir_home($result,$dir,$form){
  $cmd_result = shell_find_dir($dir['home_path'],"home");
  array_push($result,$cmd_result);
  if ( $cmd_result[1] == "Error") { abort_install(count($result)); }
  return $result;
}

function cmd_find_webroot($result,$dir,$form){
  $cmd_result = shell_find_dir($dir['webroot_path'],"webroot");
  array_push($result,$cmd_result);
  if ( $cmd_result[1] == "Error") { abort_install(count($result)); }
  return $result;
}

function cmd_depopulate_database($result,$dir,$form){

  $app_path = $dir['app_path'];
  // "php artisan migrate",
  $cmd_result = shell_write(
    $app_path,
    "php artisan migrate:reset",
    "Depopulate database"
  );
  array_push($result,$cmd_result);
  if ( $cmd_result[1] == "Error") { abort_install(count($result)); }
  return $result;
}

function cmd_clear_space_for_the_app($result,$dir,$form){
  $cmd_result = shell_write(
    $dir['home_path'],
    "rm -rf 'FlexFile-3'",
    "Clear space for the app"
  );
  array_push($result,$cmd_result);
  if ( $cmd_result[1] == "Error") { abort_install(count($result)); }
  return $result;
}

function cmd_download_app($result,$dir,$form){
  $cmd_result = shell_write(
    $dir['home_path'],
    "git clone https://github.com/ivan006/FlexFile-3",
    "Download app"
  );
  array_push($result,$cmd_result);
  if ( $cmd_result[1] == "Error") { abort_install(count($result)); }
  return $result;
}

function cmd_find_app_path($result,$dir,$form){

  $app_path = $dir['app_path'];
  $cmd_result = shell_find_dir($app_path,"app");
  array_push($result,$cmd_result);
  if ( $cmd_result[1] == "Error") { abort_install(count($result)); }
  return $result;
}

function cmd_deploy_webroot_files_part_1($result,$dir,$form){
  $app_path = $dir['app_path'];
  $cmd_result = shell_write(
    $dir['webroot_path'],
    "cp -a $app_path/public/* ./",
    "Deploy webroot files part 1"
  );
  array_push($result,$cmd_result);
  if ( $cmd_result[1] == "Error") { abort_install(count($result)); }
  return $result;

}

function cmd_deploy_webroot_files_part_2($result,$dir,$form){

  $app_path = $dir['app_path'];
  $cmd_result = shell_write(
    $dir['webroot_path'],
    "cp -r $app_path/public/.htaccess ./",
    "Deploy webroot files part 2"
  );
  array_push($result,$cmd_result);
  if ( $cmd_result[1] == "Error") { abort_install(count($result)); }
  return $result;

}

function cmd_fix_paths_part_1($result,$dir,$form){
  $app_path = $dir['app_path'];

  $auto_loader_string_old = "__DIR__.'/..";
  $auto_loader_string_new = "'$app_path";
  $file = '../index.php';
  file_put_contents($file,str_replace($auto_loader_string_old,$auto_loader_string_new,file_get_contents($file)));

  $cmd_result = array(
    "Fix paths part 1",
    "Success"
  );

  array_push($result,$cmd_result);
  if ( $cmd_result[1] == "Error") { abort_install(count($result)); }
  return $result;

}

function cmd_fix_paths_part_2($result,$dir,$form){

  $app_path = $dir['app_path'];
  $auto_loader_string_old = "__DIR__.'";
  $auto_loader_string_new = "'$app_path";
  $file = '../index.php';
  $cmd_result = shell_write(
    $app_path,
    "cp .env.example .env",
    "Fix paths part 2"
  );

  array_push($result,$cmd_result);
  if ( $cmd_result[1] == "Error") { abort_install(count($result)); }
  return $result;

}

function cmd_fix_file_permissions($result,$dir,$form){


  $app_path = $dir['app_path'];
  $cmd_result = shell_write(
  $app_path,
  "chown -R www-data:root $app_path;
  chmod 755 $app_path/storage",
  "Fix file permissions"
  );

  array_push($result,$cmd_result);
  if ( $cmd_result[1] == "Error") { abort_install(count($result)); }
  return $result;

}

function cmd_deploy_env($result,$dir,$form){

  $app_path = $dir['app_path'];
  $cmd_result = shell_write(
  $app_path,
  "cp .env.example .env",
  "Deploy .env"
  );

  array_push($result,$cmd_result);
  if ( $cmd_result[1] == "Error") { abort_install(count($result)); }
  return $result;

}

function cmd_save_db_logins($result,$dir,$form){

  $string_old_1 = "connect_to_db_name";
  $string_new_1 = $form["connect_to_db"]["name"];
  $string_old_2 = "connect_to_db_user";
  $string_new_2 = $form["connect_to_db"]["user"];
  $string_old_3 = "connect_to_db_password";
  $string_new_3 = $form["connect_to_db"]["password"];


  $app_path = $dir['app_path'];
  $cmd_result = shell_write(
    $app_path,
    "sed -i 's/$string_old_1/$string_new_1/g' .env;
    sed -i 's/$string_old_2/$string_new_2/g' .env;
    sed -i 's/$string_old_3/$string_new_3/g' .env",
    "Save DB logins"
  );
  array_push($result,$cmd_result);
  if ( $cmd_result[1] == "Error") { abort_install(count($result)); }
  return $result;

}

function cmd_generate_key($result,$dir,$form){

  $app_path = $dir['app_path'];
  $cmd_result = shell_write(
  $app_path,
  "php artisan key:generate",
  "Generate key"
  );
  array_push($result,$cmd_result);
  if ( $cmd_result[1] == "Error") { abort_install(count($result)); }
  return $result;

}

function cmd_download_libraries($result,$dir,$form){

  $app_path = $dir['app_path'];
  $cmd_result = shell_write(
    $app_path,
    "composer install",
    "Download libraries"
  );
  array_push($result,$cmd_result);
  if ( $cmd_result[1] == "Error") { abort_install(count($result)); }
  return $result;

}

function cmd_populate_database($result,$dir,$form){

  $app_path = $dir['app_path'];
  // "php artisan migrate",
  $cmd_result = shell_write(
    $app_path,
    // "php artisan migrate",
    "php artisan migrate --env=production;
    yes;",
    "Populate database"
  );
  array_push($result,$cmd_result);
  if ( $cmd_result[1] == "Error") { abort_install(count($result)); }
  return $result;

}
?>
