<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php
if ((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='')) {
	header('Location:/');
  exit();
}

$msg = '';
$from = (isset($_REQUEST['from']) && $_REQUEST['from'] === 'family') ? 'family' : 'sitter';
if ($from === 'family') {
  $backHref = 'family_application.php';
} else {
  $backHref = 'sitter_application.php';
}

// check submission
if (isset($_POST['user_email']) && isset($_POST['user_email2'])) {
  if ($_POST['user_email'] !== $_POST['user_email2']) {
    $msg = 'Email addresses do not match.';
  } else {

    $result = mysql_query("SELECT user_id
    FROM user_management
    WHERE user_email = '" . mysql_real_escape_string($_POST['user_email']) . "'
    AND user_id != '" . $_SESSION['user_id'] . "'");
    $user = mysql_fetch_assoc($result);
    $numrows = mysql_num_rows($result);

    if (mysql_error()) {
      $msg = 'An unexpected error has occurred.';
    } else if (mysql_num_rows($result) > 0) {
      $msg = 'That email address is already in use.';
    } else {
      $sql = "UPDATE user_management SET user_email = '" . mysql_real_escape_string($_POST['user_email']) . "'
      WHERE user_id = '" . $_SESSION['user_id'] . "'";
      $result = mysql_query($sql);

      if (mysql_error()) {
        $msg = 'An unexpected error has occurred.';
      } else {
        setPostMSG('Your email address has been updated successfully.', 'success');
        header("Location: " . $backHref);
        exit();
      }
    }
  }
}

$cancelButton = '<input type="button" value="Cancel" class="login_cancel_btn" onclick="document.location=\'' . $backHref . '\';" />';

			?>
<section class="sitter_app_outer">
  <div class="container">
    <div class="sitter_app_cont clearfix" style="padding-top: 25px;">
<?php if($msg!='')
	   {
?>
  <div class="alert alert-danger"><?=$msg?></div>
  <?php
 }
?>
      <div class="sitter_app_heading">
        <h3>Change Email Address</h3>
      </div>
      <form action="change_email.php?from=<?=$from; ?>" method="post" enctype="multipart/form-data" id="changeEmailForm">
        <div class="col-lg-12">
          <div class="left_form">
            <div class="input_outer">
              <label>New Email Address</label>
              <div class="input_area">
                <input type="text" class="input_lrg" name="user_email" id="user_email" value="" aria-required="true" />
              </div>
            </div>
            <div class="input_outer">
              <label>Re-Enter New Email Address</label>
              <div class="input_area">
                <input type="text" class="input_lrg" name="user_email2" id="user_email2" value="" aria-required="true" />
              </div>
            </div>
          </div>
        </div>

        <div style="clear:both;"></div>
        <input type="button" value="Save Changes" class="login_sub_btn" id="saveNewEmail" />
        <?=$cancelButton; ?>
      </form>
    </div>
  </div>
</section>
<script type="text/javascript">
$(document).ready(function(e) {

  $("#changeEmailForm").validate({
    rules: {
      user_email: {
        required: true,
        email: true
      },
      user_email2: {
        required: true,
        email: true
      }
    },
    messages: {
      user_email:  {
        required: "Please enter a valid email address",
        email: "Please enter a valid email address"
      },
      user_email2:  {
        required: "Please enter a valid email address",
        email: "Please enter a valid email address"
      }
    }
  });

  $('#saveNewEmail').click(function(e) {
    var val1 = $('#user_email').val().trim();
    var val2 = $('#user_email').val().trim();

    if (!val1 || !val2) {
      alert('Please fill out both email address fields.');
      return;
    }
    if (!val1 || val1 !== val2) {
      alert('Email addresses do not match.');
      return;
    }

    // submit
    $('#changeEmailForm').submit();
  });
});
</script>
<?php include('includes/footer.php');?>
