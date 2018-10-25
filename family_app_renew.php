<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php
extract($_POST);
/*if(!filter_var($family_email, FILTER_VALIDATE_EMAIL) || 4 > strlen($family_username) || 4 > strlen($family_password))
{
	header('Location:'.$https_base_path);
    exit;
}*/
?>
			
<section class="sitter_app_outer">
	<div class="container">
        <div class="alert alert-danger">The credit card on file has expired. Please update your payment information below to restore access to Our Sitter List.</div>
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
                            <label>Email Address *</label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <input type="email" class="input_lrg" name="user_contact_email" id="user_contact_email" value="<?=$family_email;?>" />
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </section>

        	<div class="sitter_app_heading">
            	<h3>Payment Information</h3>
            </div>
            <input type="hidden" name="family_email" id="family_email" placeholder="Enter Email Adress" class="sitter_input" value="<?=$family_email?>"/>
            <input type="hidden"   name="family_username" id="family_username" placeholder="Enter Username" class="sitter_input" value="<?=$family_username?>"/>
            <input type="hidden" name="family_password" id="family_password" placeholder="Enter Password" class="sitter_input" value="<?=$family_password?>"/>
            <?php  //echo  base64_encode('submit_family_page');?>
            <input type="hidden" name="user_info_submit" value="c3VibWl0X2ZhbWlseV9wYWdl">

            	<section class="form-block">
                	<h3 class="title-6">Payment Details</h3>
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
                                <label><input type="checkbox" name="is_agree" id="is_agree" value="1" style="display:block;"  /> Agree to Our Sitter List LLC "House Rules"</label>
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
