<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>

<?php if((!isset($_POST['sitter_email'])))
			{
				
				header('Location:'.$base_path);
				
			}
extract($_REQUEST);
		

//echo $update_query;exit;
			?>

<script language="javascript" type="text/javascript" src="/js/sitter_signup.js"></script>
<section class="sitter_app_outer">
	<div class="container">
    	<div class="sitter_app_cont clearfix">
       
        	<div class="sitter_app_heading">
            	<h3>Sitter Profile</h3>
            </div>
            <form action="<?=$https_base_path?>/sitter_register.php" method="post" enctype="multipart/form-data" id="sittersignupappForm">
            <input type="hidden" name="sitter_email" id="sitter_email" placeholder="Enter Email Adress" class="sitter_input" value="<?=$sitter_email?>"/>
            <input type="hidden"   name="sitter_username" id="sitter_username" placeholder="Enter Username" class="sitter_input" value="<?=$sitter_username?>"/>
            <input type="hidden" name="sitter_password" id="sitter_password" placeholder="Enter Password" class="sitter_input" value="<?=$sitter_password?>"/>
            <?php  //echo  base64_encode('submit_sitter_page');?>
            <input type="hidden" name="user_info_submit" value="c3VibWl0X3NpdHRlcl9wYWdl">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            	<section class="form-block">
                	<h3 class="title-6">Personal information</h3>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>First Name</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                               <input type="text" class="input_lrg" name="user_first_name" id="user_first_name" />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Last Name</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                               <input type="text" class="input_lrg" name="user_last_name" id="user_last_name"  />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>ZIP Code</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                               <select class="input_lrg" name="user_zip" id="user_zip"  >
                       
                        <?php  $state_query =  mysql_query("select zip from zip_code order by zip ");
						if(mysql_num_rows($state_query)>0)
						{
							while($S = mysql_fetch_object($state_query))
							{
								?>
                                 <option value="<?=$S->zip?>" ><?=$S->zip?></option>
                                 <?php
							}
						}
						?>
                        </select>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Driver License</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <div class="chkbox1">
                                <input type="radio" name="user_driver_license" id="user_driver_license_yes" value="Yes"  />
                                <label for="user_driver_license_yes"><span></span>Yes</label>
                                </div>
                                <div class="chkbox1">
                                <input type="radio" name="user_driver_license" id="user_driver_license_no" value="No"   />
                                <label for="user_driver_license_no"><span></span>No</label>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Firstaid Training</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <div class="chkbox1">
                                <input type="radio" name="user_firstaid_training" id="user_firstaid_training_yes" value="Yes"   />
                                <label for="user_firstaid_training_yes"><span></span>Yes</label>
                                </div>
                                <div class="chkbox1">
                                <input type="radio" name="user_firstaid_training" id="user_firstaid_training_no" value="No"  />
                                <label for="user_firstaid_training_no"><span></span>No</label>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Date of Certification</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="input_lrg" name="user_date_of_certification" id="user_date_of_certification"   />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Willing To Be Certified</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <input type="checkbox" class="input_lrg" name="is_user_willing_to_certified" id="is_user_willing_to_certified" value="1"  />
                                    <label for="is_user_willing_to_certified"><span></span>Yes</label>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Cpr Training</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <div class="chkbox1">
                        	<input type="radio" name="user_cpr_training" id="user_cpr_training_yes" value="Yes"    />
							<label for="user_cpr_training_yes"><span></span>Yes</label>
                        </div>
                        		<div class="chkbox1">
                        	<input type="radio" name="user_cpr_training" id="user_cpr_training_no" value="No"   />
							<label for="user_cpr_training_no"><span></span>No</label>
                        </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Date of Certification</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="input_lrg" name="user_date_of_certification_cpr" id="user_date_of_certification_cpr" value="" />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Willing To Be Certified</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <input type="checkbox" class="input_lrg" name="is_user_willing_to_certified_cpr" id="is_user_willing_to_certified_cpr" value="1"  />
                                <label for="is_user_willing_to_certified_cpr"><span></span>Yes</label>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Please describe yourself/Bio:</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <textarea class="input_lrg textarea" name="user_description" id="user_description"></textarea>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </section>
            	<section class="form-block">
                	<h3 class="title-6">Contact information</h3>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Cell Phone No</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                               <input type="text" class="input_lrg" name="user_cell_phone" id="user_cell_phone"   />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Email Address</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                               <input type="email" class="input_lrg" name="user_contact_email" id="user_contact_email" value="<?=$sitter_email?>"  />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Emergency Contact</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                               <input type="text" class="input_lrg" name="user_emergency_contact" id="user_emergency_contact"  />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </section>
            	<section class="form-block">
                	<h3 class="title-6">Education</h3>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>High School</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                               <div class="chkbox1">
                        	<input type="radio" name="user_high_school" id="user_high_school_yes" value="Yes"  />
							<label for="user_high_school_yes"><span></span>Yes</label>
                        </div>
                        		<div class="chkbox1">
                        	<input type="radio" name="user_high_school" id="user_high_school_no" value="No" />
							<label for="user_high_school_no"><span></span>No</label>
                        </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>If yes, what high school</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                               <input type="text" class="input_lrg" name="user_high_school_name" id="user_high_school_name" />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>College</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    	<div class="chkbox1">
                        	<input type="radio" name="user_college" id="user_college_yes" value="Yes"  />
							<label for="user_college_yes"><span></span>Yes</label>
                        </div>
                        <div class="chkbox1">
                        	<input type="radio" name="user_college" id="user_college_no" value="No"  />
							<label for="user_college_no"><span></span>No</label>
                        </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label>If yes, what college</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                               <input type="text" class="input_lrg" name="user_college_name" id="user_college_name" />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </section>
            	<section class="form-block">
                	<h3 class="title-6">References/Experience</h3>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label>1. Name and phone number</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                               <input type="text" class="input_lrg" name="user_ref1_name" id="user_ref1_name" />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label>Role/Position</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                               <input type="text" class="input_lrg" name="user_ref1_role" id="user_ref1_role" />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label>Age of children</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                               <input type="text" class="input_lrg" name="user_ref1_age" id="user_ref1_age"  />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label>Length of employment</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                               <input type="text" class="input_lrg" name="user_ref1_length" id="user_ref1_length"  />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label>2. Name and phone number</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                               <input type="text" class="input_lrg" name="user_ref2_name" id="user_ref2_name"  />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label>Role/Position</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                               <input type="text" class="input_lrg" name="user_ref2_role" id="user_ref2_role" />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label>Age of children</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                               <input type="text" class="input_lrg" name="user_ref2_age" id="user_ref2_age" />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label>Length of employment</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                               <input type="text" class="input_lrg" name="user_ref2_length" id="user_ref2_length"  />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                 <label>Do you have any other references/work experiences you want to share?:</label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <textarea class="input_lrg" name="user_biography" id="user_biography"></textarea>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                 <label>Please describe any experience with special needs children</label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <textarea class="input_lrg" name="user_babysitting_exp" id="user_babysitting_exp"></textarea>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </section>
                <section class="form-block">
                	<div class="row">
                    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        	<h3 class="title-6">Babysitting Rates</h3>
                            <ul class="list-1">
                                <li>1 child @ $11/hour</li> 
                                <li>2 children @ $12/hour</li> 
                                <li>3 children @ $14/hour</li> 
                                <li>4 children @ $15/hour</li> 
                                <li>More than 4 children will be an additional $1/hour per child</li> 
                            </ul>
                        </div>
                    </div>
                </section>
            	<?php /*?><section class="form-block">
                	<h3 class="title-6">Availability - Indicate which days you are GENERALLY available, and on those days the times available</h3>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label>Monday</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                               
                    	<select class="input_mdm" name="user_available_mon_start" id="user_available_mon_start">
                        <option value="">Start Time</option>
                        <?php for($i=0;$i<=24;$i++){
							?>
                        <option value="<?=$i?>" <?=$R->user_available_mon_start==$i?'selected':''?> ><?=str_pad($i, 2, '0', STR_PAD_LEFT)?>:00</option>
                        <?php 
						}
						?>
                        </select>
                         - 
                         <select class="input_mdm" name="user_available_mon_end" id="user_available_mon_end">
                        <option value="">End Time</option>
                        <?php for($i=0;$i<=24;$i++){
							?>
                        <option value="<?=$i?>" <?=$R->user_available_mon_end==$i?'selected':''?> ><?=str_pad($i, 2, '0', STR_PAD_LEFT)?>:00</option>
                        <?php 
						}
						?>
                        </select>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label>Tuesday</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    	<select class="input_mdm" name="user_available_tue_start" id="user_available_tue_start">
                        <option value="">Start Time</option>
                        <?php for($i=0;$i<=24;$i++){
							?>
                        <option value="<?=$i?>" <?=$R->user_available_tue_start==$i?'selected':''?> ><?=str_pad($i, 2, '0', STR_PAD_LEFT)?>:00</option>
                        <?php 
						}
						?>
                        </select>
                         - 
                         <select class="input_mdm" name="user_available_tue_end" id="user_available_tue_end">
                        <option value="">End Time</option>
                        <?php for($i=0;$i<=24;$i++){
							?>
                        <option value="<?=$i?>" <?=$R->user_available_tue_end==$i?'selected':''?> ><?=str_pad($i, 2, '0', STR_PAD_LEFT)?>:00</option>
                        <?php 
						}
						?>
                        </select>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label>Wednesday</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    	<select class="input_mdm" name="user_available_wed_start" id="user_available_wed_start">
                        <option value="">Start Time</option>
                        <?php for($i=0;$i<=24;$i++){
							?>
                        <option value="<?=$i?>" <?=$R->user_available_wed_start==$i?'selected':''?> ><?=str_pad($i, 2, '0', STR_PAD_LEFT)?>:00</option>
                        <?php 
						}
						?>
                        </select>
                         - 
                         <select class="input_mdm" name="user_available_wed_end" id="user_available_wed_end">
                        <option value="">End Time</option>
                        <?php for($i=0;$i<=24;$i++){
							?>
                        <option value="<?=$i?>" <?=$R->user_available_wed_end==$i?'selected':''?> ><?=str_pad($i, 2, '0', STR_PAD_LEFT)?>:00</option>
                        <?php 
						}
						?>
                        </select>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label>Thursday</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    	<select class="input_mdm" name="user_available_thu_start" id="user_available_thu_start">
                        <option value="">Start Time</option>
                        <?php for($i=0;$i<=24;$i++){
							?>
                        <option value="<?=$i?>" <?=$R->user_available_thu_start==$i?'selected':''?> ><?=str_pad($i, 2, '0', STR_PAD_LEFT)?>:00</option>
                        <?php 
						}
						?>
                        </select>
                         - 
                         <select class="input_mdm" name="user_available_thu_end" id="user_available_thu_end">
                        <option value="">End Time</option>
                        <?php for($i=0;$i<=24;$i++){
							?>
                        <option value="<?=$i?>" <?=$R->user_available_thu_end==$i?'selected':''?> ><?=str_pad($i, 2, '0', STR_PAD_LEFT)?>:00</option>
                        <?php 
						}
						?>
                        </select>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label>Friday</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    	<select class="input_mdm" name="user_available_fri_start" id="user_available_fri_start">
                        <option value="">Start Time</option>
                        <?php for($i=0;$i<=24;$i++){
							?>
                        <option value="<?=$i?>" <?=$R->user_available_fri_start==$i?'selected':''?> ><?=str_pad($i, 2, '0', STR_PAD_LEFT)?>:00</option>
                        <?php 
						}
						?>
                        </select>
                         - 
                         <select class="input_mdm" name="user_available_fri_end" id="user_available_fri_end">
                        <option value="">End Time</option>
                        <?php for($i=0;$i<=24;$i++){
							?>
                        <option value="<?=$i?>" <?=$R->user_available_fri_end==$i?'selected':''?> ><?=str_pad($i, 2, '0', STR_PAD_LEFT)?>:00</option>
                        <?php 
						}
						?>
                        </select>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label>Saturday</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    	<select class="input_mdm" name="user_available_sat_start" id="user_available_sat_start">
                        <option value="">Start Time</option>
                        <?php for($i=0;$i<=24;$i++){
							?>
                        <option value="<?=$i?>" <?=$R->user_available_sat_start==$i?'selected':''?> ><?=str_pad($i, 2, '0', STR_PAD_LEFT)?>:00</option>
                        <?php 
						}
						?>
                        </select>
                         - 
                         <select class="input_mdm" name="user_available_sat_end" id="user_available_sat_end">
                        <option value="">End Time</option>
                        <?php for($i=0;$i<=24;$i++){
							?>
                        <option value="<?=$i?>" <?=$R->user_available_sat_end==$i?'selected':''?> ><?=str_pad($i, 2, '0', STR_PAD_LEFT)?>:00</option>
                        <?php 
						}
						?>
                        </select>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label>Sunday</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    	<select class="input_mdm" name="user_available_sun_start" id="user_available_sun_start">
                        <option value="">Start Time</option>
                        <?php for($i=0;$i<=24;$i++){
							?>
                        <option value="<?=$i?>" <?=$R->user_available_sun_start==$i?'selected':''?> ><?=str_pad($i, 2, '0', STR_PAD_LEFT)?>:00</option>
                        <?php 
						}
						?>
                        </select>
                         - 
                         <select class="input_mdm" name="user_available_sun_end" id="user_available_sun_end">
                        <option value="">End Time</option>
                        <?php for($i=0;$i<=24;$i++){
							?>
                        <option value="<?=$i?>" <?=$R->user_available_sun_end==$i?'selected':''?> ><?=str_pad($i, 2, '0', STR_PAD_LEFT)?>:00</option>
                        <?php 
						}
						?>
                        </select>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </section><?php */?>
                <section class="form-block">
                	<div class="row">
                    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        	<h3 class="title-6">Our Sitter List LLC expectations:</h3>
                            <ul class="list-1">
<li>I will adhere to the hourly rates referenced above. If a higher rate is desired, please discuss with either Whitney or Karly.</li>
<li>I will respond to babysitting requests within 3 hours of receipt of said request. (sooner is a plus!)</li>
<li>I will be on time to my babysitting jobs.</li>
<li>I will provide my own transportation to and from.</li>
<li>I will dress appropriately.</li>
<li>I will not use profanity.</li>
<li>I will adhere to the children’s parents’ requests regarding eating, napping, television time and other schedules.</li>
<li>I will not drink alcohol or smoke while children are in my care, custody and control.</li>
<li>I will keep my schedule updated.</li>
<li>I will refrain from using my mobile phone, tablet or other device while children are in my care, custody and control.</li>
<li>I will support Our Sitter List LLC by reminding families to book all sitting jobs through www.oursitterlistnashville.com.</li>
<li>If a family contacts me for a sitting job and was referred by a member of www.oursitterlistnashville.com then I will refer that family to the website.</li>
<li>I will keep the house where I am sitting tidy.</li>
<li>I will contact Whitney or Karly immediately if I need to cancel a sitting job.</li>
<li>If I am not 18 years of age then I will seek consent from a parent or guardian.</li>
<li>I have read and accept Our Sitter List LLC “House Rules”.</li> 
                            </ul>
                        </div>
                    </div>
                </section>
                <section class="form-block">
                	<h3 class="title-6">Payment Details</h3>
                    <h3 class="title-7">In order to join our website, the cost is a one time application fee of $25. This covers your background check and application processing.</h3>
                    <div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Card Number *</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="input_lrg" name="cardNumber" id="cardNumber"  />
                            </div>
                            <div class="clear"></div>
                        </div>
                    <div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Expiry Date *</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <div class="row">
                                	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    	<select class="input_lrg" name="expirationDate_month" id="expirationDate_month">
                        <option value="">MM</option>
                        <option value="01"> 01 </option>
                        <option value="02"> 02 </option>
                        <option value="03"> 03 </option>
                        <option value="04"> 04 </option>
                        <option value="05"> 05 </option>
                        <option value="06"> 06 </option>
                        <option value="07"> 07 </option>
                        <option value="08"> 08 </option>
                        <option value="09"> 09 </option>
                        <option value="10"> 10 </option>
                        <option value="11"> 11 </option>
                        <option value="12"> 12 </option>
                        
                        </select>
                                    </div>
                                	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    	<select class="input_lrg" name="expirationDate_year" id="expirationDate_year">
                        <option value="">YYYY</option>
                        <?php for($i=date('Y');$i<=(date('Y')+20);$i++)
						{
							?>
                            <option value="<?=$i?>"> <?=$i?> </option>
                            <?php
						}
						?>
                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    <div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>CVV *</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="input_lrg" name="cardCode" id="cardCode"  />
                            </div>
                            <div class="clear"></div>
                        </div>
                   <?php /*?> <div class="form-group">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>How did you hear about us ?</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <textarea class="input_lrg textarea" name="user_hear_about" id="user_hear_abouts"></textarea>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div><?php */?>
                    <section class="form-block">
                	<h3 class="text1">Please note that by submitting this application, you are subject to a background check that will be run by True Hire: Background Checks (www.true-hire.com). Separate application will need to be completed. We reserve the right to reject this application based on information provided in said background check.</h3>
                    <p class="title-7">NO SIGNATURE REQUIRED ON WEBSITE. By signing this application, you agree that all information is correct and that you acknowledge that a background check may be performed and as a result, that this application may be rejected.</p>
                    <div class="form-group">
                          
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                               	<div class="checkbox">
                                <label><input type="checkbox" name="is_agree" id="is_agree" value="1" style="display:block;"  /> Agree to Our Sitter List LLC "House Rules"</label> 
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                
                </section>
                    <div class="form-group">
                    		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">&nbsp;</div>
                    		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            	<div class="row">
                                <?php /*?><div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                	<input type="text" class="input_lrg" name="user_applicant_signature" id="user_applicant_signature" />
                                    <label><span>Signature of Applicant *</span></label>
                                </div><?php */?>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <input type="submit" value="Make Payment of $25" class="login_sub_btn" />
                                </div>
                            </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                </section>
                
            </div>
            </form>
        </div>
    </div>
</section>

<?php include('includes/footer.php');?>
