<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php  //echo $_SESSION['user_id'];exit;?>
<?php if((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='') || $_SESSION['user_type']!='family')
			{
				
			header('Location:/');
				
			}
			$search_query = mysql_query("select * from  user_information where user_id='".$_SESSION['user_id']."'");
if(mysql_num_rows($search_query)>0)
{
	$R = mysql_fetch_object($search_query);
	
}
else
{
	header('Location:'.$base_path.'/family_application.php');
	$changemsg = 'Update Your Account Information';
}
		?>
<section class="sitter_details_outer">
  <div class="container">
    <div class="sitter_detail_inner">
      <?php /*?>	<div class="sitter_detl_cont clearfix">
            	<div class="sitter_details_left col-lg-12 col-md-12 col-sm-12 col-xs-12">
            	<div class="sitter_detl_top">
                	<div class="sitter_left_pic">
                    	<div class="sitter_pic">
                            <img src="<?=$base_path?>/images/user_images/<?=$R->user_image?>" alt="" />
                        </div>
                    </div>
                    <div class="sitter_right_detl">
                    <?=$changemsg==''?'':$changemsg?>
                    	<div class="sitter_personal_detl sitr_detl_w">
                            <h3>Name</h3>
                            <p><?=$R->user_first_name?> <?=$R->user_middle_name?> <?=$R->user_last_name?></p>
                        </div>
                        
                        <div class="sitter_personal_detl sitr_detl_w">
                            <h3>Current Address</h3>
                            <p><?=$R->user_current_address?></p>
                        </div>
                        <div class="sitter_personal_detl sitr_detl_w">
                            <h3>Emergency Contact</h3>
                            <p><?=$R->user_emergency_contact?></p>
                        </div>
                        <div class="sitter_personal_detl sitr_detl_w">
                            <h3>Family Needs</h3>
                            <p><?=$R->user_contact_address?></p>
                        </div>
                    </div>
                </div>
                <?php /*?><div class="sitter_detl_bot">
                	<a href="<?=$base_path?>/family_application.php">Edit Account Info</a>
                    <a href="<?=$base_path?>/family_booking.php">Check booking Information</a>
                    &nbsp;
                    <a href="#" class="md-trigger" data-modal="modal-post-job">Post Job</a>
                    <a href="<?=$base_path?>/family_posting.php">Check Posted Jobs</a>
                    &nbsp;
                    
                   <a href="#" class="md-trigger" data-modal="modal-search">Search Sitter</a>
                   
                </div><?php 
                 <?php 
				 $search_date = mysql_query("select * from book_management where sitter_user_id='".base64_decode($_REQUEST['sitter_id'])."' and booking_status='1'");
				 if(mysql_num_rows($search_date)>0)
				 {
					 while($S = mysql_fetch_object($search_date))
					 {
						 $SD[] = "'".trim($S->booking_date)."'";
					 }
					 $val = implode(',',$SD);
				 }
				 
				 else
				 {
					 $val = "'09/19/2015','09/20/2015','09/02/2015'";
				 }
			 /// echo $val;
			///	echo  "'09/19/2015','09/20/2015','09/02/2015'";
            ///  $val = "'09/04/2015',' 09/10/2015',' 09/11/2015'";?>
            </div>
              
            </div>
           <div class="sitter_details_bottom">
                <ul>
                    <li><a href="#"><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Cpr Certified</a></li>
                    <li><a href="#"><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Relevance Checked</a></li>
                    <li><a href="#"><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Background Check</a></li>
                </ul>
            </div><?php */?>
      <?php
		$sql 		= "SELECT
					ui.user_id,
					(sum(rm.score)/COUNT(rm.score)) AS rating,
					CONCAT(ui.user_first_name,' ',ui.user_last_name) name,
					ui.user_image
				FROM
					review_management rm
				LEFT JOIN user_information ui ON rm.sitter_user_id = ui.user_id
				WHERE rm.review_status = '1'
				ORDER BY rating DESC
				LIMIT 0, 20";		
	  
	  $top_rated	= mysql_query($sql);
	  $num = mysql_num_rows($top_rated);
	  if( $num > 0) {
	  ?>
      
      <div class="sitter_app_heading">
        <h3>Top Rated Sitter</h3>
        </div>
        <div class="smartmarquee hscroller">
          <ul class="container">
          <?php while($top_rated = mysql_fetch_object($top_rated)) { 
		  	if($top_rated->name != "") {
		  ?>
            <li> 	<div class="sitters_list"> 
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="sitter_details_one">
                <div class="sitter_pic"> <a href="<?=$base_path?>/sitter_details.php?sitter_id=<?=base64_encode($top_rated->user_id)?>"><img src="<?=$base_path?>/images/user_images/<?=$top_rated->user_image?>" alt="" /></a> </div>
              </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="top-pad">
                      <div class="sitter_personal_detl">
                        <h3>Name</h3>
                        <p>
                          <?=$top_rated->name?>
                        </p>
                      </div>
                      <div class="sitter_personal_detl sitr_detl_w">
                        <h3>Bio</h3>
                        <p>
                          <?=$top_rated->user_description?>
                        </p>
                      </div>
                      <div class="sitter_personal_detl sitr_detl_w">
                        <h3>Rating</h3>
                        <p>
                          <?php
                          for($i = 1; $i <= $top_rated->rating; $i++) { ?>
                          <img src="<?=$base_path?>/images/star_full.png" alt="" />
                          <?php							  
						  }
						  ?>
                        </p>
                      </div>
                      <?php /*?><div class="sitter_personal_detl sitr_detl_w">
                                        <h3>Babysitting Experience</h3>
                                        <p>
                                        <?=$R->user_biography?>
                                        </p>
                                        </div><?php */?>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="top-pad">
                      <?php if($R->cpr_approve==1)
									{?>
                      <div class="sitter_personal_detl sitter_certified">
                        <h3><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span>Cpr Certified</h3>
                      </div>
                      <?php
									}
									?>
                      <?php if($R->newborn_approve==1)
									{?>
                      <div class="sitter_personal_detl sitter_certified">
                        <h3><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Reference Checked</h3>
                      </div>
                      <?php
									}
									?>
                      <div class="sitter_personal_detl sitter_certified">
                        <h3>
                          <p><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Background Check</p>
                        </h3>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!--<div class="sitter_details">
              <div class="sitter_pic"> <img src="<?=$base_path?>/images/user_images/<?=$R->user_image?>" alt="" /> </div>
            </div>
            <div class="sitter_details">
              <div class="sitter_personal_detl">
                <h3>Name</h3>
                <p>
                  <?=$R->user_first_name?>
                  <?=$R->user_last_name?>
                </p>
              </div>
              <div class="sitter_personal_detl sitr_detl_w">
                <h3>Bio</h3>
                <p>
                  <?=$R->user_description?>
                </p>
              </div>
              <div class="sitter_personal_detl sitr_detl_w">
                <h3>School Affiliation</h3>
                <p>
                  <?=$R->user_high_school=='yes'?$R->user_high_school_name:'NIL'?>
                </p>
              </div>
              <div class="sitter_personal_detl sitr_detl_w">
                <h3>Babysitting Experience</h3>
                <p>
                  <?=$R->user_biography?>
                </p>
              </div>
            </div>
            <div class="sitter_details">
              <div class="sitter_personal_detl sitter_certified">
                <h3><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Cpr Certified</h3>
              </div>
              <div class="sitter_personal_detl sitter_certified">
                <h3><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Relevance Checked</h3>
              </div>
              <div class="sitter_personal_detl sitter_certified">
                <h3><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Background Check</h3>
              </div>
            </div>--> 
        </a> </div>
              </li>
          <?php }
		  } ?>
          </ul>
        </div>
        <hr>
        <div class="sitter_app_heading">
        <h3>Current Sitter List</h3>
      </div>
      <?php 
	  }
	  
					$search_query_sql = "select *,UM.user_id  from user_management as UM
														JOIN
														user_information as UI 
														ON 
														UM.user_id=UI.user_id 
														WHERE 
														UM.user_type='sitter' 
														 AND user_status=1
														 order by join_date desc";
														
					$search_query = mysql_query($search_query_sql);
if(mysql_num_rows($search_query)>0)
{
	while($R = mysql_fetch_object($search_query))
	{
		 $search_booking_date_query =  "select * from book_management where sitter_user_id='".$R->user_id."' and sitter_approval!='2' and `booking_date` between '".$_REQUEST['search_from_date']."' and '".$_REQUEST['search_to_date']."' ";
		$search_booking_date = mysql_query($search_booking_date_query);
		?>
      <div class="sitters_list"> <a href="<?=$base_path?>/sitter_details.php?sitter_id=<?=base64_encode($R->user_id)?>">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="sitter_details_one">
                <div class="sitter_pic"> <img src="<?=$base_path?>/images/user_images/<?=$R->user_image?>" alt="" /> </div>
              </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="top-pad">
                      <div class="sitter_personal_detl">
                        <h3>Name</h3>
                        <p>
                          <?=$R->user_first_name?>
                          <?=$R->user_last_name?>
                        </p>
                      </div>
                      <div class="sitter_personal_detl sitr_detl_w">
                        <h3>Bio</h3>
                        <p>
                          <?=$R->user_description?>
                        </p>
                      </div>
                      <div class="sitter_personal_detl sitr_detl_w">
                        <h3>School Affiliation</h3>
                        <p>
                          <?=$R->user_high_school=='Yes'?$R->user_high_school_name:'NIL'?>
                        </p>
                      </div>
                      <?php /*?><div class="sitter_personal_detl sitr_detl_w">
                                        <h3>Babysitting Experience</h3>
                                        <p>
                                        <?=$R->user_biography?>
                                        </p>
                                        </div><?php */?>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="top-pad">
                      <?php if($R->cpr_approve==1)
									{?>
                      <div class="sitter_personal_detl sitter_certified">
                        <h3><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span>Cpr Certified</h3>
                      </div>
                      <?php
									}
									?>
                      <?php if($R->newborn_approve==1)
									{?>
                      <div class="sitter_personal_detl sitter_certified">
                        <h3><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Reference Checked</h3>
                      </div>
                      <?php
									}
									?>
                      <div class="sitter_personal_detl sitter_certified">
                        <h3>
                          <p><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Background Check</p>
                        </h3>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!--<div class="sitter_details">
              <div class="sitter_pic"> <img src="<?=$base_path?>/images/user_images/<?=$R->user_image?>" alt="" /> </div>
            </div>
            <div class="sitter_details">
              <div class="sitter_personal_detl">
                <h3>Name</h3>
                <p>
                  <?=$R->user_first_name?>
                  <?=$R->user_last_name?>
                </p>
              </div>
              <div class="sitter_personal_detl sitr_detl_w">
                <h3>Bio</h3>
                <p>
                  <?=$R->user_description?>
                </p>
              </div>
              <div class="sitter_personal_detl sitr_detl_w">
                <h3>School Affiliation</h3>
                <p>
                  <?=$R->user_high_school=='yes'?$R->user_high_school_name:'NIL'?>
                </p>
              </div>
              <div class="sitter_personal_detl sitr_detl_w">
                <h3>Babysitting Experience</h3>
                <p>
                  <?=$R->user_biography?>
                </p>
              </div>
            </div>
            <div class="sitter_details">
              <div class="sitter_personal_detl sitter_certified">
                <h3><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Cpr Certified</h3>
              </div>
              <div class="sitter_personal_detl sitter_certified">
                <h3><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Relevance Checked</h3>
              </div>
              <div class="sitter_personal_detl sitter_certified">
                <h3><span style="font-family: Arial Unicode MS, Lucida Grande">&#10004;</span> Background Check</h3>
              </div>
            </div>--> 
        </a> </div>
      <?php
	}
}
?>
    </div>
  </div>
</section>
<?php include('includes/footer.php');?>