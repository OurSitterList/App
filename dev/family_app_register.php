<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php
extract($_POST);
if(!filter_var($family_email, FILTER_VALIDATE_EMAIL) || 4 > strlen($family_username) || 4 > strlen($family_password))
{
	header('Location:'.$https_base_path);
}
?>
			
<section class="sitter_app_outer">
	<div class="container">      
        	<div class="sitter_app_heading">
            	<h3>Family Profile</h3>
            </div>
            <form action="<?=$https_base_path?>/family_register.php" method="post" enctype="multipart/form-data" id="familysignupappForm">
            <input type="hidden" name="family_email" id="family_email" placeholder="Enter Email Adress" class="sitter_input" value="<?=$family_email?>"/>
            <input type="hidden"   name="family_username" id="family_username" placeholder="Enter Username" class="sitter_input" value="<?=$family_username?>"/>
            <input type="hidden" name="family_password" id="family_password" placeholder="Enter Password" class="sitter_input" value="<?=$family_password?>"/>
            <?php  //echo  base64_encode('submit_family_page');?>
            <input type="hidden" name="user_info_submit" value="c3VibWl0X2ZhbWlseV9wYWdl">
            	<section class="form-block">
                	<h3 class="title-6">Personal information</h3>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>First Name * </label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="input_lrg" name="user_first_name" id="user_first_name"  />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Last Name *</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="input_lrg" name="user_last_name" id="user_last_name"   />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	
                    <div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>ZipCode</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                               <select class="input_lrg" name="user_zip" id="user_zip"  >
                       
                        <?php  $state_query =  mysql_query("select * from states order by state ");
						if(mysql_num_rows($state_query)>0)
						{
							while($S = mysql_fetch_object($state_query))
							{
								?>
                                 <option value="<?=$S->state_code?>" ><?=$S->state?></option>
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
                                <label>Current address *</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="input_lrg" name="user_current_address" id="user_current_address"  /> 
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Cell Phone No *</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="input_lrg" name="user_cell_phone" id="user_cell_phone"  /> 
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
                                <input type="email" class="input_lrg" name="user_contact_email" id="user_contact_email" value="<?=$family_email;?>" /> 
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="row">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Please describe your family needs/Bio:</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <textarea class="input_lrg textarea" style="color:red" name="user_contact_address" id="user_contact_address" placeholder="Should read “i.e. We are a busy family with 2 active kids. Our kids are 6 and 8 and enjoy being outside and playing sports. We mostly need sitters to help with after school activity drop-offs and pick-ups. We generally go out once a weekend – so need weekend sitters too.”"></textarea>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </section>
               <section class="form-block">
                	<div class="row">
                    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        	<h3 class="title-6">Our Sitter List Nashville Package Options</h3>
                             <h3 class="title-7">Parents pay a one-time application fee of $45. Parents will not be able to use the site until approved by the founders. Application processing will be completed with 36 hours. Please contact us at <a target="new" href="contact-us.php">oursitterlistnashville@gmail.com</a> if you need your application expedited.</h3>
                            <ul class="list-1">
                                <li>12 month membership for $24 per month</li> 
                                <li>6 month membership for $32 per month</li> 
                                <li> 3 month membership for $38 per month</li> 
                               
                            </ul>
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
            	<section class="form-block">
                	<div class="row">
                    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        	<h3 class="title-6">Our Sitter List LLC expectations:</h3>
                            <ul class="list-1">
                                <li>I will lay out my clear instructions for the babysitter.</li>
                                <li>I will adhere to the hourly rates referenced above. </li>
                                <li>Babysitter will provide own transportation to and from. I will not provide transportation.</li>
                                <li>All sitters found through www.oursitterlistnashville.com should be booked through the website.</li>
                                <li>All sitters should be booked through www.oursitterlistnashville.com.(not through calling or text messaging)</li>
                                <li>I will do my best to reserve 24 hours in advance. However, last minute sitters are available. We just encourage booking as far in advance as possible.</li>
                                <li>I will provide positive and/or negative feedback to oursitterlistnashville@gmail.com.</li>
                                <li>I will contact Whitney or Karly immediately if any issues arise with a sitter.</li>
                                <li>I agree to Our Sitter List LLC "House Rules".</li>
                            </ul>
                        </div>
                    </div>
                </section>
            	<section class="form-block">
                	<h3 class="title-6">Payment Details</h3>
                    <h3 class="title-7">In order to join our website, the cost is a $45 application fee.</h3>
                    <div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Card Number *</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="input_lrg" name="cardNumber" id="cardNumber"  /><br>
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
                    <div class="form-group">
                    	<div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>How did you hear about us ?</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <textarea class="input_lrg textarea" name="user_hear_about" id="user_hear_abouts"></textarea>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="form-group">
                    		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">&nbsp;</div>
                    		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            	<div class="row">
                          
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                               <div class="checkbox">
                                <label><input type="checkbox" name="is_agree" id="is_agree" value="1" style="display:block;"  /> Agree to Our Sitter List LLC "House Rules"</label> <br>
                                <label><input type="checkbox" name="card_information" id="card_information" value="1"style="display:block !important;"  /> Save your Credit Card informatrion with us</label> 
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <input type="submit" value="Make Payment - $45" id="submit_val" class="login_sub_btn" />
                                </div>
                            </div>
                            </div>
                            <div class="clear"></div>
                </section>
            </form>
        </div>
    </div>
</section>
<?php include('includes/footer.php');?>
