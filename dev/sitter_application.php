<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php if((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='') || $_SESSION['user_type']!='sitter')
			{
				
				header('Location:'.$base_path);
				
			}
		
if(base64_decode($_POST['user_info_submit'])=='submit_sitter_page')
{
	extract($_POST);

	$mon_s = array_filter(array($user_available_mon_start1,$user_available_mon_start2,$user_available_mon_start3));
	$mon_e = array_filter(array($user_available_mon_end1,$user_available_mon_end2,$user_available_mon_end3));
	$mon_s = join(',', $mon_s);
	$mon_e = join(',', $mon_e);
		
	$tue_s = array_filter(array($user_available_tue_start1,$user_available_tue_start2,$user_available_tue_start3));
	$tue_e = array_filter(array($user_available_tue_end1,$user_available_tue_end2,$user_available_tue_end3));
	$tue_s = join(',', $tue_s);
	$tue_e = join(',', $tue_e);
	
	$wed_s = array_filter(array($user_available_wed_start1,$user_available_wed_start2,$user_available_wed_start3));
	$wed_e = array_filter(array($user_available_wed_end1,$user_available_wed_end2,$user_available_wed_end3));
	$wed_s = join(',', $wed_s);
	$wed_e = join(',', $wed_e);
	
	$thu_s = array_filter(array($user_available_thu_start1,$user_available_thu_start2,$user_available_thu_start3));
	$thu_e = array_filter(array($user_available_thu_end1,$user_available_thu_end2,$user_available_thu_end3));
	$thu_s = join(',', $thu_s);
	$thu_e = join(',', $thu_e);
	
	$fri_s = array_filter(array($user_available_fri_start1,$user_available_fri_start2,$user_available_fri_start3));
	$fri_e = array_filter(array($user_available_fri_end1,$user_available_fri_end2,$user_available_fri_end3));
	$fri_s = join(',', $fri_s);
	$fri_e = join(',', $fri_e);
	
	$sat_s = array_filter(array($user_available_sat_start1,$user_available_sat_start2,$user_available_sat_start3));
	$sat_e = array_filter(array($user_available_sat_end1,$user_available_sat_end2,$user_available_sat_end3));
	$sat_s = join(',', $sat_s);
	$sat_e = join(',', $sat_e);
	
	$sun_s = array_filter(array($user_available_sun_start1,$user_available_sun_start2,$user_available_sun_start3));
	$sun_e = array_filter(array($user_available_sun_end1,$user_available_sun_end2,$user_available_sun_end3));
	$sun_s = join(',', $sun_s);
	$sun_e = join(',', $sun_e);	
	
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
					`user_last_name` = '".mysql_real_escape_string($user_last_name)."',
					`user_driver_license`= '".mysql_real_escape_string($user_driver_license)."',
					`user_firstaid_training`= '".mysql_real_escape_string($user_firstaid_training)."',
					`user_date_of_certification`= '".mysql_real_escape_string($user_date_of_certification)."',
					`is_user_willing_to_certified`= '".mysql_real_escape_string($is_user_willing_to_certified)."',
					`user_cpr_training`= '".mysql_real_escape_string($user_cpr_training)."',
					`user_newborn_cpr_training`= '".mysql_real_escape_string($user_newborn_cpr_training)."',
					`user_food_allergies`= '".mysql_real_escape_string($user_food_allergies)."',
					`user_overnight`= '".mysql_real_escape_string($user_overnight)."',
					`user_travel`= '".mysql_real_escape_string($user_travel)."',
					`user_permanent`= '".mysql_real_escape_string($user_permanent)."',
					`user_newborn_exp`= '".mysql_real_escape_string($user_newborn_exp)."',
					`user_sick_kids`= '".mysql_real_escape_string($user_sick_kids)."',
					`user_date_of_certification_cpr` = '".mysql_real_escape_string($user_date_of_certification_cpr)."',
					`is_user_willing_to_certified_cpr`= '".mysql_real_escape_string($is_user_willing_to_certified_cpr)."',
					`user_cell_phone`= '".mysql_real_escape_string($user_cell_phone)."',
					`user_contact_email` = '".mysql_real_escape_string($user_contact_email)."',
					`user_emergency_contact`= '".mysql_real_escape_string($user_emergency_contact)."',
					`location_code`= '".mysql_real_escape_string($location_code)."',
					`is_user_agree_to_houseplans`= '".mysql_real_escape_string($is_user_agree_to_houseplans)."',
					`user_age`= '".mysql_real_escape_string($user_age)."',
					`user_school_affliation`= '".mysql_real_escape_string($user_school_affliation)."',
					`user_image`= '".mysql_real_escape_string($user_image)."',
					`user_biography`= '".mysql_real_escape_string($user_biography)."',
					`user_description`= '".mysql_real_escape_string($user_description)."',
					`user_high_school`= '".mysql_real_escape_string($user_high_school)."',
					`user_high_school_name`= '".mysql_real_escape_string($user_high_school_name)."',
					`user_college`= '".mysql_real_escape_string($user_college)."',
					`user_college_name`= '".mysql_real_escape_string($user_college_name)."',
					`user_ref1_name`= '".mysql_real_escape_string($user_ref1_name)."',
					`user_ref1_role`= '".mysql_real_escape_string($user_ref1_role)."',
					`user_ref1_age`= '".mysql_real_escape_string($user_ref1_age)."',
					`user_ref1_length`= '".mysql_real_escape_string($user_ref1_length)."',
					`user_ref2_name`= '".mysql_real_escape_string($user_ref2_name)."',
					`user_ref2_role`= '".mysql_real_escape_string($user_ref2_role)."',
					`user_ref2_age`= '".mysql_real_escape_string($user_ref2_age)."',
					`user_ref2_length`= '".mysql_real_escape_string($user_ref2_length)."',
					`user_available_mon_start`= '".mysql_real_escape_string($mon_s)."',
					`user_available_tue_start`= '".mysql_real_escape_string($tue_s)."',
					`user_available_wed_start`= '".mysql_real_escape_string($wed_s)."',
					`user_available_thu_start`= '".mysql_real_escape_string($thu_s)."',
					`user_available_fri_start`= '".mysql_real_escape_string($fri_s)."',
					`user_available_sat_start`= '".mysql_real_escape_string($sat_s)."',
					`user_available_sun_start`= '".mysql_real_escape_string($sun_s)."',
					`user_available_mon_end`= '".mysql_real_escape_string($mon_e)."',
					`user_available_tue_end`= '".mysql_real_escape_string($tue_e)."',
					`user_available_wed_end`= '".mysql_real_escape_string($wed_e)."',
					`user_available_thu_end`= '".mysql_real_escape_string($thu_e)."',
					`user_available_fri_end`= '".mysql_real_escape_string($fri_e)."',
					`user_available_sat_end`= '".mysql_real_escape_string($sat_e)."',
					`user_available_sun_end`= '".mysql_real_escape_string($sun_e)."',
					`user_babysitting_exp`= '".mysql_real_escape_string($user_babysitting_exp)."'
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
					`user_last_name` = '".mysql_real_escape_string($user_last_name)."',
					`user_driver_license`= '".mysql_real_escape_string($user_driver_license)."',
					`user_firstaid_training`= '".mysql_real_escape_string($user_firstaid_training)."',
					`user_date_of_certification`= '".mysql_real_escape_string($user_date_of_certification)."',
					`is_user_willing_to_certified`= '".mysql_real_escape_string($is_user_willing_to_certified)."',
					`user_cpr_training`= '".mysql_real_escape_string($user_cpr_training)."',
					`user_newborn_cpr_training`= '".mysql_real_escape_string($user_newborn_cpr_training)."',
					`user_food_allergies`= '".mysql_real_escape_string($user_food_allergies)."',
					`user_overnight`= '".mysql_real_escape_string($user_overnight)."',
					`user_travel`= '".mysql_real_escape_string($user_travel)."',
					`user_permanent`= '".mysql_real_escape_string($user_permanent)."',
					`user_newborn_exp`= '".mysql_real_escape_string($user_newborn_exp)."',
					`user_sick_kids`= '".mysql_real_escape_string($user_sick_kids)."',
					`user_date_of_certification_cpr` = '".mysql_real_escape_string($user_date_of_certification_cpr)."',
					`is_user_willing_to_certified_cpr`= '".mysql_real_escape_string($is_user_willing_to_certified_cpr)."',
					`user_cell_phone`= '".mysql_real_escape_string($user_cell_phone)."',
					`user_contact_email` = '".mysql_real_escape_string($user_contact_email)."',
					`user_emergency_contact`= '".mysql_real_escape_string($user_emergency_contact)."',
					`location_code`= '".mysql_real_escape_string($location_code)."',
					`is_user_agree_to_houseplans`= '".mysql_real_escape_string($is_user_agree_to_houseplans)."',
					`user_age`= '".mysql_real_escape_string($user_age)."',
					`user_school_affliation`= '".mysql_real_escape_string($user_school_affliation)."',
					`user_image`= '".mysql_real_escape_string($user_image)."',
					`user_biography`= '".mysql_real_escape_string($user_biography)."',
					`user_description`= '".mysql_real_escape_string($user_description)."',
					`user_high_school`= '".mysql_real_escape_string($user_high_school)."',
					`user_high_school_name`= '".mysql_real_escape_string($user_high_school_name)."',
					`user_college`= '".mysql_real_escape_string($user_college)."',
					`user_college_name`= '".mysql_real_escape_string($user_college_name)."',
					`user_ref1_name`= '".mysql_real_escape_string($user_ref1_name)."',
					`user_ref1_role`= '".mysql_real_escape_string($user_ref1_role)."',
					`user_ref1_age`= '".mysql_real_escape_string($user_ref1_age)."',
					`user_ref1_length`= '".mysql_real_escape_string($user_ref1_length)."',
					`user_ref2_name`= '".mysql_real_escape_string($user_ref2_name)."',
					`user_ref2_role`= '".mysql_real_escape_string($user_ref2_role)."',
					`user_ref2_age`= '".mysql_real_escape_string($user_ref2_age)."',
					`user_ref2_length`= '".mysql_real_escape_string($user_ref2_length)."',
					`user_available_mon_start`= '".mysql_real_escape_string($mon_s)."',
					`user_available_tue_start`= '".mysql_real_escape_string($tue_s)."',
					`user_available_wed_start`= '".mysql_real_escape_string($wed_s)."',
					`user_available_thu_start`= '".mysql_real_escape_string($thu_s)."',
					`user_available_fri_start`= '".mysql_real_escape_string($fri_s)."',
					`user_available_sat_start`= '".mysql_real_escape_string($sat_s)."',
					`user_available_sun_start`= '".mysql_real_escape_string($sun_s)."',
					`user_available_mon_end`= '".mysql_real_escape_string($mon_e)."',
					`user_available_tue_end`= '".mysql_real_escape_string($tue_e)."',
					`user_available_wed_end`= '".mysql_real_escape_string($wed_e)."',
					`user_available_thu_end`= '".mysql_real_escape_string($thu_e)."',
					`user_available_fri_end`= '".mysql_real_escape_string($fri_e)."',
					`user_available_sat_end`= '".mysql_real_escape_string($sat_e)."',
					`user_available_sun_end`= '".mysql_real_escape_string($sun_e)."',
					`user_babysitting_exp`= '".mysql_real_escape_string($user_babysitting_exp)."'";
}
//echo $update_query;exit;
mysql_query($update_query);
$msg = 'Account Information Updated Successfully';
			}
$search_query = mysql_query("select * from  user_information where user_id='".$_SESSION['user_id']."'");
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
      <div class="message">
        <?=$msg?>
      </div>
      <?php  
	   }
	   ?>
      <div class="sitter_app_heading">
        <h3>Sitter Profile</h3>
      </div>
      <form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
        <?php  //echo  base64_encode('submit_sitter_page');?>
        <input type="hidden" name="user_info_submit" value="c3VibWl0X3NpdHRlcl9wYWdl">
        <div class="sitter_app_left col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="left_form">
            <div class="input_outer">
              <label>First Name</label>
              <div class="input_area">
                <input type="text" class="input_lrg" name="user_first_name" id="user_first_name" value="<?=$R->user_first_name?>" />
              </div>
            </div>
            <div class="input_outer">
              <label>Last Name</label>
              <div class="input_area">
                <input type="text" class="input_lrg" name="user_last_name" id="user_last_name" value="<?=$R->user_last_name?>"  />
              </div>
            </div>
            <?php /*?><div class="input_outer">
                	<label>Driver License</label>
                    <div class="input_area">
                    	<div class="chkbox">
                        	<input type="radio" name="user_driver_license" id="user_driver_license_yes" value="Yes" <?=$R->user_driver_license=='Yes'?'checked':''?> />
							<label for="user_driver_license_yes"><span></span>Yes</label>
                        </div>
                        <div class="chkbox">
                        	<input type="radio" name="user_driver_license" id="user_driver_license_no" value="No"  <?=$R->user_driver_license=='No'?'checked':''?> />
							<label for="user_driver_license_no"><span></span>No</label>
                        </div>
                    </div>
                </div><?php */?>
            <div class="input_outer">
              <label>Firstaid Training</label>
              <div class="input_area">
                <div class="chkbox">
                  <input type="radio" name="user_firstaid_training" id="user_firstaid_training_yes" value="Yes" <?=$R->user_firstaid_training=='Yes'?'checked':''?>  />
                  <label for="user_firstaid_training_yes"><span></span>Yes</label>
                </div>
                <div class="chkbox">
                  <input type="radio" name="user_firstaid_training" id="user_firstaid_training_no" value="No" <?=$R->user_firstaid_training=='No'?'checked':''?> />
                  <label for="user_firstaid_training_no"><span></span>No</label>
                </div>
              </div>
              <div class="sub_cat">
                <div class="input_outer">
                  <label>Date of Certification</label>
                  <div class="input_area">
                    <input type="text" class="input_lrg" name="user_date_of_certification" id="user_date_of_certification"  value="<?=$R->user_date_of_certification?>" />
                  </div>
                </div>
                <?php /*?><div class="input_outer">
                                <label>Willing To Be Certified</label>
                                <div class="input_area">
                                    <input type="checkbox" class="input_lrg" name="is_user_willing_to_certified" id="is_user_willing_to_certified" value="1" <?=$R->is_user_willing_to_certified=='1'?'checked':''?>  />
                                    <label for="is_user_willing_to_certified"><span></span>Yes</label>
                                </div>
                            </div><?php */?>
              </div>
            </div>
            <div class="input_outer">
              <label>Cpr Training</label>
              <div class="input_area">
                <div class="chkbox">
                  <input type="radio" name="user_cpr_training" id="user_cpr_training_yes" value="Yes"   <?=$R->user_cpr_training=='Yes'?'checked':''?> />
                  <label for="user_cpr_training_yes"><span></span>Yes</label>
                </div>
                <div class="chkbox">
                  <input type="radio" name="user_cpr_training" id="user_cpr_training_no" value="No"  <?=$R->user_cpr_training=='No'?'checked':''?>  />
                  <label for="user_cpr_training_no"><span></span>No</label>
                </div>
              </div>
              <div class="sub_cat">
                <div class="input_outer">
                  <label>Date of Certification</label>
                  <div class="input_area">
                    <input type="text" class="input_lrg" name="user_date_of_certification_cpr" id="user_date_of_certification_cpr" value="<?=$R->user_date_of_certification_cpr?>" />
                  </div>
                </div>
                <?php /*?><div class="input_outer">
                            <label>Willing To Be Certified</label>
                            <div class="input_area">
                                <input type="checkbox" class="input_lrg" name="is_user_willing_to_certified_cpr" id="is_user_willing_to_certified_cpr" value="1" <?=$R->is_user_willing_to_certified_cpr=='1'?'checked':''?> />
                                <label for="is_user_willing_to_certified_cpr"><span></span>Yes</label>
                            </div>
                        </div><?php */?>
              </div>
            </div>
            <div class="input_outer">
              <label>Infant Newborn CPR Certified</label>
              <div class="input_area">
                <div class="chkbox">
                  <input type="radio" name="user_newborn_cpr_training" id="user_newborn_cpr_training_yes" value="Yes" <?=$R->user_newborn_cpr_training=='Yes'?'checked':''?> />
                  <label for="user_newborn_cpr_training_yes"><span></span>Yes</label>
                </div>
                <div class="chkbox">
                  <input type="radio" name="user_newborn_cpr_training" id="user_newborn_cpr_training_no" value="No"  <?=$R->user_newborn_cpr_training=='No'?'checked':''?> />
                  <label for="user_newborn_cpr_training_no"><span></span>No</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="sitter_app_right col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="right_form">
            <div class="input_outer">
              <label>Experience with child food allergies</label>
              <div class="input_area">
                <div class="chkbox">
                  <input type="radio" name="user_food_allergies" id="user_food_allergies_yes" value="Yes" <?=$R->user_food_allergies=='Yes'?'checked':''?> />
                  <label for="user_food_allergies_yes"><span></span>Yes</label>
                </div>
                <div class="chkbox">
                  <input type="radio" name="user_food_allergies" id="user_food_allergies_no" value="No"  <?=$R->user_food_allergies=='No'?'checked':''?> />
                  <label for="user_food_allergies_no"><span></span>No</label>
                </div>
              </div>
            </div>
            <div class="input_outer">
              <label>Willing to do overnight babysitting</label>
              <div class="input_area">
                <div class="chkbox">
                  <input type="radio" name="user_overnight" id="user_overnight_yes" value="Yes" <?=$R->user_overnight=='Yes'?'checked':''?> />
                  <label for="user_overnight_yes"><span></span>Yes</label>
                </div>
                <div class="chkbox">
                  <input type="radio" name="user_overnight" id="user_overnight_no" value="No"  <?=$R->user_overnight=='No'?'checked':''?> />
                  <label for="user_overnight_no"><span></span>No</label>
                </div>
              </div>
            </div>
            <div class="input_outer">
              <label>Willing to travel with families</label>
              <div class="input_area">
                <div class="chkbox">
                  <input type="radio" name="user_travel" id="user_travel_yes" value="Yes" <?=$R->user_travel=='Yes'?'checked':''?> />
                  <label for="user_travel_yes"><span></span>Yes</label>
                </div>
                <div class="chkbox">
                  <input type="radio" name="user_travel" id="user_travel_no" value="No"  <?=$R->user_travel=='No'?'checked':''?> />
                  <label for="user_travel_no"><span></span>No</label>
                </div>
              </div>
            </div>
            <div class="input_outer">
              <label>Available for semi-permanent/permanent placement</label>
              <div class="input_area">
                <div class="chkbox">
                  <input type="radio" name="user_permanent" id="user_permanent_yes" value="Yes" <?=$R->user_permanent=='Yes'?'checked':''?> />
                  <label for="user_permanent_yes"><span></span>Yes</label>
                </div>
                <div class="chkbox">
                  <input type="radio" name="user_permanent" id="user_permanent_no" value="No"  <?=$R->user_permanent=='No'?'checked':''?> />
                  <label for="user_permanent_no"><span></span>No</label>
                </div>
              </div>
            </div>
            <div class="input_outer">
              <label>Newborn experience</label>
              <div class="input_area">
                <div class="chkbox">
                  <input type="radio" name="user_newborn_exp" id="user_newborn_exp_yes" value="Yes" <?=$R->user_newborn_exp=='Yes'?'checked':''?> />
                  <label for="user_newborn_exp_yes"><span></span>Yes</label>
                </div>
                <div class="chkbox">
                  <input type="radio" name="user_newborn_exp" id="user_newborn_exp_no" value="No"  <?=$R->user_newborn_exp=='No'?'checked':''?> />
                  <label for="user_newborn_exp_no"><span></span>No</label>
                </div>
              </div>
            </div>
            <div class="input_outer">
              <label>Willing to care for sick kids</label>
              <div class="input_area">
                <div class="chkbox">
                  <input type="radio" name="user_sick_kids" id="user_sick_kids_yes" value="Yes" <?=$R->user_sick_kids=='Yes'?'checked':''?> />
                  <label for="user_sick_kids_yes"><span></span>Yes</label>
                </div>
                <div class="chkbox">
                  <input type="radio" name="user_sick_kids" id="user_sick_kids_no" value="No"  <?=$R->user_sick_kids=='No'?'checked':''?> />
                  <label for="user_sick_kids_no"><span></span>No</label>
                </div>
              </div>
            </div>
            <div class="input_outer textarea_outer">
              <label>Please describe yourself/Bio:</label>
              <div class="input_area">
                <textarea class="input_lrg textarea" name="user_description" id="user_description"><?=$R->user_description?>
</textarea>
              </div>
            </div>
          </div>
        </div>
        <div style="clear:both;"></div>
        <div class="sitter_app_heading">
          <h3>Contact information And Education</h3>
        </div>
        <div class="sitter_app_left col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="left_form">
            <?php /*?>  <div class="input_outer">
                        <label>Cell Phone No</label>
                        <div class="input_area">
                            <input type="text" class="input_lrg" name="user_cell_phone" id="user_cell_phone" value="<?=$R->user_cell_phone?>"  />
                        </div>
                    </div>
                	<div class="input_outer">
                	<label>Email Address</label>
                    <div class="input_area">
                    	<input type="email" class="input_lrg" name="user_contact_email" id="user_contact_email" value="<?=$R->user_contact_email==''?$A_USER->user_email:$R->user_contact_email?>"  />
                    </div>
                </div>
                	<div class="input_outer">
                	<label>Emergency Contact</label>
                    <div class="input_area">
                    	<input type="text" class="input_lrg" name="user_emergency_contact" id="user_emergency_contact" value="<?=$R->user_emergency_contact?>"  />
                    </div>
                </div><?php */?>
            <div class="input_outer">
              <label>Zipcode</label>
              <div class="input_area">
                <select class="input_lrg" name="location_code" id="location_code"  >
                  <?php  $state_query =  mysql_query("select * from states order by state ");
						if(mysql_num_rows($state_query)>0)
						{
							while($S = mysql_fetch_object($state_query))
							{
								?>
                  <option value="<?=$S->state_code?>" <?=$S->state_code==$R->location_code?'selected':''?> >
                  <?=$S->state?>
                  </option>
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
                <input type="file" name="user_image" id="user_image" />
                <?php  if($R->user_image!=''){?>
                <img src="<?=$base_path?>/images/user_images/<?=$R->user_image?>" height="75px">
                <?php }?>
              </div>
            </div>
          </div>
        </div>
        <div class="sitter_app_right col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="right_form">
            <div class="input_outer">
              <label>High School</label>
              <div class="input_area">
                <div class="chkbox">
                  <input type="radio" name="user_high_school" id="user_high_school_yes" value="Yes"   <?=$R->user_high_school=='Yes'?'checked':''?> />
                  <label for="user_high_school_yes"><span></span>Yes</label>
                </div>
                <div class="chkbox">
                  <input type="radio" name="user_high_school" id="user_high_school_no" value="No"  <?=$R->user_high_school=='No'?'checked':''?>  />
                  <label for="user_high_school_no"><span></span>No</label>
                </div>
              </div>
              <div class="sub_cat">
                <div class="input_outer">
                  <label>If yes, what high school</label>
                  <div class="input_area">
                    <input type="text" class="input_lrg" name="user_high_school_name" id="user_high_school_name" value="<?=$R->user_high_school_name?>" />
                  </div>
                </div>
              </div>
            </div>
            <div class="input_outer">
              <label>College</label>
              <div class="input_area">
                <div class="chkbox">
                  <input type="radio" name="user_college" id="user_college_yes" value="Yes"   <?=$R->user_college=='Yes'?'checked':''?> />
                  <label for="user_college_yes"><span></span>Yes</label>
                </div>
                <div class="chkbox">
                  <input type="radio" name="user_college" id="user_college_no" value="No"  <?=$R->user_college=='No'?'checked':''?>  />
                  <label for="user_college_no"><span></span>No</label>
                </div>
              </div>
              <div class="sub_cat">
                <div class="input_outer">
                  <label>If yes, what college</label>
                  <div class="input_area">
                    <input type="text" class="input_lrg" name="user_college_name" id="user_college_name" value="<?=$R->user_college_name?>" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php /*?> <div style="clear:both;"></div>
         <div class="sitter_app_heading">
            	<h3>References/Experience</h3>
            </div>
            <div class="sitter_app_left col-lg-6 col-md-6 col-sm-6 col-xs-12">
            	<div class="left_form">
                	1.<div class="input_outer">
                	<label>Name and phone number</label>
                    <div class="input_area">
                    	<input type="text" class="input_lrg" name="user_ref1_name" id="user_ref1_name" value="<?=$R->user_ref1_name?>" />
                    </div>
                </div>
                <div class="input_outer">
                	<label>Role/Position</label>
                    <div class="input_area">
                    	<input type="text" class="input_lrg" name="user_ref1_role" id="user_ref1_role" value="<?=$R->user_ref1_role?>" />
                    </div>
                </div>
                <div class="input_outer">
                	<label>Age of children</label>
                    <div class="input_area">
                    	<input type="text" class="input_lrg" name="user_ref1_age" id="user_ref1_age" value="<?=$R->user_ref1_age?>" />
                    </div>
                </div>
                <div class="input_outer">
                	<label>Length of employment</label>
                    <div class="input_area">
                    	<input type="text" class="input_lrg" name="user_ref1_length" id="user_ref1_length" value="<?=$R->user_ref1_length?>" />
                    </div>
                </div>
                
                
                    
                </div>
            </div>
            <div class="sitter_app_right col-lg-6 col-md-6 col-sm-6 col-xs-12">
            	<div class="right_form">
                	
                	2.<div class="input_outer">
                	<label>Name and phone number</label>
                    <div class="input_area">
                    	<input type="text" class="input_lrg" name="user_ref2_name" id="user_ref2_name" value="<?=$R->user_ref2_name?>" />
                    </div>
                </div>
                <div class="input_outer">
                	<label>Role/Position</label>
                    <div class="input_area">
                    	<input type="text" class="input_lrg" name="user_ref2_role" id="user_ref2_role" value="<?=$R->user_ref2_role?>" />
                    </div>
                </div>
                <div class="input_outer">
                	<label>Age of children</label>
                    <div class="input_area">
                    	<input type="text" class="input_lrg" name="user_ref2_age" id="user_ref2_age" value="<?=$R->user_ref2_age?>" />
                    </div>
                </div>
                <div class="input_outer">
                	<label>Length of employment</label>
                    <div class="input_area">
                    	<input type="text" class="input_lrg" name="user_ref2_length" id="user_ref2_length" value="<?=$R->user_ref2_length?>" />
                    </div>
                </div>
                
                
                
                    
                    
                  
                </div>
            </div><?php */?>
        <div style="clear:both;"></div>
        <div class="sitter_app_left col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="left_form">
            <div class="input_outer">
              <label>Do you have any other references/work experiences you want to share?:</label>
              <div class="input_area">
                <textarea class="input_lrg" name="user_biography" id="user_biography"><?=$R->user_biography?>
</textarea>
              </div>
            </div>
            <div class="input_outer">
              <label>Please describe any experience with special needs children</label>
              <div class="input_area">
                <textarea class="input_lrg" name="user_babysitting_exp" id="user_babysitting_exp"><?=$R->user_babysitting_exp?>
</textarea>
              </div>
            </div>
          </div>
        </div>
        <div style="clear:both;"></div>
        <div class="sitter_app_heading">
          <h3>Availability - Indicate which days you are GENERALLY available, and on those days the times available</h3>
        </div>
        <div class="sitter_app_left col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="left_form">
            <div class="input_outer">
              <label>Monday</label>
              <?php
			  	$disabled = 'disabled';
				$not_available = 'checked';
			  	if($R->user_available_mon_start != "") {
					$disabled = $not_available = false;
					$user_available_s = explode(',',$R->user_available_mon_start);
					$user_available_e = explode(',',$R->user_available_mon_end);
				}
			  ?>
              <div class="chkbox">
                <input type="checkbox" name="user_available_mon" id="user_available_mon" value="Not Available"  <?=$R->user_high_school=='No'?'checked':''?> <?=$not_available;?> />
                <label for="user_available_mon"><span></span>Not Available</label>
              </div>
              
              <div class="input_area" id="user_available_mon_select">
                <select class="input_mdm" name="user_available_mon_start1" id="user_available_mon_start1" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_s[0]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_mon_end1" id="user_available_mon_end1" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[0]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                <select class="input_mdm" name="user_available_mon_start2" id="user_available_mon_start2" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_s[1]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_mon_end2" id="user_available_mon_end2" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[1]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                <select class="input_mdm" name="user_available_mon_start3" id="user_available_mon_start3" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_s[2]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_mon_end3" id="user_available_mon_end3" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[2]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
              </div>
            </div>
            <div class="input_outer">
              <label>Tuesday</label><div class="chkbox">
              <?php
			  	$disabled = 'disabled';
				$not_available = 'checked';
			  	if($R->user_available_tue_start != "") {
					$disabled = $not_available = false;
					$user_available_s = explode(',',$R->user_available_tue_start);
					$user_available_e = explode(',',$R->user_available_tue_end);
				}
			  ?>
                <input type="checkbox" name="user_available_tue" id="user_available_tue" value="Not Available"  <?=$R->user_high_school=='No'?'checked':''?> <?=$not_available;?> />
                <label for="user_available_tue"><span></span>Not Available</label>
              </div>
              <div class="input_area" id="user_available_tue_select">
                <select class="input_mdm" name="user_available_tue_start1" id="user_available_tue_start1" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_s[0]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_tue_end1" id="user_available_tue_end1" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[0]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                <select class="input_mdm" name="user_available_tue_start2" id="user_available_tue_start2" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$$user_available_s[1]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_tue_end2" id="user_available_tue_end2" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[1]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                <select class="input_mdm" name="user_available_tue_start3" id="user_available_tue_start3" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_s[2]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_tue_end3" id="user_available_tue_end3" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[2]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
              </div>
            </div>
            <div class="input_outer">
              <?php
			  	$disabled = 'disabled';
				$not_available = 'checked';
			  	if($R->user_available_wed_start != "") {
					$disabled = $not_available = false;
					$user_available_s = explode(',',$R->user_available_wed_start);
					$user_available_e = explode(',',$R->user_available_wed_end);
				}
			  ?>
              <label>Wednesday</label><div class="chkbox">
                <input type="checkbox" name="user_available_wed" id="user_available_wed" value="Not Available"  <?=$R->user_high_school=='No'?'checked':''?> <?=$not_available;?> />
                <label for="user_available_wed"><span></span>Not Available</label>
              </div>
              <div class="input_area" id="user_available_wed_select">
                <select class="input_mdm" name="user_available_wed_start1" id="user_available_wed_start1" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_s[0]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_wed_end1" id="user_available_wed_end1" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[0]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                <select class="input_mdm" name="user_available_wed_start2" id="user_available_wed_start2" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_s[1]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_wed_end2" id="user_available_wed_end2" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[1]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                <select class="input_mdm" name="user_available_wed_start3" id="user_available_wed_start3" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_s[2]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_wed_end3" id="user_available_wed_end3" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[2]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
              </div>
            </div>
            <div class="input_outer">
              <label>Thursday</label><div class="chkbox">
              <?php
			  	$disabled = 'disabled';
				$not_available = 'checked';
			  	if($R->user_available_thu_start != "") {
					$disabled = $not_available = false;
					$user_available_s = explode(',',$R->user_available_thu_start);
					$user_available_e = explode(',',$R->user_available_thu_end);
				}
			  ?>
                <input type="checkbox" name="user_available_thu" id="user_available_thu" value="Not Available"  <?=$R->user_high_school=='No'?'checked':''?> <?=$not_available;?> />
                <label for="user_available_thu"><span></span>Not Available</label>
              </div>
              <div class="input_area" id="user_available_thu_select">
                <select class="input_mdm" name="user_available_thu_start1" id="user_available_thu_start1" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_s[0]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_thu_end1" id="user_available_thu_end1" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[0]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                <select class="input_mdm" name="user_available_thu_start2" id="user_available_thu_start2" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[1]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_thu_end2" id="user_available_thu_end2" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[1]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                <select class="input_mdm" name="user_available_thu_start3" id="user_available_thu_start3" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_s[2]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_thu_end3" id="user_available_thu_end3" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[2]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
              </div>
            </div>
            <div class="input_outer">
              <label>Friday</label><div class="chkbox">
              <?php
			  	$disabled = 'disabled';
				$not_available = 'checked';
			  	if($R->user_available_fri_start != "") {
					$disabled = $not_available = false;
					$user_available_s = explode(',',$R->user_available_fri_start);
					$user_available_e = explode(',',$R->user_available_fri_end);
				}
			  ?>
                <input type="checkbox" name="user_available_fri" id="user_available_fri" value="Not Available"  <?=$R->user_high_school=='No'?'checked':''?> <?=$not_available;?> />
                <label for="user_available_fri"><span></span>Not Available</label>
              </div>
              <div class="input_area" id="user_available_fri_select">
                <select class="input_mdm" name="user_available_fri_start1" id="user_available_fri_start1" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_s[0]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_fri_end1" id="user_available_fri_end1" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[0]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                <select class="input_mdm" name="user_available_fri_start2" id="user_available_fri_start2" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_s[1]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_fri_end2" id="user_available_fri_end2" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[1]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                <select class="input_mdm" name="user_available_fri_start3" id="user_available_fri_start3" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_s[2]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_fri_end3" id="user_available_fri_end3" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[2]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
              </div>
            </div>
            <div class="input_outer">
              <label>Saturday</label><div class="chkbox">
              <?php
			  	$disabled = 'disabled';
				$not_available = 'checked';
			  	if($R->user_available_sat_start != "") {
					$disabled = $not_available = false;
					$user_available_s = explode(',',$R->user_available_sat_start);
					$user_available_e = explode(',',$R->user_available_sat_end);
				}
			  ?>
                <input type="checkbox" name="user_available_sat" id="user_available_sat" value="Not Available"  <?=$R->user_high_school=='No'?'checked':''?> <?=$not_available;?> />
                <label for="user_available_sat"><span></span>Not Available</label>
              </div>
              <div class="input_area" id="user_available_sat_select">
                <select class="input_mdm" name="user_available_sat_start1" id="user_available_sat_start1" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_s[0]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_sat_end1" id="user_available_sat_end1" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[0]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                <select class="input_mdm" name="user_available_sat_start2" id="user_available_sat_start2" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_s[1]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_sat_end2" id="user_available_sat_end2" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[1]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                <select class="input_mdm" name="user_available_sat_start3" id="user_available_sat_start3" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_s[2]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_sat_end3" id="user_available_sat_end3" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[2]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
              </div>
            </div>
            <div class="input_outer">
              <label>Sunday</label><div class="chkbox">
              <?php
			  	$disabled = 'disabled';
				$not_available = 'checked';
			  	if($R->user_available_sun_start != "") {
					$disabled = $not_available = false;
					$user_available_s = explode(',',$R->user_available_sun_start);
					$user_available_e = explode(',',$R->user_available_sun_end);
				}
			  ?>
                <input type="checkbox" name="user_available_sun" id="user_available_sun" value="Not Available"  <?=$R->user_high_school=='No'?'checked':''?> <?=$not_available;?> />
                <label for="user_available_sun"><span></span>Not Available</label>
              </div>
              <div class="input_area" id="user_available_sun_select">
                <select class="input_mdm" name="user_available_sun_start1" id="user_available_sun_start1" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_s[0]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_sun_end1" id="user_available_sun_end1" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[0]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                <select class="input_mdm" name="user_available_sun_start2" id="user_available_sun_start2" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_s[1]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_sun_end2" id="user_available_sun_end2" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[1]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                <select class="input_mdm" name="user_available_sun_start3" id="user_available_sun_start3" <?=$disabled;?>>
                  <option value="">Start Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_s[2]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
                -
                <select class="input_mdm" name="user_available_sun_end3" id="user_available_sun_end3" <?=$disabled;?>>
                  <option value="">End Time</option>
                  <?php for($i=0;$i<=24;$i++){
							?>
                  <option value="<?=$i?>" <?=$user_available_e[2]==$i?'selected':''?> >
                  <?=date("h:i a",mktime($i,0,0,0,0,0))?>
                  </option>
                  <?php 
						}
						?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div style="clear:both;"></div>
        <?php /*?> <div class="sitter_app_botm">
            	<div class="agree">
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
                </div>
            </div>
           <?php */?>
        <input type="submit" value="Update Information" class="login_sub_btn" />
      </form>
    </div>
  </div>
</section>
<script type="text/javascript">
$(document).ready(function(e) {
    $('#user_available_mon').click(function() {
		if($(this).is(':checked')) {
			$('#user_available_mon_select select').prop('disabled', 'disabled');
		}
		else {
			$('#user_available_mon_select select').prop('disabled', false);
		}
	});
    $('#user_available_tue').click(function() {
		if($(this).is(':checked')) {
			$('#user_available_tue_select select').prop('disabled', 'disabled');
		}
		else {
			$('#user_available_tue_select select').prop('disabled', false);
		}
	});
    $('#user_available_wed').click(function() {
		if($(this).is(':checked')) {
			$('#user_available_wed_select select').prop('disabled', 'disabled');
		}
		else {
			$('#user_available_wed_select select').prop('disabled', false);
		}
	});
    $('#user_available_thu').click(function() {
		if($(this).is(':checked')) {
			$('#user_available_thu_select select').prop('disabled', 'disabled');
		}
		else {
			$('#user_available_thu_select select').prop('disabled', false);
		}
	});
    $('#user_available_fri').click(function() {
		if($(this).is(':checked')) {
			$('#user_available_fri_select select').prop('disabled', 'disabled');
		}
		else {
			$('#user_available_fri_select select').prop('disabled', false);
		}
	});
    $('#user_available_sat').click(function() {
		if($(this).is(':checked')) {
			$('#user_available_sat_select select').prop('disabled', 'disabled');
		}
		else {
			$('#user_available_sat_select select').prop('disabled', false);
		}
	});
    $('#user_available_sun').click(function() {
		if($(this).is(':checked')) {
			$('#user_available_sun_select select').prop('disabled', 'disabled');
		}
		else {
			$('#user_available_sun_select select').prop('disabled', false);
		}
	});
});
</script>
<?php include('includes/footer.php');?>
