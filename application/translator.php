<?php
	// Debugging status
	error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
	// Show errors with output
	ini_set("display_errors", "on");

	$lang = $_SESSION['lang_admin'] == null ? $_SESSION['lang_admin'] = "en" : $_SESSION['lang_admin'];
	$path = 'lang/' . $lang . '.lang.php';
	require_once $path;
?>