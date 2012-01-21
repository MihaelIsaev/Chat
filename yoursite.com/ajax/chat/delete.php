<?php

/*
 * Message delete
 */
$socket = new sockets();
$socket::checkConnection();
$socket::run('Delete');
