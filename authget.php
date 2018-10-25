<?php

include('includes/connection.php');
require_once("AuthnetARB.class.php");



$login = mysql_fetch_object(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='8'"))->settingValue;
$transkey = mysql_fetch_object(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='9'"))->settingValue;

//die("LOGIN: " . $login);
$arb = new AuthnetARB($login, $transkey, false);

//$arb->getBatchStatistics();


$arb->getSettledBatchList();
//$arb->getBatchDetails(595025166);
$resp = $arb->response;
var_dump($resp);die;


//$arb->getBatchDetails(595129222);
$resp = $arb->response;
//var_dump($resp);die;
list($headers, $xml) = explode('<?xml', $resp);
$xml = '<?xml' . $xml;
//print_r($resp);

die($xml);

$parsed = new SimpleXMLElement($xml);

if  (!isset($parsed->batchList[0]))
{
  die($resp . '

  Unexpected response.');
}

foreach ($parsed->batchList[0] as $k=>$v)
{
  //var_dump($v);
  /*echo "

  ";*/
  echo "State: " . $v->settlementState;
  echo "

  ";
}
//var_dump($parsed->batchList);
die;
