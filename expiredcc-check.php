<?php

if (count($argv) < 2 || $argv[1] !== 'fromcli')
{
    mail('sethcriedel@gmail.com', 'expiredcc-check called incorrectly', $msg, 'From: noreply@oursitterlistnashville.com');
    die('Forbidden');
}

include("administrator321/config/constants.php");
include("administrator321/classes/Classes.php");

$mailbox = "{localhost:993/imap/ssl/novalidate-cert}";
$user = 'expiredcc@oursitterlistnashville.com';
$pass = '5$[LN$))+-ZZ';
$queries = array();
$subids = array();

$imap = imap_open($mailbox, $user, $pass) or die('Error: unable to open mailbox');

echo 'Opened...<br />
';


$numMessages = imap_num_msg($imap);
for ($i = $numMessages; $i > 0; $i--) {
    $header = imap_header($imap, $i);

    $fromInfo = $header->from[0];
    $replyInfo = $header->reply_to[0];

    $details = array(
        "fromAddr" => (isset($fromInfo->mailbox) && isset($fromInfo->host))
            ? $fromInfo->mailbox . "@" . $fromInfo->host : "",
        "fromName" => (isset($fromInfo->personal))
            ? $fromInfo->personal : "",
        "replyAddr" => (isset($replyInfo->mailbox) && isset($replyInfo->host))
            ? $replyInfo->mailbox . "@" . $replyInfo->host : "",
        "replyName" => (isset($replyTo->personal))
            ? $replyto->personal : "",
        "subject" => (isset($header->subject))
            ? $header->subject : "",
        "udate" => (isset($header->udate))
            ? $header->udate : ""
    );

    $uid = imap_uid($imap, $i);


    $checked = false;
    if (stripos($details['subject'], 'Failed transaction') > -1) {
        $split = explode(':', $details['subject']);
        $split2 = explode(' ', $split[0]);
        $subid = array_pop($split2);
        
        if (!preg_match('/^[1-9]+[0-9]*$/', $subid)) {
            echo 'Skipping invalid subscription id: ' . $subid . ' (' . $details['subject'] . ')';
        }
        else 
        {
            $body = getBody($uid, $imap);
            // echo $body;
            // die('Checking failed transaction for subscription #' . $subid . ' (' . $details['subject'] . ')');

            if (stripos($body, 'transaction has been declined') > -1) {
                echo 'Transaction failed. Flagging subscription #' . $subid . ' as needing CC update..\n<br/>';
                $queries[] = "UPDATE user_management SET payment_error = 1 WHERE user_subscriberid = " . $subid;
                $subids[] = $subid;
                $checked = true;

                // mark for deletion
                imap_delete($imap, $uid, FT_UID);
            }
        }
    }
    

    if (!$checked) {
        echo 'Not checked: ' . $details['subject'] . '<br/>\n';
        imap_delete($imap, $uid, FT_UID);
    }



/*
    echo "<ul>";
    echo "<li><strong>From:</strong>" . $details["fromName"];
    echo " " . $details["fromAddr"] . "</li>";
    echo "<li><strong>Subject:</strong> " . $details["subject"] . "</li>";
    echo "</ul>";

     echo $body;
     echo '<br/><br/>';*/
    // die;
}


if (count($queries) > 0) {
    print_r($queries);
    echo 'Running ' . count($queries) . ' queries...';

// die;
    $con = new DBConnection(host,user,pass,db);
    $conObj = $con->connectDB();

    echo "SELECT * FROM user_management WHERE user_subscriberid IN (" . implode(', ', $subids) . ')\n\n';
    echo "SELECT * FROM user_information WHERE user_id IN (SELECT user_id FROM user_management WHERE user_subscriberid IN (" . implode(', ', $subids) . "))";


    foreach ($queries as $sql) {
        mysql_query($sql) or die('Error running query (' . $sql . '): ' . print_r(mysql_error(), true));
    }

    echo 'Done with queries. Expunging mailbox...<br/>\n';
    echo 'Messages expunged.';
}
else 
{
    echo 'No queries to run.';
}

imap_close($imap, CL_EXPUNGE);
die();


function getBody($uid, $imap) {
    $body = get_part($imap, $uid, "TEXT/HTML");
    // if HTML body is empty, try getting text body
    if ($body == "") {
        $body = get_part($imap, $uid, "TEXT/PLAIN");
    }
    return $body;
}

function get_part($imap, $uid, $mimetype, $structure = false, $partNumber = false) {
    if (!$structure) {
           $structure = imap_fetchstructure($imap, $uid, FT_UID);
    }
    if ($structure) {
        if ($mimetype == get_mime_type($structure)) {
            if (!$partNumber) {
                $partNumber = 1;
            }
            $text = imap_fetchbody($imap, $uid, $partNumber, FT_UID);
            switch ($structure->encoding) {
                case 3: return imap_base64($text);
                case 4: return imap_qprint($text);
                default: return $text;
           }
       }

        // multipart 
        if ($structure->type == 1) {
            foreach ($structure->parts as $index => $subStruct) {
                $prefix = "";
                if ($partNumber) {
                    $prefix = $partNumber . ".";
                }
                $data = get_part($imap, $uid, $mimetype, $subStruct, $prefix . ($index + 1));
                if ($data) {
                    return $data;
                }
            }
        }
    }
    return false;
}

function get_mime_type($structure) {
    $primaryMimetype = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER");

    if ($structure->subtype) {
       return $primaryMimetype[(int)$structure->type] . "/" . $structure->subtype;
    }
    return "TEXT/PLAIN";
}