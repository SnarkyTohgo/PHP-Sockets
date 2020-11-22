<?php

/**
 * Define host and port and prevent timeout
 */
$host = "127.0.0.1";
$port = 25003;

set_time_limit(0);

/**
 * Create socket, bind socket to port and start listening for connections
 */
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
$result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
$result = socket_listen($socket, 3) or die("Could not set up socket listener\n");

/**
 * Accept incoming connections, spawn another socket to handle communication
 * Read client input and clean up input string, then reverse client input and send back
 */
$spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
$input = socket_read($spawn, 1024) or die("Could not read input\n");
$input = trim($input);

echo "Client Message : " . $input;
$output = strrev($input) . "\n";
socket_write($spawn, $output, strlen($output)) or die("Could not write output\n");

/**
 * Close sockets
 */
socket_close($spawn);
socket_close($socket);

?>