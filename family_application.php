<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php if((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='') || $_SESSION['user_type']!='family')
			{

				header('Location:'.$base_path);

			}

if(base64_decode($_POST['user_info_submit'])=='submit_family_page')
{
	extract($_POST);

$search_query = mysql_query("select * from  user_information where user_id='".$_SESSION['user_id']."'");
if(mysql_num_rows($search_query)>0)
{

				if(is_uploaded_file($_FILES['user_image']['tmp_name'])){
					$old_img = mysql_fetch_object($search_query)->user_image;
					if(is_file('images/user_images/'.$old_img)){
						unlink('images/user_images/'.$old_img);
					}
					$user_image=time().str_replace(' ','_',$_FILES['user_image']['name']);
					move_uploaded_file($_FILES['user_image']['tmp_name'],'images/user_images/'.$user_image);

					}
					else
					{
						$user_image=mysql_fetch_object($search_query)->user_image;
					}

	$update_query = "UPDATE user_information set
					`user_first_name`= '".mysql_real_escape_string($user_first_name)."',
					`user_middle_name`= '".mysql_real_escape_string($user_middle_name)."',
					`user_last_name` = '".mysql_real_escape_string($user_last_name)."',
					`user_cell_phone`= '".mysql_real_escape_string($user_cell_phone)."',
					`user_image`= '".mysql_real_escape_string($user_image)."',
					`user_contact_email` = '".mysql_real_escape_string($user_contact_email)."',
					`user_contact_address`= '".mysql_real_escape_string($user_contact_address)."',
					`user_current_address`= '".mysql_real_escape_string($user_current_address)."',
					`is_user_agree_to_houseplans`= '".mysql_real_escape_string($is_user_agree_to_houseplans)."'
					 where user_id='".$_SESSION['user_id']."'";
}
else
{
if(is_uploaded_file($_FILES['user_image']['tmp_name'])){

					$user_image=time().str_replace(' ','_',$_FILES['user_image']['name']);
					move_uploaded_file($_FILES['user_image']['tmp_name'],'images/user_images/'.$user_image);

					}
					else
					{
						$user_image='';
					}
	$update_query = "INSERT into user_information set
					`user_id`= '".$_SESSION['user_id']."',
					`user_first_name`= '".mysql_real_escape_string($user_first_name)."',
					`user_middle_name`= '".mysql_real_escape_string($user_middle_name)."',
					`user_last_name` = '".mysql_real_escape_string($user_last_name)."',
					`user_cell_phone`= '".mysql_real_escape_string($user_cell_phone)."',
					`user_contact_email` = '".mysql_real_escape_string($user_contact_email)."',
					`user_image`= '".mysql_real_escape_string($user_image)."',
					`user_contact_address`= '".mysql_real_escape_string($user_contact_address)."',
					`is_user_agree_to_houseplans`= '".mysql_real_escape_string($is_user_agree_to_houseplans)."',
					`user_current_address`= '".mysql_real_escape_string($user_current_address)."'";
}
//echo $update_query;exit;
mysql_query($update_query);
$msg = 'Account Information Updated Successfully';
			}
$search_query = mysql_query("select i.*, m.user_email from user_information i LEFT JOIN user_management m ON m.user_id = i.user_id where i.user_id='".$_SESSION['user_id']."'");
if(mysql_num_rows($search_query)>0)
{
	$R = mysql_fetch_object($search_query);

}
			?>
<section class="sitter_app_outer">
	<div class="container">
    	<div class="sitter_app_cont clearfix">
        <?php if($msg!='')
	   {?>
       <div class="message"><?=$msg?></div>
       <?php
	   }

		 $postmsg = getPostMSG();
		 if ($postmsg)
		 {
		   $msgType = getPostMSGType();
		   echo '<div class="alert alert-' . $msgType . '">' . $postmsg . '</div>';
		 }
	   ?>
        	<div class="sitter_app_heading">
            	<h3>Family Profile</h3>
            </div>
            <form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            <?php  //echo  base64_encode('submit_family_page');?>
            <input type="hidden" name="user_info_submit" value="c3VibWl0X2ZhbWlseV9wYWdl">
        	<div class="sitter_app_left col-lg-6 col-md-6 col-sm-6 col-xs-12">
            	<div class="left_form">
                	<div class="input_outer">
                        <label>First Name</label>
                        <div class="input_area">
                            <input type="text" class="input_lrg" name="user_first_name" id="user_first_name" value="<?=$R->user_first_name?>"  />
                        </div>
                    </div>

                    <div class="input_outer">
                        <label>Last Name</label>
                        <div class="input_area">
                            <input type="text" class="input_lrg" name="user_last_name" id="user_last_name" value="<?=$R->user_last_name?>"  />
                        </div>
                    </div>
										<div class="input_outer">
				              <label>Email Address</label>
				              <div class="input_area bluetext" style="white-space: nowrap;">
				                <?=$R->user_email?><br />
				                <input type="button" value="Change Email" class="login_sub_btn" onclick="document.location='change_email.php?from=family';" />
				              </div>
				            </div>

                    <div class="input_outer textarea_outer">
                        <label>Zipcode</label>
                        <div class="input_area">
                          <select class="input_lrg" name="user_current_address" id="user_current_address"  >

                        <?php  $state_query =  mysql_query("select * from states order by state ");
						if(mysql_num_rows($state_query)>0)
						{
							while($S = mysql_fetch_object($state_query))
							{
								?>
                                 <option value="<?=$S->state_code?>" <?=$S->state_code==$R->user_current_address?'selected':''?> ><?=$S->state?></option>
                                 <?php
							}
						}
						?>
                        </select>
                        </div>
                    </div>

                    <div class="input_outer">
                	<label>Image</label>
                    <div class="input_area">

                        	<input type="file" name="user_image" id="user_image" /> <?php  if($R->user_image!=''){?><img src="<?=$base_path?>/images/user_images/<?=$R->user_image?>" height="75px"><?php }?>



                    </div>
                </div>
                </div>
            </div>
            <div class="sitter_app_right col-lg-6 col-md-6 col-sm-6 col-xs-12">
            	<div class="right_form">
                       <?php /*?><div class="input_outer">
                       <label>Cell Phone No</label>
                        <div class="input_area">
                            <input type="text" class="input_lrg" name="user_cell_phone" id="user_cell_phone" value="<?=$R->user_cell_phone?>" />
                        </div>
                    </div>
                	<div class="input_outer">
                        <label>Email Address</label>
                        <div class="input_area">
                            <input type="email" class="input_lrg" name="user_contact_email" id="user_contact_email" value="<?=$R->user_contact_email==''?$A_USER->user_email:$R->user_contact_email?>" />
                        </div>
                    </div>
                  <div class="input_outer">
                        <label>Emergency Contact</label>
                        <div class="input_area">
                            <input type="text" class="input_lrg" name="user_emergency_contact" id="user_emergency_contact" value="<?=$R->user_emergency_contact?>" />
                        </div>
                    </div><?php */?>
                    <div class="input_outer">
                       <label>Number of Children:</label>
                        <div class="input_area">
                            <input type="text" class="input_lrg" name="user_cell_phone" id="user_cell_phone" value="<?=$R->user_cell_phone?>" />
                        </div>
                    </div>
                	<div class="input_outer">
                        <label>Ages of Children:</label>
                        <div class="input_area">
                            <input type="text" class="input_lrg" name="user_contact_email" id="user_contact_email" value="<?=$R->user_contact_email?>" />
                        </div>
                    </div>

                    <div class="input_outer textarea_outer">
                        <label>Please describe your family needs/Bio:</label>
                        <div class="input_area ph-txt">
                            <textarea class="input_lrg textarea" name="user_contact_address" id="user_contact_address" placeholder="Eg. We are a busy family with 2 active kids. Our kids are 6 and 8 and enjoy being outside and playing sports. We mostly need sitters to help with after school activity drop-offs and pick-ups. We generally go out once a weekend – so need weekend sitters too."><?=$R->user_contact_address?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div style="clear:both"></div>
            <div class="sitter_app_botm">
            	 <?php /*?><div class="agree">
                	<div class="input_outer">
                     <input type="checkbox" id="is_user_agree_to_houseplans" name="is_user_agree_to_houseplans" value="1"  <?=$R->is_user_agree_to_houseplans=='1'?'checked':''?> />
                        <label for="is_user_agree_to_houseplans"><span></span>Agree To Our House Rules</label>
                    </div>
                </div>
               <div class="back_chk">
                <?php $is_payment_status = mysql_fetch_object(mysql_query("select is_payment_status from  user_management where user_id='".$_SESSION['user_id']."'"))->is_payment_status;
				if($is_payment_status==0)
				{?>
                	<a href="payment.php">Pay to get Link To Background Check</a>
                    <?php
				}
				else
				{
					?>
                    <a href="https://true-hire.com/oursitterlist/">Link To Background Check</a>
                    <?php

				}
				?>
                </div><?php */?>
            </div>
            <input type="submit" value="Update Information" class="login_sub_btn" />
            </form>
        </div>
    </div>
</section>
<?php include('includes/footer.php');?>
