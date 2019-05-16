<?php

add_hook('ClientDetailsValidation', 1, function($vars) {
	require __DIR__ . '/vendor/autoload.php';

	global $CONFIG;
	$lang = $CONFIG['Language'];
	if (!$lang) $lang = 'english';
	
	require __DIR__ . "/lang/$lang.php";

  	$email = urlencode($vars['email']);
	$client = new GuzzleHttp\Client();
	$res = $client->get("https://open.kickbox.com/v1/disposable/$email");

	$code = $res->getStatusCode();
	if ($code === 200) {
		$email = json_decode($res->getBody());
		if (isset($email->disposable)) $email = $email->disposable;

		if ($email) return $_ADDONLANG['disposable'];
	}
});

add_hook('ClientAreaPage', 1, function($vars) {

	if (!$vars['client']) return;

	if ($vars['client']->emailVerified) return;

	if (isset($_GET['m']) && $_GET['m'] === 'anti_spam') return;

	if (isset($vars['verificationId'])) return;

	header('Location: index.php?m=anti_spam');
	exit();
});
