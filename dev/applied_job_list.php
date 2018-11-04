<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php if((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='') || $_SESSION['user_type']!='sitter')
			{
				
				header('Location:/');
				
			}
			
		?>
<section class="sitter_list_outer">
  <div class="container">
    <div class="sitter_list_inner clearfix">
      <?php 
		$sql = "SELECT
	jm.job_id,
	jm.set_code,
	jm.family_user_id,
	jm.booking_date,
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
	jam.sitter_user_id
FROM
	job_management AS jm
LEFT JOIN jobapply_management AS jam ON jm.set_code = jam.job_id
WHERE
	jm.booking_status = 1
AND jm.sitter_approval = '0'
AND DATEDIFF(STR_TO_DATE(jm.booking_date, '%m/%d/%Y'), NOW()) > 0
GROUP BY
	jm.set_code
ORDER BY
	jm.job_id DESC";
$query	= mysql_query($sql);
$num 	= mysql_num_rows($query);
if( $num > 0) : while($job_available = mysql_fetch_object($query)):
	  
	  ?>
      <div class="sitter_list_leftarea col-lg-10 col-md-10 col-sm-8 col-xs-12 <?=$class?>">
        <?php //echo implode(',',$flag_arr_exist);?>
        <div class="sitter_left_cont">
          <div class="sitters_list">
            <div class="sitter_details">
              <div id='job_management<?=$job_history->set_code?>'></div>
            </div>
            <script>
			  $(function() {

				$('#job_management<?=$job_history->set_code?>').multiDatesPicker({
					defaultDate:'<?=$job_history->booking_date?>',
					disabled: true,
					addDates: [<?=$totaldate?>]
				});
				});
			  </script>
            <div class="sitter_details">
              <div class="sitter_personal_detl">
                <h3>Job Code - </h3>
                <p>
                  <?=$job_history->set_code?>
                </p>
              </div>
              <p><span>Time:</span>
                <?=$job_history->start_time?>
                -
                <?=$job_history->end_time?>
              </p>
              <p><span>No Of Kids:</span>
                <?=$job_history->no_of_kids?>
              </p>
              <p><span>Zipcode:</span>
                <?=$job_history->location_code?>
              </p>
              <p><span>Remarks:</span>
                <?=$job_history->remarks?>
              </p>
              <p>
              <table class="family-table">
                <tr>
                  <th><span>Appointment Date</span></th>
                  <th><span>Time</span></th>
                </tr>
                <?=$show_msg?>
              </table>
              </p>
              <p><span>Job Posted Date:</span>
                <?=date('m/d/Y',$job_history->booking_placed_date)?>
              </p>
              <p><span>Your Remarks : </span>
                <?=$R->remarks?>
              <p><span>Apply Date : </span>
                <?=date('m/d/Y',$R->applytime )?>
            </div>
          </div>
        </div>
      </div>
      <div class="sitter_list_rightarea col-lg-2 col-md-2 col-sm-4 col-xs-12">
        <div class="sitter_right_link">
          <?php 
		if($R->family_approval==1) { 
				echo '<span>You have already Get this Job</span>';
		}
		else {
			echo '<span>Wait For Family Approval</span>';
			?>
          <a class="md-trigger" href="<?=$base_path?>/cancel_job.php?id=<?=$R->job_id?>" >Cancel Application</a>
          <?php } ?>
        </div>
      </div>
      <?php endwhile; else:?>
      <div class="message">No Result Found</div>
      <?php endif;?>
    </div>
  </div>
</section>
<?php include('includes/footer.php');?>