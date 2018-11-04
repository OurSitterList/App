<?php include('includes/connection.php');?>

<?php include('includes/header2.php');?>

<?php
	if ((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='')) {
		header('Location:/');
	        exit;		
	}
?>
<section class="about_outer">
    <div class="container">
        <div class="about_cont clearfix">
		<div class="about_left col-lg-4 col-md-4 col-sm-4 col-xs-12">
    			<h3>Messages</div>
	    	</div>
	</div>
    <div>
</section>

<?php include('includes/footer.php');?>

</body>

</html>
