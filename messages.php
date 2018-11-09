<style>
	table#messages-table {
	    width: 100%;
	    font-family: Arial, Helvetica, sans-serif;
	    margin: 0 0 40px 0;
	}

	table#messages-table thead {
	    border-bottom: 1px solid #CCC;
	}

	table#messages-table td, table#messages-table th {
	   padding: 4px 2px;   
	}
</style>

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
        <div class="messages clearfix">
    	    <div class="sitter_app_heading">
		<h3>Messages</div>
	    </div>
	    <div class="sitter_app_cont">
		<table id="messages-table">
		    <thead>
			<th>Date</th>
			<th>Message</th>
		    </thead>
		    <tbody>
			<tr>
			    <td colspan="3">No messages.</td>
			</tr>
		    </tbody>
		</table>
	    </div>
	</div>
    <div>
</section>

<?php include('includes/footer.php');?>

</body>

</html>
