<?php

/*
 * Chat send message
 */
$socket = new sockets();
$socket::checkConnection();
$socket::run('Send');