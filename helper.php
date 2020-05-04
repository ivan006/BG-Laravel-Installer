<?php
function install($home_dir_path){


  // run_command("pwd"),
  // run_command("ls -la .."),
  // run_command("rm -rf *"),
  // run_command("pwd"),
  // run_command("ls -la .."),
  //
  // cp -a FlexFile-3/public/. public_html/
  // mv FlexFile-3/public/* public_html/
  // mv public_html/* FlexFile-3/public/ (no)
  // mv public_html/FlexFile-3 .
  // ln -s /usr/www/users/bluegpyuty  public_html
  // /var/www/bluegpyuty
  // /usr/www/users/bluegpyuty/public

  $result = array();


  // echo command_title("cd $home_dir_path; pwd");

  // echo $navigation_result;
  //

  $FindDir = shell_find_dir($home_dir_path,"home");
  if ( $FindDir[1] == "Success") {
    array_push($result,$FindDir);
  } else {
    array_push($result,$FindDir);
    return $result;
  }

  // download app
  $download_app = shell_write(
    $home_dir_path,
    "git clone https://github.com/ivan006/FlexFile-3",
    "Download app"
  );
  array_push($result,$download_app);

  // find app dir
  $app_path = $home_dir_path."/FlexFile-3";
  $FindDir = shell_find_dir($home_dir_path."/FlexFile-3","app");
  if ( $FindDir[1] == "Success") {
    array_push($result,$FindDir);
  } else {
    array_push($result,$FindDir);
    return $result;
  }

  // download libraries
  $download_app = shell_write(
    $app_path,
    "composer install",
    "Download libraries"
  );
  array_push($result,$download_app);

  // find webroot dir
  $webroot_path = $home_dir_path."/public_html";
  $FindDir = shell_find_dir($webroot_path,"webroot");
  if ( $FindDir[1] == "Success") {
    array_push($result,$FindDir);
  } else {
    array_push($result,$FindDir);
    return $result;
  }

  // Deploy webroot files
  $download_app = shell_write(
    $webroot_path,
    "cp $app_path/public/* ./",
    "Deploy webroot files"
  );
  array_push($result,$download_app);


  return $result;
}

// function run_commands($commands){
//   $responce = array();
//   foreach ($commands as $key => $command) {
//     $responce[$key." (". $command.")"] = shell_exec($command);
//   }
//   return $responce;
// }

function command_title($command){
  $responce = array();
  $responce = "<b>".$command."</b><br>";
  return $responce;
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

  $shell_result = rtrim(exec(
    "cd $dir;
    $cmd 2>&1"
    , $outputs
  ));

  $result = array(
    "Download app",
    "<pre>".json_encode($outputs,JSON_PRETTY_PRINT)."</pre>",
  );
  return $result;
}
?>
