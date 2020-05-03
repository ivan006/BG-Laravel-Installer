<?php
echo 1;
function install(){

    ob_start();
    ?>
    pwd
    <?php
    // mv ../Reportify_Installer .../
    // rm -rf fulldir
    // mkdir fulldir
    // mv /tmp/file.txt fulldir/

    $result = ob_get_contents();

    ob_end_clean();
    $response = array()
    exec($result, $response);
    print_r($response,true);
}
?>
