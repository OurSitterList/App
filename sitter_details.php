<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php

// session check
require_once 'session_check.php';

$errorMSG = getPostMSG();
$errorMSGType = getPostMSGType();

// check for POST from booking (book a sitter) form
if ($_POST['bookForm'] == 'yes' && $_POST['calender_val'] != '')
{
	$booking 			= new Booking();
	$notification 		= new Notification();
	$booking_details = $booking->set_booking();

	if ($booking_details != false)
	{
		$response 	= $notification->send_booking_notification($booking_details);
		$response	= array('message' => $response);
		$response 	= new Response($response);
		$response::modal();
	}

	// redirect back to sitter details
	setPostMSG('Booking request has been sent to sitter.', 'success');
	header("Location: /sitter_details.php?sitter_id=" . base64_encode($_POST['sitter_main_id']));
	exit;
}

// ensure we have a sitter id
if (!isset($_REQUEST['sitter_id']) || !$_REQUEST['sitter_id'])
{
	setPostMSG('Unable to locate sitter details. Please select a sitter from the "Sitter Feed" page.');
	header('Location: /error.php');
	exit;
}

$search_query = mysql_query("select * from  user_information where user_id='" . addslashes(base64_decode($_REQUEST['sitter_id'])) . "'");
if (mysql_num_rows($search_query)>0)
{
	$R = mysql_fetch_object($search_query);
}
else
{
	setPostMSG('Unable to locate sitter details. Please select a sitter from the "Sitter Feed" page.');
	header('Location: /error.php');
	exit;
}


?>
<section class="sitter_details_outer">
	<div class="container">
		<?php

		if (isset($_REQUEST['sent']) && $_REQUEST['sent'] == '1')
		{
			echo '<div class="alert alert-success">Your message has been sent.</div>';
		}
		if ($errorMSG)
		{
			echo '<div class="alert alert-' . $errorMSGType . '">' . $errorMSG . '</div>';
		}

		?>
    	<div class="sitter_detail_inner">
        	<div class="sitter_detl_cont clearfix">
            	<div class="sitter_details_left col-lg-9 col-md-9 col-sm-12 col-xs-12">
            	<div class="sitter_detl_top">
                	<div class="sitter_left_pic">
                    	<div class="sitter_pic" style="text-align: center;">
                            <img src="<?=$base_path?>/images/<?=(($R->user_image) ? 'user_images/' . $R->user_image .'"' : 'person-blue-icon-96.png" style="padding-top: 40px; width: auto; height: auto"'); ?> alt="" />
                        </div>
                    </div>
                    <div class="sitter_right_detl">
                    	<div class="sitter_personal_detl sitr_detl_w">
                            <h3>Name</h3>
                            <p><?=$R->user_first_name?> <?=$R->user_last_name?></p>
                        </div>
                        
                        <div class="sitter_personal_detl sitr_detl_w">
                            <h3>Bio</h3>
                            <p><?=$R->user_description?></p>
                        </div>
                        <div class="sitter_personal_detl sitr_detl_w">
                            <h3>School Affiliation</h3>
                            <p> <?=$R->user_high_school=='Yes'?$R->user_high_school_name:'NIL'?></p>
                        </div>
                        <?php /*?><div class="sitter_personal_detl sitr_detl_w">
                            <h3>Babysitting Experience</h3>
                            <p><?=$R->user_biography?></p>
                        </div><?php */?>
                    </div>
                </div>
                <div class="sitter_detl_bot">
                    <a href="#" class="md-trigger" data-modal="modal-book">Book This Sitter</a>
					<a href="javascript:void(null)" class="md-trigger" data-modal="modal-directmsg">Contact Sitter</a>
                    <?php if(isset($_REQUEST['conf']) && $_REQUEST['conf']!='')
					{
						?>
                        <a href="<?=$base_path?>/confirm_sitter.php?mode=confirm&apply_id=<?=$_REQUEST['conf']?>">Confirm Job</a>
                        <?php
					}
			?>
                   
                </div>
                 <?php 
				 $search_date = mysql_query("select * from book_management where sitter_user_id='".base64_decode($_REQUEST['sitter_id'])."' and booking_status='1' and  	sitter_approval!='2'");
				 if(mysql_num_rows($search_date)>0)
				 {
					 while($S = mysql_fetch_object($search_date))
					 {
						$get_date[]=$S->booking_date;
							 
					 }
					 $get_date  =array_unique($get_date);
					 foreach ($get_date as $GD)
					 {
						 $search_free = mysql_query("select * from book_management where sitter_user_id='".base64_decode($_REQUEST['sitter_id'])."' and booking_date='".trim($GD)."' and booking_status='1' and  	sitter_approval!='2'");
						 if(mysql_num_rows($search_free)>0)
							{
						$allocation_arr	=array();
						$today_booking_array = array();
						while($S=mysql_fetch_object($search_free))
							{
							for($i = $S->start_time;$i<$S->end_time;$i++)
							{
							$allocation_arr[]= $i;
							}
				}
				
				$allocation_arr = array_unique($allocation_arr);
			$flag_arr_exist  =array();
				
				for($j=1;$j<=23;$j++)
					{
						
					if(in_array($j,$allocation_arr))
						{
						$flag_arr_exist[] = 0;	
						}
						else
						{
							$flag_arr_exist[] = 1;	
						}
					}
			
			if(!in_array('1',$flag_arr_exist))
			{
				$SD[] = "'".trim($GD)."'";
			}
					 }
					 }
					
						
						
						
					 $val = implode(',',$SD);
				 }
				 
				 else
				 {
					 $val = "'09/19/2015','09/20/2015','09/02/2015'";
				 }
			 /// echo $val;
			///	echo  "'09/19/2015','09/20/2015','09/02/2015'";
            ///  $val = "'09/04/2015',' 09/10/2015',' 09/11/2015'";?>
            <div class="sitter_details_bottom">
            <ul>
          
                                    <?php if($R->cpr_approve==1)
									{?>
                                       <li><a href="#"><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Cpr Certified</a></li>
                                        <?php
									}
									?>
                                    <?php if($R->newborn_approve==1)
									{?>
                                        <li><a href="#"><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Reference Checked</a></li>
                                          <?php
									}
									?>
                                  
                                        <li><a href="#"><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span>Background Check</a></li>
                                       
                                   
                                   
                 
                    <?=$R->user_newborn_cpr_training=='Yes'?'<li><a href="#"><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span>Infant Newborn CPR Certified</a></li>':''?>
                    <?=$R->user_food_allergies=='Yes'?'<li><a href="#"><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Experience with child food allergies</a></li>':''?>
                    <?=$R->user_overnight=='Yes'?'<li><a href="#"><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Willing to do overnight babysitting</a></li>':''?>
                    <?=$R->user_travel=='Yes'?'<li><a href="#"><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Willing to travel with families</a></li>':''?>
                    <?=$R->user_permanent=='Yes'?'<li><a href="#"><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Available for semi-permanent/permanent placement</a></li>':''?>
                    <?=$R->user_newborn_exp=='Yes'?'<li><a href="#"><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Newborn experience</a></li>':''?>
                    <?=$R->user_sick_kids=='Yes'?'<li><a href="#"><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Willing to care for sick kids</a></li>':''?> 
                   
                   
                </ul>
                </div>
            </div>
                <div class="sitter_details_right col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="calender_bg">
                        <div class="calender_inner">
                            <div class="cal_head">
                                <h3>Weekly Schedule</h3>
                            </div>
                            <div class="cal_days">
                            <?php 
							$user_available = "";
							if($R->user_available_mon_start != "") {
								$user_available_s = explode(',',$R->user_available_mon_start);
								$user_available_e = explode(',',$R->user_available_mon_end);
								echo '<div class="row"><div class="col-xs-12 col-sm-3"><p><span>Mon</span></p></div><div class="col-xs-12 col-sm-9"><p>';
								
								for($i = 0; $i<=count($user_available_s) - 1; $i++) {
									echo date("h:i a",mktime($user_available_s[$i],0,0,0,0,0)).' - '.date("h:i a",mktime($user_available_e[$i],0,0,0,0,0)).'<br>';
								}
								echo '</p></div></div>';
							}
							else {
								echo '<div class="row"><div class="col-xs-12 col-sm-3"><p><span>Mon</span></p></div><div class="col-xs-12 col-sm-9"><p>Not Available</div></div>';
							}

							if($R->user_available_tue_start != "") {
								$user_available_s = explode(',',$R->user_available_tue_start);
								$user_available_e = explode(',',$R->user_available_tue_end);
								echo '<div class="row"><div class="col-xs-12 col-sm-3"><p><span>Tue</span></p></div><div class="col-xs-12 col-sm-9"><p>';
								
								for($i = 0; $i<=count($user_available_s) - 1; $i++) {
									echo date("h:i a",mktime($user_available_s[$i],0,0,0,0,0)).' - '.date("h:i a",mktime($user_available_e[$i],0,0,0,0,0)).'<br>';
								}
								echo '</p></div></div>';
							}
							else {
								echo '<div class="row"><div class="col-xs-12 col-sm-3"><p><span>Tue</span></p></div><div class="col-xs-12 col-sm-9"><p>Not Available</div></div>';
							}
							

							if($R->user_available_wed_start != "") {
								$user_available_s = explode(',',$R->user_available_wed_start);
								$user_available_e = explode(',',$R->user_available_wed_end);
								echo '<div class="row"><div class="col-xs-12 col-sm-3"><p><span>Wed</span></p></div><div class="col-xs-12 col-sm-9"><p>';
								
								for($i = 0; $i<=count($user_available_s) - 1; $i++) {
									echo date("h:i a",mktime($user_available_s[$i],0,0,0,0,0)).' - '.date("h:i a",mktime($user_available_e[$i],0,0,0,0,0)).'<br>';
								}
								echo '</p></div></div>';
							}
							else {
								echo '<div class="row"><div class="col-xs-12 col-sm-3"><p><span>Wed</span></p></div><div class="col-xs-12 col-sm-9"><p>Not Available</div></div>';
							}

							if($R->user_available_thu_start != "") {
								$user_available_s = explode(',',$R->user_available_thu_start);
								$user_available_e = explode(',',$R->user_available_thu_end);
								echo '<div class="row"><div class="col-xs-12 col-sm-3"><p><span>Thu</span></p></div><div class="col-xs-12 col-sm-9"><p>';
								
								for($i = 0; $i<=count($user_available_s) - 1; $i++) {
									echo date("h:i a",mktime($user_available_s[$i],0,0,0,0,0)).' - '.date("h:i a",mktime($user_available_e[$i],0,0,0,0,0)).'<br>';
								}
								echo '</p></div></div>';
							}
							else {
								echo '<div class="row"><div class="col-xs-12 col-sm-3"><p><span>Thu</span></p></div><div class="col-xs-12 col-sm-9"><p>Not Available</div></div>';
							}

							if($R->user_available_fri_start != "") {
								$user_available_s = explode(',',$R->user_available_fri_start);
								$user_available_e = explode(',',$R->user_available_fri_end);
								echo '<div class="row"><div class="col-xs-12 col-sm-3"><p><span>Fri</span></p></div><div class="col-xs-12 col-sm-9"><p>';
								
								for($i = 0; $i<=count($user_available_s) - 1; $i++) {
									echo date("h:i a",mktime($user_available_s[$i],0,0,0,0,0)).' - '.date("h:i a",mktime($user_available_e[$i],0,0,0,0,0)).'<br>';
								}
								echo '</p></div></div>';
							}
							else {
								echo '<div class="row"><div class="col-xs-12 col-sm-3"><p><span>Fri</span></p></div><div class="col-xs-12 col-sm-9"><p>Not Available</div></div>';
							}

							if($R->user_available_sat_start != "") {
								$user_available_s = explode(',',$R->user_available_sat_start);
								$user_available_e = explode(',',$R->user_available_sat_end);
								echo '<div class="row"><div class="col-xs-12 col-sm-3"><p><span>Sat</span></p></div><div class="col-xs-12 col-sm-9"><p>';
								
								for($i = 0; $i<=count($user_available_s) - 1; $i++) {
									echo date("h:i a",mktime($user_available_s[$i],0,0,0,0,0)).' - '.date("h:i a",mktime($user_available_e[$i],0,0,0,0,0)).'<br>';
								}
								echo '</p></div></div>';
							}
							else {
								echo '<div class="row"><div class="col-xs-12 col-sm-3"><p><span>Sat</span></p></div><div class="col-xs-12 col-sm-9"><p>Not Available</div></div>';
							}

							if($R->user_available_sun_start != "") {
								$user_available_s = explode(',',$R->user_available_sun_start);
								$user_available_e = explode(',',$R->user_available_sun_end);
								echo '<div class="row"><div class="col-xs-12 col-sm-3"><p><span>Sun</span></p></div><div class="col-xs-12 col-sm-9"><p>';
								
								for($i = 0; $i<=count($user_available_s) - 1; $i++) {
									echo date("h:i a",mktime($user_available_s[$i],0,0,0,0,0)).' - '.date("h:i a",mktime($user_available_e[$i],0,0,0,0,0)).'<br>';
								}
								echo '</p></div></div>';
							}
							else {
								echo '<div class="row"><div class="col-xs-12 col-sm-3"><p><span>Sun</span></p></div><div class="col-xs-12 col-sm-9"><p>Not Available</div></div>';
							}
							?>
                            <!--
                                <p><span>Mon</span> <?=date("h:i a",mktime($R->user_available_mon_start,0,0,0,0,0)).' - '.date("h:i a",mktime($R->user_available_mon_end,0,0,0,0,0))?></p>
                                <p><span>Tues</span><?=date("h:i a",mktime($R->user_available_tue_start,0,0,0,0,0)).' - '.date("h:i a",mktime($R->user_available_tue_end,0,0,0,0,0))?></p>
                                <p><span>Wed</span><?=date("h:i a",mktime($R->user_available_wed_start,0,0,0,0,0)).' - '.date("h:i a",mktime($R->user_available_wed_end,0,0,0,0,0))?></p>
                                <p><span>Thurs</span><?=date("h:i a",mktime($R->user_available_thu_start,0,0,0,0,0)).' - '.date("h:i a",mktime($R->user_available_thu_end,0,0,0,0,0))?></p>
                                <p><span>Fri</span><?=date("h:i a",mktime($R->user_available_fri_start,0,0,0,0,0)).' - '.date("h:i a",mktime($R->user_available_fri_end,0,0,0,0,0))?></p>
                                <p><span>Sat</span><?=date("h:i a",mktime($R->user_available_sat_start,0,0,0,0,0)).' - '.date("h:i a",mktime($R->user_available_sat_end,0,0,0,0,0))?></p>
                                <p><span>Sun</span><?=date("h:i a",mktime($R->user_available_sun_start,0,0,0,0,0)).' - '.date("h:i a",mktime($R->user_available_sun_end,0,0,0,0,0))?></p>
                             -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sitter_details_bottom">
            <div class="sitter_app_heading">
            	<h3>Who's Booked Me</h3>
            </div> 
             <div class="row">
              
  <?php
  $search_query_sql = mysql_query("select distinct family_user_id from book_management where sitter_user_id='".base64_decode($_REQUEST['sitter_id'])."' and booking_status='1'");
//echo "select distinct family_user_id from book_management where sitter_user_id='".$_SESSION['user_id']."' and booking_status='1'";			
if(mysql_num_rows($search_query_sql)>0)
{
	while($R = mysql_fetch_object($search_query_sql))
	{
		$sitter_dateils = mysql_fetch_object(mysql_query("select * from `user_information` where user_id='".$R->family_user_id."'"));
		?>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                	<div class="sitter_details_one">
                        <div class="sitter_pic"> <img src="<?=$base_path?>/images/user_images/<?=$sitter_dateils->user_image?>" alt="" /> </div>
                      </div>
                      </div>
                      <?php
	}
}
?>
              </div>
             
             
             
                
            </div>
        </div>
    </div>
</section>
<?php include('includes/footer.php');?>