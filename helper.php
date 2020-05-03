<?php
function install(){
  // $commands = array(
  //   "mv ../Reportify_Installer .../",
  //   "rm -rf fulldir",
  //   "mkdir fulldir",
  //   "mv /tmp/file.txt fulldir/",
  // );
  $commands = array(
    "pwd",
    "ls",
    "cd ../",
    "pwd",
    "ls",
  );
  $responce = run_command($commands);
  echo "<pre>";
  echo json_encode($responce,JSON_PRETTY_PRINT);
  echo "</pre>";
}

function run_command($commands){
  $responce = array();
  foreach ($commands as $key => $command) {
    $responce[$key] = shell_exec($command);
  }
  return $responce;
}
?>
