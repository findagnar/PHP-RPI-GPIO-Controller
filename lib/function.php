<?php
function root_exec($exec){
	$config = include(dirname(__DIR__) . '/config/config.php');
	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
	if ($socket < 0) {
		return false;
	}
	$result = socket_connect($socket, 'localhost', 13007);
	if($result < 0){
		return false;
	}
	$data = [
		'shell' => $exec,
		'token' => $config['token'],
	];
	$data = json_encode($data);
	socket_write($socket, $data);
	$out = socket_read($socket, 8192);
	socket_close($socket);
	return $out;
}