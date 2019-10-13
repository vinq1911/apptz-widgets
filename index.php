<?php

	include 'sys/config.php';
	include 'sys/functions.php';

	if (!((int) $apptz_widget_request[0])) $apptz_error("Missing APPTZ identifier.");
	if (file_exists('inc/'.$apptz_widget_request[1].'.php')) {
		include('inc/'.$apptz_widget_request[1].'.php');
	}

	exit(apptzwidget::export());
?>
