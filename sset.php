<?php

if ($_SERVER['REMOTE_ADDR'] !== '68.53.106.184')
{
    die('No.' . print_r($_SERVER, true));
}
session_start();

//Array ( [user_id] => 139 [user_name] => admin [user_type] => sitter )

$_SESSION['user_id'] = 138;
$_SESSION['user_name'] = 'AshMar';
$_SESSION['user_type'] = 'sitter';

echo print_r($_SESSION, true);
die;