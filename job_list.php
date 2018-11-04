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
					 $search_query_sql = "select  DISTINCT  set_code from job_management 
														WHERE 
														`booking_date` between '".$_REQUEST['job_search_from_date']."' and '".$_REQUEST['job_search_to_date']."' order by `booking_placed_date` DESC";
									if($_REQUEST['job_search_location_code']!='' || $_REQUEST['job_search_location_code']!=0)
														{
															$search_query_sql.=" AND `location_code`='".$_REQUEST['job_search_location_code']."'";
														}	
													//echo  $search_query_sql;				
					$search_query = mysql_query($search_query_sql);
if(mysql_num_rows($search_query)>0)
{
	$available = 1;
	
	
	while($R = mysql_fetch_object($search_query))
	{
		$search_query_app_sql = mysql_query("select  * from jobapply_management 
														WHERE 
														job_id='".$R->set_code."' and family_approval='1' ");
						if(mysql_num_rows($search_query_app_sql)>0)
						{
					
						}
						else
						{
						
						
		$job_query = mysql_query("select * from `job_management` where set_code='".$R->set_code."'");
		$datearr =array();
		$datearr1 =array();
$is_expired  =array();
$show_msg='';
//echo 'New Start~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~';
		$flag_arr_exist  = array();
		while($JD = mysql_fetch_object($job_query))
		{
			
			$datearr[] = "'".trim($JD->booking_date)."'";
			$datearr1[] = trim($JD->booking_date);
			//$show_msg.='<tr><td><span>'.trim($JD->booking_date).'</span></td><td><span>'.str_pad($JD->start_time, 2, '0', STR_PAD_LEFT).':00 - '.str_pad($JD->end_time, 2, '0', STR_PAD_LEFT).':00</span>';
				$show_msg.='<tr><td><span>'.trim($JD->booking_date).'</span></td><td><span>'.date("h:i a",mktime($JD->start_time,0,0,0,0,0)).' - '.date("h:i a",mktime($JD->end_time,0,0,0,0,0)).'</span>';
			//echo "select * from book_management where sitter_user_id='".$_SESSION['user_id']."' and sitter_approval!='2' and `booking_date` like '%".trim($JD->booking_date)."%'";
			$search_schedule = mysql_fetch_array(mysql_query("select * from user_information where user_id='".$_SESSION['user_id']."'"));
			$dayname = date('D',strtotime(trim($JD->booking_date)));
			
			$allocation_arr	=array();
			$allocation_arr1	=array();
			//$today_booking_array = array();
			$start_time = $search_schedule['user_available_'.strtolower($dayname).'_start'];
			$end_time = $search_schedule['user_available_'.strtolower($dayname).'_end'];
								for($i=$start_time;$i<$end_time;$i++)
								{
								$allocation_arr[]	= $i;
								}
							
					$allocation_arr = array_unique($allocation_arr);
				//var_dump($allocation_arr);
				//echo "********************************************".$JD->booking_date."********************************************";
					for($j=$JD->start_time;$j<$JD->end_time;$j++)
					{
							//echo $j.'______________<br>';
							if(!in_array($j,$allocation_arr))
							{
							$flag_arr_exist[] = 0;
								
							}
							else
							{
							
							
							
						$search_free = mysql_query("select * from book_management where sitter_user_id='".$_SESSION['user_id']."' and sitter_approval!='2' and `booking_date` like '%".trim($JD->booking_date)."%'");
						if(mysql_num_rows($search_free)>0)
						{
				
				//$today_booking_array = array();
				while($S=mysql_fetch_object($search_free))
				{
					for($i=$S->start_time;$i<$S->end_time;$i++)
					{
					$allocation_arr1[]	= $i;
					}
				}
			
			
			$allocation_arr1 = array_unique($allocation_arr1);
			//var_dump($allocation_arr1);
			for($j=$JD->start_time;$j<$JD->end_time;$j++)
					{
						
						if(in_array($j,$allocation_arr1))
						{
						$flag_arr_exist[] = 0;	
						
						}
						else
						{
						$flag_arr_exist[] = 1;	
						}
					}
			
			
			
			//$exist_arra =  array_intersect($allocation_arr,$today_booking_array);
			
			
			}	
			
			
			
			
			else
			{
				$flag_arr_exist[] = 1;	
			}
							
							
							
							
							}
							
						}
						
						//echo "select * from jobapply_management where sitter_user_id='".$_SESSION['user_id']."' and family_approval!='2'";
						$search_job_is= mysql_query("select * from jobapply_management where sitter_user_id='".$_SESSION['user_id']."' and family_approval!='2'");
						if(mysql_num_rows($search_job_is)>0)
						{
				$allocation_arr2  =array();
				$flag_arr_exist2  =array();
				//$today_booking_array = array();
				while($S=mysql_fetch_object($search_job_is))
				{
					//echo "select * from job_management where set_code='".$S->set_code."'";
					$SJ = mysql_fetch_object(mysql_query("select * from job_management where set_code='".$S->job_id."'"));
					for($i=$SJ->start_time;$i<$SJ->end_time;$i++)
					{
					 $allocation_arr2[]	= $i;
					}
				}
			
			
			$allocation_arr2 = array_unique($allocation_arr2);
			
			//var_dump($allocation_arr1);
			for($j=$JD->start_time;$j<$JD->end_time;$j++)
					{
						
						if(in_array($j,$allocation_arr2))
						{
						$flag_arr_exist2[] = 0;	//echo '<span>You are not free this time</span>';
						}
						else
						{
							$flag_arr_exist2[] = 1;
						
						}
					}
			
			
			
			//$exist_arra =  array_intersect($allocation_arr,$today_booking_array);
			
			
			}	
					
	//var_dump($flag_arr_exist);					
	//echo '<br>___________________________________________<br>';
			$show_msg.='</td></tr>';				
			//echo implode(',',$flag_arr_exist);
		
		//echo '<br>'.trim($JD->booking_date).'-'.date('d/m/Y',time());
		if( strtotime(trim($JD->booking_date)) < strtotime('now') ) {
				 $is_expired[] = 1;
			}
			else{
				 $is_expired[] = 0;
			}
		}
		$totaldate = implode(',',$datearr);
		$totaldate1 = implode(', ',$datearr1);
		$job_history =  mysql_fetch_object(mysql_query("select * from `job_management` where set_code='".$R->set_code."'"));
		
		if(!in_array(1,$is_expired))
		{
			$search_already= mysql_query("select * from jobapply_management where sitter_user_id='".$_SESSION['user_id']."' and family_approval='1' and `job_id`='".$R->set_code."'");
						if(mysql_num_rows($search_already)<=0)
						{
		?>
      <div class="sitter_list_leftarea col-lg-10 col-md-10 col-sm-8 col-xs-12">
      <?php //echo implode(',',$flag_arr_exist);?>
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
                          <p><span>Location:</span><?=$job_history->location_code?></p>
                          <p><span>Remarks:</span><?=$job_history->remarks?></p>
                          
                     <p><table class="family-table"><tr><th><span>Appointment Date</span></th><th><span>Time</span></th></tr>
                            <?=$show_msg?>
							</table>
                      </p>
                          <p><span>Job Posted Date:</span><?=date('m/d/Y',$job_history->booking_placed_date)?></p>
                        </div>
                        	
                        
                    </div>
                     </div>
            </div>
      <div class="sitter_list_rightarea col-lg-2 col-md-2 col-sm-4 col-xs-12">
        <div class="sitter_right_link">
          <?php if(!in_array('0',$flag_arr_exist))
				{
					//echo "select * from jobapply_management where  job_id='".$R->set_code."', sitter_user_id='".$_SESSION['user_id']."'";
						$search_applied = mysql_query("select * from jobapply_management where  job_id='".$R->set_code."' and sitter_user_id='".$_SESSION['user_id']."'");
						if(mysql_num_rows($search_applied)>0)
						{
					echo '<span>You have already applied to this job</span>';
					?>
    <a class="md-trigger" href="<?=$base_path?>/cancel_job.php?id=<?=$R->set_code?>" >Cancel Application</a>
          <?php
						}
						else
						{
						
						if(in_array(0,$flag_arr_exist2))
						{
							echo '<span>You are not free this time</span>';
						}
						else
						{
								?>
          <a class="md-trigger" data-modal="apply-job" onClick="set_the_code(<?=$R->set_code?>)">Apply to this job</a>
          <?php
						}
				
						
						}
				}
				else
				{
					echo 'You are not available this time';
				}
				?>
        </div>
      </div>
      <?php
						}
		}
	
	}
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
