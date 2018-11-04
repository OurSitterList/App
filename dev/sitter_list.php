<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php if((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='') || $_SESSION['user_type']!='family')
			{
				
				header('Location:/');
				
			}
			
			$criteria = array();
			
			if(isset($_REQUEST['search_user_firstaid_training'])) {
				$criteria['user_firstaid_training'] = $_REQUEST['search_user_firstaid_training'];
			}
			if(isset($_REQUEST['search_user_cpr_training_yes'])) {
				$criteria['user_cpr_training'] = $_REQUEST['search_user_cpr_training'];
			}
			if(isset($_REQUEST['search_user_newborn_cpr_training'])) {
				$criteria['user_newborn_cpr_training'] = $_REQUEST['search_user_newborn_cpr_training'];
			}
			if(isset($_REQUEST['search_user_food_allergies'])) {
				$criteria['user_food_allergies'] = $_REQUEST['search_user_food_allergies'];
			}
			if(isset($_REQUEST['search_user_overnight'])) {
				$criteria['user_overnight'] = $_REQUEST['search_user_overnight'];
			}
			if(isset($_REQUEST['search_user_travel'])) {
				$criteria['user_travel'] = $_REQUEST['search_user_travel'];
			}
			if(isset($_REQUEST['search_user_permanent'])) {
				$criteria['user_permanent'] = $_REQUEST['search_user_permanent'];
			}
			if(isset($_REQUEST['search_user_newborn_exp'])) {
				$criteria['user_newborn_exp'] = $_REQUEST['search_user_newborn_exp'];
			}
			if(isset($_REQUEST['search_user_sick_kids'])) {
				$criteria['user_sick_kids'] = $_REQUEST['search_user_sick_kids'];
			}
			
			$sql_criteria = "";
			foreach($criteria as $c => $k) {
				if($k == 'Yes') $sql_criteria .= ' AND UI.'.$c.' = "'.$k.'" ';
			}			
		?>

<section class="sitter_list_outer">
  <div class="container">
    <div class="sitter_list_inner clearfix">
      <div class="sitter_list_leftarea col-lg-10 col-md-10 col-sm-8 col-xs-12">
        <div class="sitter_left_cont">
          <?php 
					 $search_query_sql = "select *,UM.user_id  from user_management as UM
														LEFT JOIN
														user_information as UI 
														ON 
														UM.user_id=UI.user_id 
														WHERE 
														UM.user_type='sitter' AND UM.user_status='1'";
														if($_REQUEST['search_location_code']!='' || $_REQUEST['search_location_code']!=0)
														{
															$search_query_sql.=" AND UI.`location_code`='".$_REQUEST['search_location_code']."'";
														}
					$search_query_sql.= $sql_criteria;

					$search_query = mysql_query($search_query_sql);
if(mysql_num_rows($search_query)>0)
{
	while($R = mysql_fetch_object($search_query))
	{
		 $search_booking_date_query =  "select * from book_management where 
		 sitter_user_id='".$R->user_id."' and 
		 sitter_approval!='2' 
		 and `booking_date` between '".$_REQUEST['search_from_date']."' and '".$_REQUEST['search_to_date']."' 
		 ";
		$search_booking_date = mysql_query($search_booking_date_query);
		if(mysql_num_rows($search_booking_date)>0)
		{
			
			$flag_arr_exist  =array();
			while($S=mysql_fetch_object($search_booking_date))
			{
				$allocation_arr	=array();
			for($i = $S->start_time;$i<$S->end_time;$i++)
							{
							$allocation_arr[]= $i;
							}
							$allocation_arr = array_unique($allocation_arr);
		//var_dump($allocation_arr);
		//	echo '<br>____________________________________________<br>';
			
				
				for($j=1;$j<=23;$j++)
					{
						
					if(in_array($j,$allocation_arr))
						{
						$flag_arr_exist[] = 0;	
						}
						else
						{
							$flag_arr_exist[] = 1;	
						}
					}
							
			}
			
			if(in_array('1',$flag_arr_exist))
			{
					?>
          <div class="sitters_list"> 
          <a href="<?=$base_path?>/sitter_details.php?sitter_id=<?=base64_encode($R->user_id)?>">
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
                                        <h3>Cpr Certified</h3>
                                        </div>
                                        <?php
									}
									?>
                                    <?php if($R->newborn_approve==1)
									{?>
                                        <div class="sitter_personal_detl sitter_certified">
                                        <h3>Reference Checked</h3>
                                        </div>
                                          <?php
									}
									?>
                                   
                                        <div class="sitter_personal_detl sitter_certified">
                                        <h3>Background Check</h3>
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
                   <?=$R->user_high_school=='Yes'?$R->user_high_school_name:'NIL'?>
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
                <h3>Cpr Certified</h3>
              </div>
              <div class="sitter_personal_detl sitter_certified">
                <h3>Relevance Checked</h3>
              </div>
              <div class="sitter_personal_detl sitter_certified">
                <h3>Background Check</h3>
              </div>
            </div>-->
            </a> </div>
          <?php
			}
		}
		else
		{
		?>
          <div class="sitters_list"> 
          <a href="<?=$base_path?>/sitter_details.php?sitter_id=<?=base64_encode($R->user_id)?>">
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
                                        <h3>Cpr Certified</h3>
                                        </div>
                                        <?php
									}
									?>
                                    <?php if($R->newborn_approve==1)
									{?>
                                        <div class="sitter_personal_detl sitter_certified">
                                        <h3>Reference Checked</h3>
                                        </div>
                                          <?php
									}
									?>
                                    <?php if($R->background_approve==1)
									{?>
                                        <div class="sitter_personal_detl sitter_certified">
                                        <h3>Background Check</h3>
                                        </div>
                                          <?php
									}
									?>
                                   
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
                   <?=$R->user_high_school=='Yes'?$R->user_high_school_name:'NIL'?>
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
                <h3>Cpr Certified</h3>
              </div>
              <div class="sitter_personal_detl sitter_certified">
                <h3>Relevance Checked</h3>
              </div>
              <div class="sitter_personal_detl sitter_certified">
                <h3>Background Check</h3>
              </div>
            </div>-->
            </a> </div>
          <?php
		}
		
	}
}
?>
        </div>
      </div>
      <div class="sitter_list_rightarea col-lg-2 col-md-2 col-sm-4 col-xs-12">
        <div class="sitter_right_link"> <a href="#">Back To Sitter Menu</a> </div>
        <div class="sitter_right_link"> <a href="#">Top Rated Sitter Feed</a> </div>
      </div>
    </div>
  </div>
</section>
<?php include('includes/footer.php');?>
