<?php

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function anti_spam_config()
{
    return [
        'name' => 'AntiSpam Addon',
        'author' => 'Uneo7',
        'version' => '4.2',
        'description' => 'Block disposable email addresses and enforce email validation',
        'fields' => [
            'proxy_check' => [
                'FriendlyName' => 'Proxy / VPN Check',
                'Type' => 'yesno',
                'Size' => '25',
                'Description' => 'Enable proxy/vpn cheking on register',
            ],
            'api_key' => [
                'FriendlyName' => 'Anti proxy API key',
                'Type' => 'text',
                'Size' => '25',
                'Default' => '',
                'Description' => 'API key for <a href="https://proxycheck.io">proxycheck.io</a> (Not API key 100 query / day)',
            ],
        ]
    ];
}

function anti_spam_activate()
{
    return [
        'status' => 'success',
    ];
}

function anti_spam_deactivate()
{
    return [
        'status' => 'success',
    ];
}

function anti_spam_clientarea($vars) {
 
    $lang = $vars['_lang'];

    if ($vars['client']->emailVerified) {
    	header('Location: clientarea.php');
    	exit();
    }
 
    return [
        'pagetitle' => $lang['title'],
        'breadcrumb' => [
        	'index.php?m=anti_spam' => $lang['breadcrumb']
        ],

        'templatefile' => 'activation',
        'requirelogin' => true,
        'vars' => [
            'lang' => $lang,
            'token' => $vars['token'],
        ],
    ];
 
}
