<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php if((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='') || $_SESSION['user_type']!='sitter')
			{
				
				header('Location:'.$base_path . '?redirect=' . urlencode('/family.php?fid=' . $_REQUEST['fid']));
                exit;
				
			}
			$search_query = mysql_query("select * from  user_information where user_id='".$_SESSION['user_id']."'");
if(mysql_num_rows($search_query)>0)
{
	$R = mysql_fetch_object($search_query);
	
}
else
{
	header('Location:'.$base_path.'/sitter_application.php');
	$changemsg = '<div class="msg-txt">Update Your Account Information <a href="sitter_application.php">click here</a></div>';
    exit;
}
$myaccount = new myAccount();
?>
<section class="sitter_details_outer">
  <div class="container">
      <?php
      if (isset($_REQUEST['sent']) && $_REQUEST['sent'] == '1')
      {
          echo '<div class="alert alert-success">Your message has been sent.</div>';
      }

      ?>
    <div class="sitter_detail_inner">
      <div class="sitter_details_bottom">
        <div class="sitter_app_heading">
          <h3>Family Details</h3>
        </div>
        <?php
		$sql = "SELECT
	ui.user_first_name,
    ui.user_middle_name,
    ui.user_last_name,
    ui.user_image,
    ui.user_contact_address,
    ui.user_cell_phone,
    ui.user_contact_email,
    ui.location_code
FROM
	user_management AS um
LEFT JOIN user_information AS ui ON ui.user_id = um.user_id
WHERE
	um.user_id = " . mysql_real_escape_string($_GET['fid']);
$query	= mysql_query($sql);
$num 	= mysql_num_rows($query);
if( $num > 0)
{
  $family = mysql_fetch_object($query);
  //print_r($family);die;
?>
        <div class="sitter_list_leftarea col-lg-10 col-md-10 col-sm-8 col-xs-12" style="border-right: 0px none;">
            <a href="javascript:void(null)" class="md-trigger contactBtn" data-modal="modal-directmsg">Contact Family</a><br /><br />
            <div class="input_outer" style="border-bottom: 1px dotted #f37354;">
                <label>First Name</label>
                <div class="input_area" style="color: #005982; font-weight: bold;">
                    <?=$family->user_first_name; ?>
                </div>
            </div>
            <div class="input_outer" style="border-bottom: 1px dotted #f37354;">
                <label>Last Name</label>
                <div class="input_area" style="color: #005982; font-weight: bold;">
                    <?=$family->user_last_name; ?>
                </div>
            </div>
            <div class="input_outer" style="border-bottom: 1px dotted #f37354;">
                <label>Zipcode</label>
                <div class="input_area" style="color: #005982; font-weight: bold;">
                    <?=(($family->location_code > 0) ? $family->location_code : ''); ?>
                </div>
            </div>
            <div class="input_outer" style="border-bottom: 1px dotted #f37354;">
                <label>Number of Children</label>
                <div class="input_area" style="color: #005982; font-weight: bold;">
                    <?=$family->user_cell_phone; ?>
                </div>
            </div>
            <div class="input_outer" style="border-bottom: 1px dotted #f37354;">
                <label>Ages of Children</label>
                <div class="input_area" style="color: #005982; font-weight: bold;">
                    <?=$family->user_contact_email; ?>
                </div>
            </div>
            <div class="input_outer" style="border-bottom: 1px dotted #f37354;">
                <label>Familiy Needs/Bio</label>
                <div class="input_area" style="color: #005982; font-weight: bold;">
                    <?=$family->user_contact_address; ?>
                </div>
            </div>
            <?php
            if ($family->user_image)
            {
                echo '<img src="images/user_images/' . $family->user_image . '" style="max-width: 300px;" alt="" title="" border="0" />';
            }

            ?>
        </div>
        <?php
        }
        else
        {
         ?>

            Family not found.

        <?php
        }
        ?>
      </div>
    </div>
  </div>
</section>
<?php include('includes/footer.php');?>