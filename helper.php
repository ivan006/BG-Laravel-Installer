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
    // "mv ../Reportify_Installer ../../",
    // "mv ../Reportify_Installer ../",
    // "cp ../Reportify_Installer ./temp",
    "rm ../Reportify_Installer",
    "pwd",
    "ls -la",
  );
  $responce = run_commands($commands);
  echo "<pre>";
  // echo json_encode($responce,JSON_PRETTY_PRINT);
  echo reveal_array($responce);
  echo "</pre>";
}

function run_commands($commands){
  $responce = array();
  foreach ($commands as $key => $command) {
    $responce[$key." - ". $command] = shell_exec($command);
  }
  return $responce;
}

function reveal_array($elements) {
  ob_start();
  foreach ($elements as $key => $element) {
    // code...
    ?>
    <details>
      <summary><?php echo $key ?></summary>
      <?php
      if (is_array($element)) {
        reveal_array();
      } else {
        echo $element;
      }
      ?>
    </details>
    <?php
  }

  $result = ob_get_contents();

  ob_end_clean();
  return $result;
}
?>
