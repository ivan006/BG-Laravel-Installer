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

  // find home dir
  if (1==1) {

    // echo command_title("cd $home_dir_path; pwd");

    // echo $navigation_result;
    $shell_result = rtrim(shell_exec("cd $home_dir_path; pwd"));
    if ($shell_result !== $home_dir_path) {
      $command_result = array(
        "Find home dir",
        "Fail",
      );
      array_push($result,$command_result);
      return $result;
    } else {
      $command_result = array(
        "Find home dir",
        "Success",
      );
      array_push($result,$command_result);
    }
  }

  // download app
  if (1==1) {
    // code...
    $shell_result = rtrim(exec(
      "cd $home_dir_path;
      git clone https://github.com/ivan006/FlexFile-3 2>&1"
      , $outputs
    ));

    $command_result = array(
      "Download app",
      "<pre>".json_encode($outputs,JSON_PRETTY_PRINT)."</pre>",
    );
    array_push($result,$command_result);
  }

  // find app dir
  if (1==1) {

    $shell_result = rtrim(shell_exec("cd $home_dir_path/FlexFile-3; pwd"));
    $app_path = $home_dir_path."/FlexFile-3";
    if ($shell_result !== $app_path) { return $result; }
    $command_result = array(
      "Find app dir",
      "Success",
    );
    array_push($result,$command_result);
  }

  // download libraries
  if (1==1) {
    // code...
    $shell_result = rtrim(exec(
      "cd $app_path;
      composer install 2>&1"
      , $outputs
    ));

    $command_result = array(
      "Download libraries",
      "<pre>".json_encode($outputs,JSON_PRETTY_PRINT)."</pre>",
    );
    array_push($result,$command_result);
  }

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
?>
