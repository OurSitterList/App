<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php

// session check
require_once 'session_check.php';

//echo print_r($_SESSION, true);
//die;

// check for error message
$errorType = 'danger';
$msg = getPostMSG();
if ($msg)
{
    $errorMsg = $msg;
    if (isset($_SESSION['postmsg_type']) && $_SESSION['postmsg_type'])
    {
        $errorType = $_SESSION['postmsg_type'];
    }
}
else
{
    $errorMsg = 'An unexpected error has occurred. Please try again.';
}

?>
    <section class="sitter_details_outer">
        <div class="container">
            <?php
            /*if (isset($_REQUEST['sent']) && $_REQUEST['sent'] == '1')
            {
                echo '<div class="alert alert-success">Your message has been sent.</div>';
            }*/

            ?>
            <div class="alert alert-danger"><?=$errorMsg; ?></div>
            <br />
        </div>
    </section>
<?php include('includes/footer.php');?>