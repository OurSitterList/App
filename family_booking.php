<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php if((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='') || $_SESSION['user_type']!='family')
	{

		header('Location:/');
		exit;

	}
	else if (isset($_SESSION['_sub_expired']) && $_SESSION['_sub_expired'] === true)
	{
		header('Location:'.$base_path.'/family_app_member.php?expired=1');
		exit;
	}
		
		?>
<section class="sitter_app_outer">
	<div class="container">
    	<div class="sitter_app_cont clearfix">
        	<div class="sitter_app_heading">
            	<h3>Family Booking History
                </h3>
            </div>
            <div id='family_booking_calender'></div>
            <?php 
				$review = 'false';
				 $search_date = mysql_query("select distinct booking_date, sitter_approval, book_id, sitter_user_id, family_user_id
				 							 from book_management 
											 where family_user_id='".$_SESSION['user_id']."' 
											 		and booking_status='1'");
				 if(mysql_num_rows($search_date)>0)
				 {
					 while($S = mysql_fetch_object($search_date))
					 {
						$book_id = mysql_fetch_object(mysql_query("select * from book_management where family_user_id='".$_SESSION['user_id']."' and booking_status='1' and booking_date='".$S->booking_date."'"))->book_id;
						$sitter_details = mysql_fetch_object(mysql_query("select * from user_information where user_id='".$S->sitter_user_id."'"));
												
						if( strtotime($S->booking_date) < strtotime('now') ) {
							$status = 'Expired';
							$title = 'Expired Booking';
							
							//if exprired and has been approved. Allow to add rating
							if($S->sitter_approval==1)
							{
								$sql = "select * from review_management where book_id='".$book_id."'";
								$review_details = mysql_fetch_object(mysql_query($sql));
								//check if previously reviewed
								$review = 'true';
							}
						}
						else
						{

							if ((int)$S->sitter_approval==3)
							{
								$status = 'Declined';
								$title = 'Declined';

							}
							else if ((int)$S->sitter_approval==0)
							{
							$status = 'Not Confirmed';	
							$title = 'Check Details';
							
							}
							elseif ((int)$S->sitter_approval==2)
							{
								$status = 'Cancelled';
								$title = 'Check Details';

							}
							else
							{
								$status = 'Confirmed';	
								$title = 'Check Details';
							}
							
						}
						//echo "select * from book_management as BM  JOIN message_management as MM where BM.book_id = MM.book_id and BM.family_user_id='".$_SESSION['user_id']."' and BM.booking_status='1' and BM.booking_date='".$S->booking_date."' and MM.send_by='S' and is_view='0'";
						$already_notify_booking = mysql_query("select * from book_management as BM  JOIN message_management as MM where BM.book_id = MM.book_id and BM.family_user_id='".$_SESSION['user_id']."' and BM.booking_status='1' and BM.booking_date='".$S->booking_date."' and MM.send_by='S' and is_view='0'");
							if(mysql_num_rows($already_notify_booking)>0)
							{
								$class_notify = 'notify_me';
							}
							else
							{
								$class_notify = '';
							}
						 $calender_event.="{
											id: '".$book_id."',
											booking_id: '".$book_id."',
											sitter_user_id: '".$S->sitter_user_id."',
											family_user_id: '".$S->family_user_id."',
											title: '".$title."',
											name: '".$sitter_details->user_first_name.' '.$sitter_details->user_last_name."',
											start: '".trim($S->booking_date)."',
											status: '".$status."',
											review: '".$review."',
											date: '".trim($S->booking_date)."',
											className:'".$class_notify."',
											},";
					 }
					
				 }
				
				 else
				 {
					 $val = "";
				 }
				
				 ?>
            
        </div>
    </div>
</section>

<?php include('includes/footer.php');?>
