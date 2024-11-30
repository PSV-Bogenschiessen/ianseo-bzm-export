<?php

if($on) {
    $ret['BZMEXTRA'][] = 'BZM Extras';
    $ret['BZMEXTRA'][] = 'BZM Export' .'|'.$CFG->ROOT_DIR.'Modules/Custom/'.'ianseo-bzm-export/bzm_export.php';
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

