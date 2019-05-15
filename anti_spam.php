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