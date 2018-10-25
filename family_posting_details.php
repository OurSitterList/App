<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php if((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='') || $_SESSION['user_type']!='family')
			{
				
				header('Location:'.$base_path);
				
			}
			
		?>

<section class="sitter_list_outer">
  <div class="container">
    <div class="sitter_list_inner clearfix">
      <?php 
					 $search_query_sql = "select  DISTINCT  set_code from job_management 
														WHERE 
														family_user_id='".$_SESSION['user_id']."' and set_code='".$_REQUEST['set_code']."'";
														
					$search_query = mysql_query($search_query_sql);
if(mysql_num_rows($search_query)>0)
{
	while($R = mysql_fetch_object($search_query))
	{
		$job_query = mysql_query("select * from `job_management` where set_code='".$R->set_code."'");
		$datearr =array();
		$datearr1 =array();

		while($JD = mysql_fetch_object($job_query))
		{
			$datearr[] = "'".trim($JD->booking_date)."'";
			$datearr1[] = trim($JD->booking_date);
			//$show_msg.='<tr><td><span>'.trim($JD->booking_date).'</span></td><td><span>'.str_pad($JD->start_time, 2, '0', STR_PAD_LEFT).':00 - '.str_pad($JD->end_time, 2, '0', STR_PAD_LEFT).':00</span>';
			$show_msg.='<tr><td><span>'.trim($JD->booking_date).'</span></td><td><span>'.date("h:i a",mktime($JD->start_time,0,0,0,0,0)).' - '.date("h:i a",mktime($JD->end_time,0,0,0,0,0)).'</span>';
		}
		$totaldate = implode(',',$datearr);
		$totaldate1 = implode(', ',$datearr1);
		$job_history =  mysql_fetch_object(mysql_query("select * from `job_management` where set_code='".$R->set_code."'"));
		?>
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
      <div class="applicant_list">
        <h3 class="title-4">Applicant List</h3>
        <?php
$already_apporve=0;
   $search_query_app_sql = mysql_query("select  * from jobapply_management 
              WHERE 
              job_id='".$R->set_code."' and family_approval='1' ");
      if(mysql_num_rows($search_query_app_sql)>0)
      {
       $already_apporve  =1;
      }
      
		 	$search_query_sql = "select *,UM.user_id  from user_management as UM
														JOIN
														jobapply_management as JM 
														ON 
														UM.user_id=JM.sitter_user_id 
														WHERE 
														UM.user_type='sitter' and  JM.job_id='".$R->set_code."' order by JM.applytime";
			
			$search_query = mysql_query($search_query_sql);
if(mysql_num_rows($search_query)>0)
{
	while($R = mysql_fetch_object($search_query))
	{
		$sitter_dateils = mysql_fetch_object(mysql_query("select * from `user_information` where user_id='".$R->user_id."'"));
		
		?>
        <div class="sitters_list"> 
         
          <div class="row">
          	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                	<div class="sitter_details_one">
                        <a href="<?=$base_path?>/sitter_details.php?sitter_id=<?=base64_encode($R->user_id)?>&conf=<?=base64_encode($R->jobapply_id)?>"> <div class="sitter_pic"> <img src="<?=$base_path?>/images/user_images/<?=$sitter_dateils->user_image?>" alt="" /> </div></a>
                      </div>
                </div>
            	<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                	<div class="row">
                     <a href="<?=$base_path?>/sitter_details.php?sitter_id=<?=base64_encode($R->user_id)?>&conf=<?=base64_encode($R->jobapply_id)?>">
                    	<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        	<div class="sitter_list_leftarea col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                	<div class="top-pad">
                                        <div class="sitter_personal_detl">
                                        <h3>Name</h3>
                                        <p>
                                        <?=$sitter_dateils->user_first_name?>
                                        <?=$sitter_dateils->user_last_name?>
                                        </p>
                                        </div>
                                        <div class="sitter_personal_detl">
                                        <h3>Bio</h3>
                                        <p>
                                        <?=$sitter_dateils->user_description?>
                                        </p>
                                        </div>
                                        <div class="sitter_personal_detl">
                                        <h3>School Affiliation</h3>
                            <p> <?=$R->user_high_school=='Yes'?$R->user_high_school_name:'NIL'?></p>
                                        </div>	
                                    </div>
                                </div>
                            	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                	<div class="top-pad">
                                        <div class="sitter_personal_detl sitter_certified">
                                        <h3><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span>Cpr Certified</h3>
                                        </div>
                                        <div class="sitter_personal_detl sitter_certified">
                                        <h3><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span>Relevance Checked</h3>
                                        </div>
                                        <div class="sitter_personal_detl sitter_certified">
                                        <h3><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span>Background Check</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </a>  
                    	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        	<?php if($already_apporve==1)
								{
								if($R->family_approval==1)
								{
								echo '<div class="sitter_right_link_one"><span class="msg-box">Selected Sitter</span></div>';
								}
								
								}
								else
								{
								?>
								<a class="txt-btn-link" href="<?=$base_path?>/confirm_sitter.php?mode=confirm&apply_id=<?=base64_encode($R->jobapply_id)?>">Confirm Job</a>
								<a class="txt-btn-link"href="<?=$base_path?>/confirm_sitter.php?mode=cancel&apply_id=<?=base64_encode($R->jobapply_id)?>">Cancel Request</a>
								<?php
								}
								?>
                        </div>
                    </div>
                </div>
            </div>
          </div>
          
          
		<!--<div class="sitter_details">
            <div class="sitter_pic"> <img src="<?=$base_path?>/images/user_images/<?=$sitter_dateils->user_image?>" alt="" /> </div>
          </div>
          <div class="sitter_details">
            <div class="sitter_personal_detl">
              <h3>Name</h3>
              <p>
                <?=$sitter_dateils->user_first_name?>
                <?=$sitter_dateils->user_last_name?>
              </p>
            </div>
            <div class="sitter_personal_detl">
              <h3>Bio</h3>
              <p>
                <?=$sitter_dateils->user_description?>
              </p>
            </div>
            <div class="sitter_personal_detl">
              <h3>Babysitting Experience</h3>
              <p>
                <?=$sitter_dateils->user_biography?>
              </p>
            </div>
          </div>
          <div class="sitter_details">
            <div class="sitter_personal_detl sitter_certified">
              <h3>Cpr Certified</h3>
            </div>
            <div class="sitter_personal_detl sitter_certified">
              <h3>Relevance Checked</h3>
            </div>
            <div class="sitter_personal_detl sitter_certified">
              <h3>Background Check</h3>
            </div>
          </div>-->
          </a> 
			

          </div>
        <?php
		
		
	}
}
?>
      </div>
      <?php
	
	}
}
?>
    </div>
  </div>
</section>
<?php include('includes/footer.php');?>
