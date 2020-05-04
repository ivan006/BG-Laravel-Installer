<?php
function install($home_dir_path){
  // $commands = array(
  //   "mv ../Reportify_Installer .../",
  //   "rm -rf fulldir",
  //   "mkdir fulldir",
  //   "mv /tmp/file.txt fulldir/",
  // );

  // $commands = array(
  //   "pwd",
  //   "ls -la ..",
  //   "rm -rf *",
  //   "pwd",
  //   "ls -la ..",
  // );
  // $responce = run_commands($commands);


  // $responce = array(
  //   run_command("
  //   pwd;
  //   pwd;
  //   "),
  //   run_command("ls -la .."),
  //   run_command("mv ../Reportify_Installer ../"),
  //   // run_command("rm -rf *"),
  //   // run_command("mv /Reportify_Installer ./"),
  // );


  // cd ../../;
  // cd accumfcauw;
  // $responce = run_command("
  // cd /usr/home/bluegpyuty/;
  // pwd;
  // ls;
  // ");

  $responce = array(
    run_command("pwd"),
    // run_command("ls -la .."),
    // run_command("rm -rf *"),
    run_command("cd $home_dir_path; pwd"),
    // run_command("pwd"),
    // run_command("ls -la .."),
  );


  echo "<pre>";
  echo reveal_array($responce);
  echo "</pre>";
}

// function run_commands($commands){
//   $responce = array();
//   foreach ($commands as $key => $command) {
//     $responce[$key." (". $command.")"] = shell_exec($command);
//   }
//   return $responce;
// }

function run_command($command){
  $responce = array();
  $responce = "<b>".$command."</b><br>".shell_exec($command);
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
