<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php if((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='') || $_SESSION['user_type']!='sitter')
			{

				header('Location:'.$base_path);

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
}
$myaccount = new myAccount();
?>
<section class="sitter_details_outer">
  <div class="container">
    <div class="sitter_detail_inner">
      <div class="sitter_details_bottom">
        <div class="sitter_app_heading">
          <h3>Current Job Offers</h3>
        </div>
        <?php


$useLocationId = (isset($_REQUEST['location_id']) && preg_match('/^[1-9]+[0-9]*$/', $_REQUEST['location_id']) > -1) ? $_REQUEST['location_id'] : $_SESSION['user_location_id'];

		$sql = "SELECT
	jm.job_id,
	jm.set_code,
	jm.family_user_id,
	jm.booking_date,
	jm.start_time,
	@booking_date := STR_TO_DATE(jm.booking_date, '%m/%d/%Y'),
	@date_diff := DATEDIFF(@booking_date, NOW()),
	@date_diff AS days_left,
	(
		FROM_UNIXTIME(
			jm.booking_placed_date,
			'%m/%d/%Y'
		)
	)AS job_posted_date,
(
		SELECT
			GROUP_CONCAT(
				'\'',
				jm2.booking_date,
				'\'' SEPARATOR ','
			)		FROM
			job_management AS jm2
		WHERE
			jm.set_code = jm2.set_code
	)AS dates_in_job,
(
		SELECT
			GROUP_CONCAT(
				TIME_FORMAT(CONCAT(jm2.start_time,':00:00'), '%h:%i %p'),
				'-',
				TIME_FORMAT(CONCAT(jm2.end_time,':00:00'), '%h:%i %p')
				SEPARATOR ' / '
			)
		FROM
			job_management AS jm2
		WHERE
			jm.set_code = jm2.set_code
	)AS time_in_job,
	(
		SELECT
			GROUP_CONCAT(
				'<tr><td><span>',
				jm2.booking_date,
				'</span></td><td><span>',
				TIME_FORMAT(CONCAT(jm2.start_time,':00:00'), '%h:%i %p'),
				'-',
				TIME_FORMAT(CONCAT(jm2.end_time,':00:00'), '%h:%i %p'),
				'</span></td></tr>' SEPARATOR ''
			)AS sched
		FROM
			job_management AS jm2
		WHERE
			jm.set_code = jm2.set_code
	)AS sched,
	jm.no_of_kids,
	jm.location_code,
	jm.remarks,
	jm.sitter_approval,
	jam.family_approval,
	jam.sitter_user_id,
	ui.user_first_name,
    ui.user_middle_name,
    ui.user_last_name
FROM job_management AS jm
LEFT JOIN jobapply_management AS jam ON jm.set_code = jam.job_id AND jam.family_approval = '1'
LEFT JOIN user_management AS um ON um.user_id = jm.family_user_id
LEFT JOIN user_information AS ui ON ui.user_id = um.user_id
WHERE jm.location_id = " . $useLocationId . "
AND jm.booking_status = 1
AND jm.sitter_approval = '0'
AND DATEDIFF(STR_TO_DATE(jm.booking_date, '%m/%d/%Y'), NOW()) >= 0
GROUP BY jm.set_code
ORDER BY jam.family_approval, jm.job_id DESC";
$query	= mysql_query($sql);
$num 	= mysql_num_rows($query);

$msg = getPostMSG();
if ($msg)
{
  $msgType = getPostMSGType();
  echo '<div class="alert alert-' . $msgType . '">' . $msg . '</div>';
}


if( $num > 0) :

  $now = time();
//  $now -= 18000;
  while($job_available = mysql_fetch_object($query)):
    $tsplit = explode('/', $job_available->booking_date);

//    echo $tsplit[2] . '-' . $tsplit[0] . '-' . $tsplit[1] . ' ' . $job_available->start_time;
//    echo strtotime($tsplit[2] . '-' . $tsplit[0] . '-' . $tsplit[1] . ' ' . $job_available->start_time . ':00-05:00') . ' / ' . $now;
    if (strtotime($tsplit[2] . '-' . $tsplit[0] . '-' . $tsplit[1] . ' ' . $job_available->start_time . ':00:00-05:00') < $now)
    {
        continue;
    }
?>
        <div class="sitter_list_leftarea col-lg-10 col-md-10 col-sm-8 col-xs-12">
          <?php //echo implode(',',$flag_arr_exist);?>
          <div class="sitter_left_cont">
            <div class="sitters_list">
              <div class="sitter_details">
                <div id='job_management<?=$job_available->set_code?>'></div>
              </div>
              <script>

			  $(function() {
				$('#job_management<?=$job_available->set_code?>').multiDatesPicker({
					defaultDate:'<?=$job_available->booking_date?>',
					disabled: true,
					addDates: [<?=$job_available->dates_in_job?>]
				});
				});
			  </script>
              <div class="sitter_details">
                <div class="sitter_personal_detl">
                  <h3>Job Code - </h3>
                  <p>
                    <?=$job_available->set_code?>
                  </p>
                </div>
                <p><span>Time:</span>
                  <?=$job_available->time_in_job?>
                </p>
                <p><span>No Of Kids:</span>
                  <?=$job_available->no_of_kids?>
                </p>
                <p><span>Location:</span>
                  <?=$job_available->location_code?>
                </p>
                <p><span>Remarks:</span>
                  <?=$job_available->remarks?>
                </p>
                <p><span>Family:</span>
                  <?='<a href="family.php?fid=' . $job_available->family_user_id . '&fh=' . md5($job_available->family_user_id) . '">' . $job_available->user_first_name . ' ' . $job_available->user_last_name . '</a>';?>
                </p>
                <table class="family-table">
                  <tr>
                    <th><span>Appointment Date</span></th>
                    <th><span>Time</span></th>
                  </tr>
                  <?=$job_available->sched?>
                </table>
                <p>&nbsp;</p>
                <p><span>Job Posted Date:</span>
                  <?=$job_available->job_posted_date?>
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="sitter_list_rightarea col-lg-2 col-md-2 col-sm-4 col-xs-12">
          <div class="sitter_right_link">

            <?php


            if ($job_available->family_approval == 1)
            {
              ?>
              <span>Booked</span>
              <?php

              /*if($job_available->sitter_user_id == $_SESSION['user_id'])
              {

                ?>
                <a class="md-trigger" href="<?= $base_path ?>/cancel_job.php?id=<?= $job_available->set_code ?>">Cancel Application</a>
                <?php
              }*/
            }
            else if($job_available->sitter_user_id == $_SESSION['user_id'])
            {
              ?>
              <span>You have already applied to this job</span>
              <a class="md-trigger" href="<?= $base_path ?>/cancel_job.php?id=<?= $job_available->set_code ?>">Cancel Application</a>

              <?php

            }
            elseif(($time_slot = $myaccount->check_availability_by_job_id($job_available->job_id)) != 'available') {
              ?>
              <?php
//              mail('sethcriedel@gmail.com', 'TIME SLOT - ' . $job_available->job_id, '"' . print_r($time_slot, true) . '"\nEND');
              if (is_object($time_slot)) {
                ?>
                <!--time_slot:<?php print_r($time_slot); ?>-->
                <span>
                <p class="text-primary"><strong><?= ucfirst($time_slot->day_name); ?> Availability</strong></p>
                <?php

                if (isset($time_slot->sched) && is_array($time_slot->sched)) {
                  foreach ($time_slot->sched as $time) {

                    ?>
                    <small><i class="glyphicon glyphicon-triangle-right" aria-hidden="true"></i></small><?= $time; ?>
                    <br>
                    <?php
                  }
                }

                ?>
                <br>
                <p class="text-danger">
                  <small>You cannot apply for this job offer</small>
                </p>
                <?php
                if (isset($time_slot->reason) && is_array($time_slot->reason)) {
                  foreach ($time_slot->reason as $reason) {
                    ?>
                    <p class="label label-danger">
                      <small><?= ucfirst($reason); ?></small>
                    </p>
                    <?php
                  }
                }
                ?>
                <?php
              } else {

                ?>
                <a class="md-trigger">Job Expired</a>
                <?php

              }
              ?>
              </span>

              <?php
            }
            else {
              ?>
              <span><a class="md-trigger" data-modal="apply-job"
                       onClick="set_the_code(<?= $job_available->set_code ?>)">Apply to this job</a></span>
              <?php
            }
            ?>
           </div>
        </div>
        <?php endwhile; else : ?>
        <div class="message">No Result Found for <?= $locations[$useLocationId]; ?></div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php include('includes/footer.php');?>
