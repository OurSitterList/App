<?php

include('includes/connection.php');

function dieJSONError($error)
{
    die('{"error": true, "msg": "' . $error . '"}');
}

function dieJSONSuccess()
{
    die('{"error": false}');
}


$code = $_POST['code'];

if (strtolower($code) === 'waller')
{
    $_SESSION['familypromo'] = 1;
    dieJSONSuccess();
}
else 
{
    $_SESSION['familypromo'] = 0;
    dieJSONError('Invalid promo code provided. Please check the code you were given.');
    
    // @TODO: check count to lock people out
}