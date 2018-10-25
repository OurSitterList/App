<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php

// if ((!isset($_SESSION['user_id_member_choose']) && $_SESSION['user_id_member_choose']=='') || $_SESSION['user_type_member_choose']!='family')
// {
// 	header('Location:'.$base_path);
// 	exit;
// }

extract($_REQUEST);
?>

<section class="sitter_app_outer">
	<div class="container">
    	<div class="sitter_app_cont clearfix">
        <?php

if (isset($_REQUEST['expired']) && (int)$_REQUEST['expired'] === 1)
{
    echo '<div class="alert alert-danger">The credit card on file has expired. Please update your payment information below to restore access to Our Sitter List.</div>';
}

?>
            <div class="sitter_app_heading">
            	<h3>Update Credit Card</h3>
            </div>
            <form action="<?=$base_path?>/family_update_cc.php" method="post" enctype="multipart/form-data" id="updateccForm">
            <input type="hidden" name="user_id_member_choose" id="user_id_member_choose" class="sitter_input" value="<?=$_SESSION['user_id_member_choose']?>"/>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <section class="form-block">
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Card Holder First Name * </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="input_lrg" name="user_first_name" id="user_first_name" required />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                    	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        	<label>Card Holder Last Name *</label>
                        </div>
                    	<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        	<input type="text" class="input_lrg" name="user_last_name" id="user_last_name" required />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Card Number *</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="input_lrg" name="cardNumber" id="cardNumber" required />
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
                                    	<select class="input_lrg" name="expirationDate_month" id="expirationDate_month" required>
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
                                    	<select class="input_lrg" name="expirationDate_year" id="expirationDate_year" required>
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
                                    <input type="text" class="input_lrg" name="cardCode" id="cardCode" required />
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
                                    <input type="submit" value="Update Credit Card" class="login_sub_btn" />
                                </div>
                            </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                </section>
            </div>
        </div>
    </div>
</section>
<?php include('includes/footer.php');?>
