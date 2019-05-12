<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php if((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='') || $_SESSION['user_type']!='family')
	{

		header('Location:/');
		exit;
	}
	else if (isset($_SESSION['_sub_expired']) && $_SESSION['_sub_expired'] === true)
	{
		header('Location:'.$base_path.'/family_app_member.php?expired=1');
		exit;
	}

		?>
<section class="sitter_list_outer">
	<div class="container">
    	<div class="sitter_list_inner clearfix">

                	<?php

					$msg = getPostMSG();
					if ($msg)
					{
						$msgType = getPostMSGType();
						echo '<div class="alert alert-' . $msgType . '">' . $msg . '</div>';
					}

					 $search_query_sql = "select  DISTINCT  set_code from job_management
														WHERE
														family_user_id='".$_SESSION['user_id']."' order by `booking_placed_date` DESC";

					$search_query = mysql_query($search_query_sql);
if(mysql_num_rows($search_query)>0)
{
	while($R = mysql_fetch_object($search_query))
	{
		$job_query = mysql_query("select * from `job_management` where set_code='".$R->set_code."' ORDER BY STR_TO_DATE(booking_date, '%m/%d/%Y'), start_time");
		$datearr =array();
		$datearr1 =array();
		$datearr1_start =array();
		$datearr1_end =array();
		$datearr2 =array();

		$show_msg='';
		$is_expired  =array();
		$last = null;
		while($JD = mysql_fetch_object($job_query))
		{
			$datearr[] = "'".trim($JD->booking_date)."'";
			$datearr2[] = "*".trim($JD->booking_date)."*";
			$datearr1[] = trim($JD->booking_date);
			$datearr1_start[] = trim($JD->start_time);
			$datearr1_end[] = trim($JD->end_time);
			//$show_msg.='<tr><td><span>'.trim($JD->booking_date).'</span></td><td><span>'.str_pad($JD->start_time, 2, '0', STR_PAD_LEFT).':00 - '.str_pad($JD->end_time, 2, '0', STR_PAD_LEFT).':00</span></td></tr>';
			$show_msg.='<tr><td><span>'.trim($JD->booking_date).'</span></td><td><span>'.date("h:i a",mktime($JD->start_time,0,0,0,0,0)).' - '.date("h:i a",mktime($JD->end_time,0,0,0,0,0)).'</span></td></tr>';

			$last = $JD;
		}

		// check expired
		if ($last)
		{
			if ( strtotime(trim($last->booking_date) . ' ' . $last->start_time . ':00-0500') < strtotime('now') )
			{
				$is_expired[] = 1;
			}
			else{
				$is_expired[] = 0;
			}
		}

		$totaldate = implode(',',$datearr);
		$totaldate1 = implode(', ',$datearr1);
		$totaldate2 = implode(',',$datearr1);
		$totaldate2_start = implode(',',$datearr1_start);
		$totaldate2_end = implode(',',$datearr1_end);
		$job_history =  mysql_fetch_object(mysql_query("select * from `job_management` where set_code='".$R->set_code."'"));
		if(in_array(1,$is_expired))
		{
			$class = 'expired_job';
		}
		else
		{
			$class = '';
		}
		?>
        <div class="sitter_list_leftarea col-lg-10 col-md-10 col-sm-8 col-xs-12 <?=$class?>">
        		<div class="overlay-two"></div>
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
                          <p><span>Remarks:</span><?=urldecode($job_history->remarks)?></p>
                            <p><table class="family-table"><tr><th><span>Appointment Date</span></th><th><span>Time</span></th></tr>
                            <?=$show_msg?>
							</table>
							</p>
                          <p><span>Job Posted Date:</span><?=date('m/d/Y',$job_history->booking_placed_date)?>
                        </div>


                    </div>
                     </div>
            </div>
            <div class="sitter_list_rightarea col-lg-2 col-md-2 col-sm-4 col-xs-12">
            	<div class="sitter_right_link">
              <?php if(!$class == 'expired_job')
			  {
				  ?>
               <?php $search_query_app_sql = mysql_query("select  * from jobapply_management
														WHERE
														job_id='".$R->set_code."' and family_approval='1' ");
						if(mysql_num_rows($search_query_app_sql)>0)
						{
							echo ' <span>Job Is Confirmed</span>';
						}
						?>
                	<?php $search_query_sql = mysql_query("select  * from jobapply_management
														WHERE
														job_id='".$R->set_code."' order by applytime ");
						if(mysql_num_rows($search_query_sql)>0)
						{
							echo '<span>Apply By - '.mysql_num_rows($search_query_sql).'Sitter</span>';
							?>

                           <a href="family_posting_details.php?set_code=<?=$R->set_code?>">Check Details</a>
                           <?php
						}
						else
						{
							?>
							 <a  class="md-trigger" data-modal="modal-edit-job" onClick="call_edit(<?=$R->set_code?>,<?=$job_history->no_of_kids?>,'<?=$job_history->location_code?>','<?=$job_history->remarks?>','<?=$totaldate2?>','<?=$totaldate2_start?>','<?=$totaldate2_end?>')">Edit This Job</a>
                             <?php
						}
						?>
                 <?php
			  }
			  ?>
                        <a href="family_jobposting_delete.php?job_id=<?=$R->set_code?>">Delete This Job</a>
                </div>

            </div>
        <?php

	}
}
else{
?>
	<div class="sitters_list"><div class="sitter_app_heading"><h3>You have not posted any jobs</h3></div></div>
<?php
}
?>

        </div>
    </div>
</section>

<?php include('includes/footer.php');?>