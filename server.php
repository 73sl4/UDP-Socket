<?php
error_reporting(E_ALL | E_STRICT);

$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_bind($socket, '127.0.0.1', 1223);

$from = '';
$port = 0;
while (1) {
    socket_recvfrom($socket, $buf, 5000, 0, $from, $port);
    echo "Received $buf from remote address $from and remote port $port" . PHP_EOL;
}
