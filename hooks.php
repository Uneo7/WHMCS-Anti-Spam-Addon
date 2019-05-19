<?php
use WHMCS\Module\Addon\Setting;
use WHMCS\Config\Setting as GlobalSetting;

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

	$proxy_check = Setting::where([
		'module' => 'anti_spam',
		'setting' => 'proxy_check'
	])->first();

	if ($proxy_check && $proxy_check->value === 'on') {
		
		$proxy_header = GlobalSetting::where([
			'setting' => 'proxyHeader'
		])->first();

		$ip = $_SERVER['REMOTE_ADDR'];
		if($proxy_header && !empty($proxy_header->value)) {
			$ip = $_SERVER[$proxy_header->value];
		}
		
		$api = Setting::where([
			'module' => 'anti_spam',
			'setting' => 'api_key'
		])->first();

		$url = "http://proxycheck.io/v2/$ip?vpn=1";
		if ($api && $api->value) {
			$url .= '&key=' . $api->value;
		}

		$client = new GuzzleHttp\Client();
		$res = $client->get($url);

		$code = $res->getStatusCode();
		if ($code === 200) {
			$proxy = json_decode($res->getBody());

			if ($proxy && $proxy->status === 'ok' && $proxy->$ip->proxy === 'yes') {
				return $_ADDONLANG['proxy'];
			}
		}
		

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
