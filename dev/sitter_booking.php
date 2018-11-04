<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php if((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='') || $_SESSION['user_type']!='sitter')
			{
				
				header('Location:/');
				
			}
		
		?>
<section class="sitter_app_outer">
	<div class="container">
    	<div class="sitter_app_cont clearfix">
        	<div class="sitter_app_heading">
            	<h3>Sitter Booking Information
                </h3>
            </div>
            <div id='booking_calender'></div>
            <?php 
				 $search_date = mysql_query("select distinct booking_date from book_management where sitter_user_id='".$_SESSION['user_id']."' and booking_status='1'");
				 if(mysql_num_rows($search_date)>0)
				 {
					 while($S = mysql_fetch_object($search_date))
					 {
						$B_details = mysql_fetch_object(mysql_query("select * from book_management where sitter_user_id='".$_SESSION['user_id']."' and booking_status='1' and booking_date='".$S->booking_date."'"));
						$book_id =$B_details->book_id;
						$family_details = mysql_fetch_object(mysql_query("select * from user_information where user_id='".$B_details->family_user_id."'"));
						
						if( strtotime($S->booking_date) < strtotime('now') ) {
							$status = 'Expired';
							$title = 'Expired Booking';
						}
						else
						{
							
							if($B_details->sitter_approval==0)
							{
							$status = 'Not Confirmed';	
							$title = 'Check Details';
							}
							elseif($B_details->sitter_approval==2)
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
						//echo "select * from book_management as BM  JOIN message_management as MM where BM.book_id = MM.book_id and BM.sitter_user_id='".$_SESSION['user_id']."' and BM.booking_status='1' and BM.booking_date='".$S->booking_date."' and MM.send_by='F' and is_view='0'";
													$already_notify_booking = mysql_query("select * from book_management as BM  JOIN message_management as MM where BM.book_id = MM.book_id and BM.sitter_user_id='".$_SESSION['user_id']."' and BM.booking_status='1' and BM.booking_date='".$S->booking_date."' and MM.send_by='F' and is_view='0'");
							if(mysql_num_rows($already_notify_booking)>0)
							{
								$class_notify = 'notify_me';
							}
							else
							{
								$class_notify = '';
							}
						 $calender_event.="{
											title: '".$title."',
											id: '".$book_id."',
											start: '".trim($S->booking_date)."',
											date: '".trim($S->booking_date)."',
											status: '".$status."',
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
