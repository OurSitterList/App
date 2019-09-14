<?php
	include("classes/AdminStructure.php");
	include_once("./fckeditor/fckeditor.php");

date_default_timezone_set ( 'America/Chicago' );


	class Settings extends AdminStructure
	{
		function Home($title)
		{
			parent::AdminStructure($title);
		}


		function conDition()
		{
			$page_id = 18;
			$con = new DBConnection(host, user, pass, db);
			$conObj = $con->connectDB();

			if ($_SESSION['ANAME'] !== 'admin') {
				print_r($_SESSION);
				die;
				header('Location: /home.php');
				exit();
			}
		}


		function jScripts()
		{
		}

		function body()
		{


			?>


			<!--************************PAGE BODY***************************-->


			<?php
			$page_id = 18;
			$access_val = mysql_fetch_object(mysql_query("SELECT * FROM user_management WHERE user_id=" . $_SESSION['AID']));
			$child_action = explode(',', $access_val->child_action);
			$view = 0;


			$con = new DBConnection(host, user, pass, db);


			$conObj = $con->connectDB();

			extract($_REQUEST);

			?>


			<script language="javascript" type="text/javascript" src="js/jquery.js"></script>


			<script language="javascript" type="text/javascript">

				function askDeleteJob(jobId, jobSetCode, startTime, endTime, pageId)
				{
					var askme = window.confirm('Are you sure you would like to delete job id ' + jobSetCode + ' from ' + startTime + ' to ' + endTime + '?');
					if (askme)
					{
						document.location = 'deletejob.php?id=' + jobId + '&page=' + pageId;
					}
				}

			</script>

			<?php
				$hour = date('H');
				$curdate = date('Y-m-d');

				$pageID = (isset($_REQUEST['page']) && $_REQUEST['page']) ? $_REQUEST['page'] : '0';

				$Q = "SELECT j.*, CONCAT(ufam.user_first_name, ' ', ufam.user_last_name) AS family_name
				FROM `job_management` j
				LEFT JOIN user_information ufam ON ufam.user_id = j.family_user_id
				WHERE STR_TO_DATE(j.booking_date, '%m/%d/%Y') >= '" . $curdate . "'
				AND (
					STR_TO_DATE(j.booking_date, '%m/%d/%Y') > '" . $curdate . "'
					OR end_time >= " . $hour . "
				)
				ORDER BY STR_TO_DATE(j.booking_date, '%m/%d/%Y'), j.start_time, j.end_time";
			?>

			<div class="box grid_8">
				<div style="display: flex; flex: 1; justify-content: flex-end; align-items: center; padding-bottom: 10px; padding-right: 10px;">
					<div style="display: none">
						<?php
							$wallerQuery = "SELECT um.user_id as FamilyUserId,
												   um.user_name as FamilyUsername,
												   um.user_email as FamilyEmail,
												   j.job_id as JobId,
												   j.set_code as JobSetCode,
												   j.booking_date as BookingDate,
												   j.booking_placed_date as BookingDateInSeconds,
												   j.start_time as StartTime,
												   j.end_time as EndTime,
												   j.no_of_kids as NumberOfKids,
												   j.location_code as LocationCode,
												   j.remarks as Remarks
											FROM job_management j
											LEFT JOIN user_management um ON um.user_id = j.family_user_id
											WHERE um.user_email LIKE '%waller%'
											AND um.user_type = 'family'
											AND um.promo_code = 1
											AND STR_TO_DATE(j.booking_date, '%m/%d/%Y') > DATE('2018-12-31')
											ORDER BY STR_TO_DATE(j.booking_date, '%m/%d/%Y') DESC, j.start_time, j.end_time;";
							$rsSearchResults = mysql_query($wallerQuery, $conObj) or die(mysql_error());
							$out = '';
							while ($l = mysql_fetch_array($rsSearchResults)) {
								for ($i = 0; $i < 12; $i++) {
									$out .='"'.$l["$i"].'",';
								}
								$out .="\n";
							}
							echo $out;
						?>
						<script language="javascript" type="text/javascript">
							var url = "data:text/csv;charset=utf-8," + encodeURIComponent(`<?= $out ?>`);
							document.getElementById('CsvDownload').href = url;
						</script>
					</div>
					<a id="CsvDownload" href="data:text/csv;charset=utf-8," download="report.csv">Download Waller Report</a>
				</div>
				<div class="box-head">
					<h2>Job List</h2>
				</div>
				<div class="box-content ad-stats">
					<table border="0" class="border" style="margin:0px; width:100%;">
						<thead>
						<tr bordercolor="#000000" class="border" border="1">
							<!--<th class="tablehead" align="center"><input type="checkbox" id="check" name="check"/></th>-->
							<th align="center" class="tablehead">Job Id</th>
							<th align="center" class="tablehead">Job Date</th>
							<th align="center" class="tablehead">Job Time</th>
							<th align="center" class="tablehead">Family</th>
							<th align="center" class="tablehead">Remarks</th>
							<th align="center" class="tablehead">Sitter</th>
							<th width="150" align="center" class="tablehead">Delete</th>
						</tr>
						</thead>


						<?php
						$Rec = mysql_query($Q, $conObj) or die(mysql_error());
						$paging = new Pagination('ui-state-disabled', 'fg-button ui-button ui-state-default', 'next fg-button ui-button ui-state-default');
						$paging->numData = mysql_num_rows($Rec);
						$paging->toShowData = 20;
						$paging->toShowNumbers = 9;
						$paging->numSeperator = '';
						$Q = $paging->queryBuilder($Q);
						$Rec = mysql_query($Q, $conObj) or die(mysql_error());
						?>

						<tbody>

						<?php


						$N = mysql_num_rows($Rec);


						if ($N) {


							mysql_data_seek($Rec, 0);

							$count = 0;


							while ($R = mysql_fetch_object($Rec)) {
								$count++;
								if ($count == 1) {
									$class = 'odd';
								} else {
									$class = 'even';
									$count = 0;
								}
								?>
								<tr class="<?= $class ?>">
									<!--<td align="center"><input type="checkbox" name="chk[]" class="chk" id="chk" value="<?= $R->id ?>"/></td>-->
									<td><?= $R->set_code ?></td>
									<td><?= date('d M, Y', strtotime($R->booking_date)) ?></td>

									<td><?php

										if ((int)$R->start_time > 12)
										{
											$startTime = ((int)$R->start_time - 12) . ':00pm';
										}
										elseif ((int)$R->start_time === 12)
										{
											$startTime = '12:00pm';
										}
										else
										{
											$startTime = $R->start_time . ':00am';
										}

										echo $startTime;
										echo ' - ';

										if ((int)$R->end_time > 12)
										{
											$endTime = ((int)$R->end_time - 12) . ':00pm';
										}
										elseif ((int)$R->end_time === 12)
										{
											$endTime = '12:00pm';
										}
										else
										{
											$endTime = $R->end_time . ':00am';
										}
										echo $endTime;

										?></td>

									<td><?=$R->family_name; ?></td>
									<td><?=rawurldecode($R->remarks); ?></td>
									<td><?php
										//$R->sitter_name;


										$q2 = "SELECT jm.family_approval, CONCAT(usit.user_first_name, ' ', usit.user_last_name) AS sitter_name
										FROM jobapply_management jm
										JOIN user_information usit ON usit.user_id = jm.sitter_user_id
										WHERE jm.job_id = " . $R->set_code . "
										ORDER BY usit.user_first_name, usit.user_last_name";
										$apply = mysql_query($q2, $conObj) or die(mysql_error());

										if (mysql_num_rows($apply) > 0)
										{
											echo '<ul>';

											while ($r2 = mysql_fetch_object($apply)) {
											?>
												<li><?php
													echo $r2->sitter_name;
													if ((int)$r2->family_approval === 1)
													{
														echo ' (Family approved)';
													}
													?></li>
											<?php
											}

											echo '</ul>';
										}

										?></td>

									<?php /* <td  align="center"><?php if(in_array ($page_id.'view' , $child_action ) ||  $_SESSION['ATYPE']!='sub_admin')

{?><a href="sitter_entry.php?mode=edit&case_id=<?=$R->user_id?>" class="view_new" name="<?=$R->case_id?>"><input  type="button" class="button green_edit"  name="view" value="Edit" /></a><?php }else { echo '<input  type="button" class="button grey_view"  name="edit" value="View" />';}?></td>

*/
									?>

									<td align="center"><a href="javascript:void(null);" class="dropjob" onclick="askDeleteJob(<?=$R->job_id; ?>, <?=$R->set_code; ?>, '<?=$startTime; ?>', '<?=$endTime; ?>', <?=$pageID; ?>)"><input type="button" class="button red_delete" name="delete" value="Delete"/></a></td>
								</tr>


							<?php } ?>


							<tr>


								<td align="center">&nbsp;</td>


								<td align="center" colspan="8">
									<div
										class="dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi ui-buttonset-multi paging_full_numbers"
										id="dt3_paginate">


										<?= $paging->paginationPanel(); ?></div>
								</td>


							</tr>


							<?php


						} else {


							?>


							<tr id="trempty">


								<td colspan="9" align="center">Sorry! No Records Found.</td>


							</tr>


							<?php


						}


						?>


						</tbody>

					</table>

				</div>

			</div>


			<?php

		}


		function bodyAdmin()
		{


			$this->head();
			$this->toppanel();
			$this->menu();
			$this->body();

		}
	}


?>