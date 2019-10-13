<?php

if (!defined("APPTZ")) die("Configuration error. Please refer to your APPTZ consult.");

$apptz_widget_request = (function($_r) { $req = [];
	foreach (explode("/", $_r) as $r) {
		if (!!$r) {
			$req[] = preg_replace("/[^a-zA-Z0-9]+/", "", $r);
		}
	}
	define("APPTZ_BASE", $req[0]);
	return $req;
})($_SERVER['APPTZWIDGET']);

foreach (['script', 'style', 'font'] as $q) {
	$varname = 'apptz_widget_queue_'.$q;
	$$varname = function($f) use ($q) {
		if (!in_array($f, apptzwidget::$$q)) {
			apptzwidget::${$q}[] = $f;
		}
	};
}

$apptz_dataquery = function($d = 'embed', $p = ['query', 'nothing']) {
	$p = http_build_query($p);
	$ch = curl_init();
	$url = APPTZ['endpoint'].APPTZ_BASE."/$d";
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, true);
	curl_setopt($ch,CURLOPT_POSTFIELDS, $p);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	return json_decode(curl_exec($ch), true);
};

$apptz_error = function($wrd) {
	error_log("Widget script error:");
	error_log(print_r($wrd, true));
	apptzwidget::$output[] = "Error: ".print_r($wrd, true);
	die(apptzwidget::export());
};

$apptz_embed = function($wrd, $cnt, $tpl) {
	$_wrdsolve = function($_wrd) { return strtoupper("%".preg_replace("/[^a-zA-Z0-9]+/", "", $_wrd)."%"); };
	$wrd = (is_array($wrd)) ? array_map($_wrdsolve, $wrd) : $_wrdsolve($wrd);
	if (is_array($cnt) && !is_array($wrd)) {
		$cnt = implode("", $cnt);
	}
	return str_replace($wrd, $cnt, $tpl);
};

$apptz_link = function($suffix, $txt) {
	return '<a href="/'.APPTZ_BASE.'/'.$suffix.'">'.$txt.'</a>';
};

$apptz_render = function($line) {
	apptzwidget::$output[] = $line;
};

class apptzwidget {
	public static $script = [];
	public static $style = [];
	public static $font = [];
	public static $output = [];

	public static function export() {
		echo '<html><head>';
		foreach (self::$script as $s) {
			echo '<script src="'.$s.'"></script>';
		}
		foreach (self::$style as $s) {
			echo '<link rel="stylesheet" href="'.$s.'" />';
		}
		echo '</head><body>';
		foreach (self::$output as $s) {
			echo $s;
		}
		echo '</body></html>';
	}
}

?>
