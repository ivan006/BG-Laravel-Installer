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
    "ls -la ..",
    // "cd ../",
    "mv ../Reportify_Installer ../../",
    // "mv ../Reportify_Installer ../",
    // "cp ../Reportify_Installer ./temp",
    "pwd",
    "ls -la",
  );
  $responce = run_commands($commands);
  echo "<pre>";
  echo json_encode($responce,JSON_PRETTY_PRINT);
  echo "</pre>";
}

function run_commands($commands){
  $responce = array();
  foreach ($commands as $key => $command) {
    $responce[$key] = shell_exec($command);
  }
  return $responce;
}
?>
