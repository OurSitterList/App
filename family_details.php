<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php if(!isset($_SESSION['user_id']) && $_SESSION['user_id']=='')
			{
				
				header('Location:/');
				
			}
			$search_query = mysql_query("select * from  user_information where user_id='".$_SESSION['user_id']."'");
if(mysql_num_rows($search_query)>0)
{
	$R = mysql_fetch_object($search_query);
	
}
else
{
	header('Location:/');
}


		?>
<section class="sitter_details_outer">
	<div class="container">
    	<div class="sitter_detail_inner">
        	<div class="sitter_detl_cont clearfix">
            	<div class="sitter_details_left col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <?php
							$search_query = mysql_query("select * from user_information ui 
left join user_management um ON ui.user_id = um.user_id
where ui.user_id='".base64_decode($_REQUEST['family_user_id'])."' AND um.user_type='family' AND user_status=1");

if(mysql_num_rows($search_query)>0) : 
	$R = mysql_fetch_object($search_query);
	
?>
            	<div class="sitter_detl_top">
                	<div class="sitter_left_pic">
                    	<div class="sitter_pic">
                            <img src="images/user_images/<?=$R->user_image?>" alt="" />
                        </div>
                    </div>
                    <div class="sitter_right_detl">
                    	<div class="sitter_personal_detl sitr_detl_w">
                            <h3>Name</h3>
                            <p><?=$R->user_first_name?> <?=$R->user_last_name?></p>
                        </div>
                        <div class="sitter_personal_detl sitr_detl_w">
                            <h3>No Of Children</h3>
                            <p><?=$R->user_cell_phone?></p>
                        </div>
                        <div class="sitter_personal_detl sitr_detl_w">
                            <h3>Ages Of Children</h3>
                            <p><?=$R->user_contact_email?></p>
                        </div>
                        <div class="sitter_personal_detl sitr_detl_w">
                            <h3>Zip Code</h3>
                            <p><?=$R->user_current_address?></p>
                        </div>
                        <div class="sitter_personal_detl sitr_detl_w">
                            <h3>Bio</h3>
                            <p><?=$R->user_contact_address?></p>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <p>Family information cannot be found.</p>
                <?php endif; ?>
                <!--<div class="sitter_detl_bot">
                	<a href="#">Review & Rating</a>
                    <a href="#">Book This Sitter</a>
                </div>-->
            </div>
                <div class="sitter_details_right col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <!--<div class="calender_bg">
                        <div class="calender_inner">
                            <div class="cal_head">
                                <h3>Weekly Schedule</h3>
                            </div>
                            <div class="cal_days">
                                <p>Mon</p>
                                <p>Tues</p>
                                <p>Wed</p>
                                <p>Thurs</p>
                                <p>Fri</p>
                                <p>Sat</p>
                                <p>Sun</p>
                            </div>
                        </div>
                    </div>-->
                </div>
            </div>
            <!--<div class="sitter_details_bottom">
                <ul>
                    <li><a href="#">Cpr Certified</a></li>
                    <li><a href="#">Relevance Checked</a></li>
                    <li><a href="#">Background Check</a></li>
                </ul>
            </div>-->
        </div>
    </div>
</section>
<?php include('includes/footer.php');?>