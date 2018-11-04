<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<div class="container">
	<div class="row">
    	<div class="col-lg-offset-3 col-lg-7 col-md-offset-3 col-md-7 col-sm-offset-3 col-sm-7 col-xs-12">
        	<div class="error-box">
				<?php extract($_REQUEST);
                
                if($_REQUEST['isError']==1)
                {
                     echo '<h5>isError: '.$_REQUEST['isError'] . '</h5>'; 
                     echo '<p>getResponse: ' .$_REQUEST['getResponse'] . '</p>'; 
                     
                }
                else
                {
                    header('Location:/');
                
                }
                ?>
             </div>
         </div>
     </div>
</div>
<?php include('includes/footer.php');?>