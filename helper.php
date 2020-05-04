<?php
function install($home_dir_path){


  ob_start();

  // run_command("pwd"),
  // run_command("ls -la .."),
  // run_command("rm -rf *"),
  // run_command("pwd"),
  // run_command("ls -la .."),


  // echo command_title("cd $home_dir_path; pwd");
  $navigation_result = shell_exec("cd $home_dir_path; pwd");
  // echo $navigation_result;

  if (rtrim($navigation_result) == $home_dir_path) {
    ?>
    Home directory found
    13
    <?php

  }

  $result = ob_get_contents();

  ob_end_clean();

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

function reveal_array($elements) {
  ob_start();
  foreach ($elements as $key => $element) {
    // code...
    ?><details>
      <summary><?php echo $key ?></summary>
      <?php
      if (is_array($element)) {
        echo reveal_array($element);
      } else {
        echo $element;
      }
      ?>
    </details><?php
  }

  $result = ob_get_contents();

  ob_end_clean();
  return $result;
}
?>
