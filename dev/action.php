<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<META http-equiv="refresh" content="10;URL=<?=HTTP;?>">
<?php
if(isset($_GET['do'])) {

	die('ACTION: ' . $_GET['do']);
	$do 		= ($_GET['do'] != '') 		? 		trim($_GET['do']) 		: NULL;
	$action 	= ($_GET['action'] != '')  	? 		trim($_GET['action']) 	: NULL;
	$nonce 		= ($_GET['nonce'] != '')  	? 		trim($_GET['nonce']) 	: NULL;
	$config		= array ('do' => $do, 'action' => $action, 'nonce' => $nonce);
	
	if($do == NULL) return false;	
	
	$action 	= new Actions($config);
	$response	= $action->$do();
	
	$response	= array('message' => $response);
	$response 	= new Response($response);
	$response::modal();
}
?>
<?php include('includes/footer.php');?>