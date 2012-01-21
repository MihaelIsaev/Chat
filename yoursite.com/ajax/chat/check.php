<?php

/*
 * Getter for messages from sockets
 */

$socket = new sockets();
if($socket::checkConnection()){
    session_write_close();
    $socket::run('Read');
}