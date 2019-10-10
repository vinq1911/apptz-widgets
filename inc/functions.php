<?php

if (!defined("APPTZ")) die("Configuration error. Please refer to your APPTZ consult.");

// determine which widget is to be accessed
$apptz_widget_request = (function($_r) { $req = [];
	foreach (explode("/", $_r) as $r) {
		if (!!$r) {
			$req[] = preg_replace("/[^a-zA-Z0-9]+/", "", $r);
		}
	}
	return $req;
})($_SERVER['APPTZWIDGET']);



?>
