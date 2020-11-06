<?php

if (count($argv) < 2 || $argv[1] !== 'fromcli')
{
    mail('sethcriedel@gmail.com', 'Do Backup called incorrectly', $msg, 'From: oursitterlist@gmail.com');
    die('Forbidden');
}

//echo realpath(dirname(__FILE__)); die;


$dir = realpath(dirname(__FILE__)) . '/';


//include('includes/connection.php');


//error_reporting(0);
session_start();
include($dir . "administrator321/config/constants.php");
include($dir . "administrator321/classes/Classes.php");
$con=new DBConnection(host,user,pass,db);
$conObj=$con->connectDB(true);
mysql_query ("set character_set_results='utf8'");
//$base_path=mysql_fetch_object(mysql_query("select * from setting where id = '3'"))->settingValue;

$base_path = 	'https://www.oursitterlist.com';

$https_base_path = 'https://www.oursitterlist.com';

include($dir . "classes/Loader.php");


require_once($dir . "AuthnetARB.class.php");



$now = time() + 3600;
$twodays = $now - 86400;

$endDate = date('Y-m-d\TH:i:s', $now);
$startDate = date('Y-m-d\TH:i:s', $twodays);

echo 'Date range: ' . $startDate . ' / ' . $endDate . "\n";

$login = mysql_fetch_object(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='8'"))->settingValue;
$transkey = mysql_fetch_object(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='9'"))->settingValue;

//die("LOGIN: " . $login);
$arb = new AuthnetARB($login, $transkey, false);

// get settled batch list from past 24 hours
$arb->getSettledBatchList($startDate, $endDate);
$parsed = $arb->getXMLResponse();

//print_r($parsed);die;

$batchOk = array();
$toCheck = array();
if (!isset($parsed->batchList[0]))
{
  print_r($parsed);
  die('Unexpected response.');
}

foreach ($parsed->batchList[0] as $v)
{
  $batchId = $v->batchId;
  echo 'Checking batch ' . $batchId . '...
';

  foreach ($v->statistics[0] as $s)
  {
    // var_dump($s);
    if ($s->declineCount > 0 || $s->errorCount > 0)
    {
      if (!in_array($batchId, $toCheck))
      {
        $toCheck[] = $batchId;
      }
    }
    elseif (!in_array($batchId, $batchOk))
    {
      $batchOk[] = $batchId;
    }
  }
  // die('STATS');
  // var_dump($v);
}



// see if there is anything to Check
if (count($toCheck) < 1)
{
  echo "No failed batches to check. The following batch(es) are ok:
  " . print_r($batchOk, true);
  die;
}


print_r($toCheck);
echo "Checking the following batches...";


$alltran = array();
$failedTran = array();
foreach ($toCheck as $batchId)
{
  $arb->getBatchDetails($batchId);
  $parsed = $arb->getXMLResponse();
  print_r($parsed);die;

  if (!isset($parsed->transactions[0]))
  {
    die('Unexpected response format when checking batch details for batch #' . $batchId . ': ' . print_r($arb->response, true));
  }

  // check each transaction

  foreach ($parsed->transactions[0] as $tran)
  {
    // print_r($tran);die;
    if ($tran->transactionStatus != 'settledSuccessfully')
    {
      echo "Not settled... '" . $tran->transactionStatus . "'";
      $failedTran[] = $tran;
      $alltran[] = $tran->transId;
    }
  }
}



// see if there is anything to Check
if (count($failedTran) < 1)
{
  echo "No failed transactions to check.
  ";
  die;
}



//print_r($failedTran);
echo "Checking the following failed transactions...";

$tranprocessed = array();

// die("SELECT * FROM authtransaction_failures WHERE transaction_id IN (" . join(', ', $alltran) . ')');
$resp = mysql_query("SELECT * FROM authtransaction_failures WHERE transaction_id IN (" . join(', ', $alltran) . ')');
if (mysql_num_rows($resp) > 0)
{
  while ($row = mysql_fetch_object($resp))
  {
    $tranprocessed[] = $row->transaction_id;
  }
}

// process each transaction
foreach ($failedTran as $trans)
{
  if (in_array($trans->transId, $tranprocessed))
  {
    echo "Already processed failed transaction " . $trans->transId . '
';
  }
  else if (!$trans->subscription || !$trans->subscription->id)
  {
    echo 'No Subscription! Skipping transaction ' . $trans->transId;
  }
  else
  {
    print_r($trans);
    //echo "Marking failed transaction on user: " . $trans->transId . ' / subscription #' . $trans->subscription->id;

    $uresp = mysql_query("SELECT * FROM user_management WHERE user_subscriberid = " . $trans->subscription->id);
    if (mysql_num_rows($uresp) > 0)
    {
      $row = mysql_fetch_object($uresp);
      //print_r($row);die;
      $upsql = "UPDATE user_management SET payment_error = 1 WHERE user_id = " . $row->user_id;
      $msg = "Marked subscription inactive for user " . $row->user_name . ' (user id ' . $row->user_id . ')';
    }
    else
    {
      $upsql = "";
      $msg = "Warning: could not find active user with subscription #" . $trans->subscription->id;
    }

    // set status in database

    echo $msg;
    $logsql = "INSERT INTO authtransaction_failures (transaction_id, subscriber_id, transaction_date, details) VALUES (" . $trans->transId . ", " . $trans->subscription->id . ", NOW(), '" . mysql_real_escape_string($msg) . "')";
echo $upsql . "

" . $logsql;
/*echo $logsql;die;
*/
    if ($upsql)
    {
      mysql_query($upsql);
      $err = mysql_error();
      if ($err)
      {
        die('MySQL error: ' . $err);
      }
    }

    mysql_query($logsql);

    $err = mysql_error();
    if ($err)
    {
      die('MySQL error: ' . $err);
    }
  }
}

echo "Done with process.";
die;

/*
print_r($toCheck);
echo "To check.";

print_r($batchOk);
echo "Batches ok";

die('here');
*/
