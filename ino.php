<?php

require_once('assets/scripts/php/utils.php');

if (isset($_GET['msg']) && !empty($_GET['msg'])) {
    $msg = $_GET['msg'];


    $parts = explode("@", $msg);

    $user = R::findOne('user', 'mac = ?', array($parts[1]));

    if (isset($user))
        create_data_row($parts[0] + "@", $user);
}


?>