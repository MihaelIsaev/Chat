<?php

/*
 * Change username
 */
$socket = new sockets();
$socket::actionRename($_SESSION[userName], $_POST[name]);
$_SESSION[userName] = $_POST[name];
echo json_encode(array('status' => 'ok'));
exit();