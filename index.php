<?php
include 'sys/config.php';
include 'sys/functions.php';

if (file_exists('inc/'.$apptz_widget_request[0].'.php')) {
	exit(include('inc/'.$apptz_widget_request[0].'.php'));
}

?>
