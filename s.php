<?php

if ($_SERVER['REMOTE_ADDR'] !== '68.53.106.184')
{
    die('No.' . print_r($_SERVER, true));
}
session_start();
echo print_r($_SESSION, true);
die;