<?php

add_hook('ClientDetailsValidation', 1, function($vars) {
	require __DIR__ . '/vendor/autoload.php';

	$lang = $_SESSION['Language'];
	require __DIR__ . "/lang/$lang.php";


  	$email = urlencode($vars['email']);
	$client = new GuzzleHttp\Client();
	$res = $client->get("https://open.kickbox.com/v1/disposable/$email");

	$code = $res->getStatusCode();
	if ($code === 200) {
		$email = json_decode($res->getBody())->disposable ?? null;
		if ($email) return $_ADDONLANG['disposable'];
	}
});