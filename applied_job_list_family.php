<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php if((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='') || $_SESSION['user_type']!='sitter')
			{
				
				header('Location:/');
				
			}
			
		?>
<section class="sitter_list_outer">
	<div class="container">
    	<div class="sitter_list_inner clearfix">
        	
                	<?php 
					 $search_query_sql = "select  * from jobapply_management 
														WHERE 
														sitter_user_id='".$_SESSION['user_id']."' order by applytime ";
								
													//echo  $search_query_sql;				
					$search_query = mysql_query($search_query_sql);
if(mysql_num_rows($search_query)>0)
{
	$available = 1;
	while($R = mysql_fetch_object($search_query))
	{
		$job_query = mysql_query("select * from `job_management` where set_code='".$R->job_id."'");
		$datearr =array();
		$datearr1 =array();

		while($JD = mysql_fetch_object($job_query))
		{
			$datearr[] = "'".trim($JD->booking_date)."'";
			$datearr1[] = trim($JD->booking_date);
			//echo "select * from book_management where sitter_user_id='".$_SESSION['user_id']."' and sitter_approval!='2' and `booking_date` like '%".trim($JD->booking_date)."%'";
			/*$availabily_check = mysql_query("select * from book_management where sitter_user_id='".$_SESSION['user_id']."' and sitter_approval='1' and `booking_date` like '%".trim($JD->booking_date)."%'");
		if(mysql_num_rows($availabily_check)>0)
		{
			$available = 0;
		}*/
		}
		$totaldate = implode(',',$datearr);
		$totaldate1 = implode(', ',$datearr1);
		$job_history =  mysql_fetch_object(mysql_query("select * from `job_management` where set_code='".$R->job_id."'"));
		
		?>
        <div class="sitter_list_leftarea col-lg-10 col-md-10 col-sm-8 col-xs-12">
            	<div class="sitter_left_cont">
                	<div class="sitters_list">
                    	
                        	<div class="sitter_details">
                             
                                 <div id='job_management<?=$job_history->set_code?>'></div>
                                       
                                </div>
                          <script>
						  $(function() {

							$('#job_management<?=$job_history->set_code?>').multiDatesPicker({
								defaultDate:'<?=$job_history->booking_date?>',
								disabled: true,
								addDates: [<?=$totaldate?>]
							});
							});
						  </script>
                        	<div class="sitter_details">
                        	<div class="sitter_personal_detl">
                            	<h3>Job Code - </h3>
                                <p><?=$job_history->set_code?> </p>
                            </div>
                          <p><span>Time:</span><?=$job_history->start_time?> - <?=$job_history->end_time?></p>
                          <p><span>No Of Kids:</span><?=$job_history->no_of_kids?></p>
                          <p><span>Zipcode:</span><?=$job_history->location_code?></p>
                          <p><span>Family Remarks:</span><?=$job_history->remarks?></p>
                            <p><span>Appointment Date:</span><?=$totaldate1?></p>
                          <p><span>Job Posted Date:</span><?=date('m/d/Y',$job_history->booking_placed_date)?>
                          <p><span>Your Remarks : </span><?=$R->remarks?>
                           <p><span>Apply Date : </span><?=date('m/d/Y',$R->applytime )?>
                        </div>
                        	
                        
                    </div>
                     </div>
            </div>
            <div class="sitter_list_rightarea col-lg-2 col-md-2 col-sm-4 col-xs-12">
            	<div class="sitter_right_link">
                <?php if($R->family_approval==1)
						{
				
					echo 'You have already Get this Job';
						}
						else
						{
						echo 'Wait For Family Approval';
						}
				?>
                </div>
                
            </div>
        <?php
	
	}
}
else
{
	?>
      <div class="message">No Result Found</div>
      <?php
}
?>
               
        </div>
    </div>
</section>

<?php include('includes/footer.php');?>
