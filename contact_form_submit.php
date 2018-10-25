<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<META http-equiv="refresh" content="5;URL=<?=$_SERVER['HTTP_REFERER'];?>">
<?php 
$notification 		= new Notification();

$name	= trim($_POST['contact_name']);
$email	= trim($_POST['contact_email']);
$as		= trim($_POST['contact_as']);
$msg	= trim($_POST['contact_comment']);

if(!empty($name) || !empty($email) || !empty($as) || !empty($msg))
{
	$details	= array	('name'	=>$name , 'email'	=>$email , 'as'	=>$as , 'msg'	=>$msg );
	$response 	= $notification->send_contact_form_email($details);
	$response	= array('message' => $response);
	$response 	= new Response($response);
	$response::modal();
}
?>
<?php include('includes/footer.php');?>