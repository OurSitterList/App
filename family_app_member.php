<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php

if ((!isset($_SESSION['user_id_member_choose']) && $_SESSION['user_id_member_choose']=='') || $_SESSION['user_type_member_choose']!='family')
{
	header('Location:'.$base_path);
	exit;
}

extract($_REQUEST);

if (false && $_REQUEST['isError'] == 1)
{
	 echo 'isError: '.$_REQUEST['isError'] . '<br />';
	 echo 'getResultCode: ' .$_REQUEST['getResultCode'] . '<br />';
	 echo 'getResponse: ' .$_REQUEST['getResponse'] . '<br />';
}
else
{

			?>
<section class="sitter_app_outer">
	<div class="container">
    	<div class="sitter_app_cont clearfix">
<?php

if (isset($_REQUEST['expired']) && (int)$_REQUEST['expired'] === 1)
{
    echo '<div class="alert alert-danger">The credit card on file has expired. Please update your payment information below to restore access to Our Sitter List.</div>';
}
elseif (isset($_REQUEST['expired']) && (int)$_REQUEST['expired'] === 2)
{
    echo '<div class="alert alert-danger">The credit card on file was declined for the most recent charge. Please update your payment information below to restore access to Our Sitter List.</div>';
}
elseif (isset($_REQUEST['expired']) && (int)$_REQUEST['expired'] === 4)
{
    echo '<div class="alert alert-danger">This subscription has been canceled.  Please renew your subscription below.</div>';
}

?>
        	<div class="sitter_app_heading">
            	<h3>Family Membership</h3>
            </div>
            <form action="<?=$base_path?>/family_membership.php" method="post" enctype="multipart/form-data" id="familymemberappForm">
            <input type="hidden" name="user_id_member_choose" id="user_id_member_choose" placeholder="Enter Email Adress" class="sitter_input" value="<?=$_SESSION['user_id_member_choose']?>"/>
           
            <?php // echo  base64_encode('submit_family_membership');?>
            <input type="hidden" name="user_info_submit" value="c3VibWl0X2ZhbWlseV9tZW1iZXJzaGlw">
        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            	<section class="form-block">
                	<h3 class="title-6">Our Sitter List Nashville Package Options</h3>
                	<div class="row">
                    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    		<div class="form-group">
                            <div class="chkbox">
                                <input type="radio" name="user_plan" id="user_plan_3" value="3"  checked />
                                <label for="user_plan_3"><span></span>$38 per month for 3 month membership </label>
                            </div>
                        </div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <div class="chkbox">
                                    <input type="radio" name="user_plan" id="user_plan_6" value="6"  />
                                    <label for="user_plan_6"><span></span>$32 per month for a 6 month membership </label>
                                </div>
                            </div>
                        </div>
                    </div>
                	<div class="row">
                    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <div class="chkbox">
                                    <input type="radio" name="user_plan" id="user_plan_12" value="12"  />
                                    <label for="user_plan_12"><span></span>$24 per month for a 12 month membership </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


            	<section class="form-block">
                	<h3 class="title-6">Payment Details</h3>
                    <div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Card Holder First Name * </label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="input_lrg" name="user_first_name" id="user_first_name"  />
                            </div>
                            <div class="clear"></div>
                        </div>
                    <div class="form-group">
                    	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        	<label>Card Holder Last Name *</label>
                        </div>
                    	<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        	<input type="text" class="input_lrg" name="user_last_name" id="user_last_name"  />
                        </div>
                            <div class="clear"></div>
                        </div>
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
                    <div class="form-group">

                    </div>
                    <div class="form-group">
                    		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">&nbsp;</div>
                    		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            	<div class="row">

                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <input type="submit" value="Pay for Membership" class="login_sub_btn" />
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
<?php
}
?>
<?php include('includes/footer.php');?>
