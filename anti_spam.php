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
        'description' => 'Block disposable email addresses and enforce email validation'
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
