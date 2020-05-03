<?php
function install(){

    ob_start();
    ?>
    mv ../Reportify_Installer .../
    <?php
    // rm -rf fulldir
    // mkdir fulldir
    // mv /tmp/file.txt fulldir/

    $result = ob_get_contents();

    ob_end_clean();
    echo shell_exec($result);
}
?>
