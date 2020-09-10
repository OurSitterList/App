<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php if((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='') || $_SESSION['user_type']!='family')
			{
				
				header('Location:/');
				
			}
			
			$criteria = array();
            $executable = [];
			
			if(isset($_REQUEST['search_user_firstaid_training'])) {
				$criteria['user_firstaid_training'] = ':user_firstaid_training';
                $executable['user_firstaid_training'] = $_REQUEST['search_user_firstaid_training'];
			}
			if(isset($_REQUEST['search_user_cpr_training_yes'])) {
				$criteria['user_cpr_training'] = ':user_cpr_training';
				$executable['user_cpr_training'] = $_REQUEST['search_user_cpr_training'];
			}
			if(isset($_REQUEST['search_user_newborn_cpr_training'])) {
				$criteria['user_newborn_cpr_training'] = ':user_newborn_cpr_training';
				$executable['user_newborn_cpr_training'] = $_REQUEST['search_user_newborn_cpr_training'];
			}
			if(isset($_REQUEST['search_user_food_allergies'])) {
				$criteria['user_food_allergies'] = ':user_food_allergies';
				$executable['user_food_allergies'] = $_REQUEST['search_user_food_allergies'];
			}
			if(isset($_REQUEST['search_user_overnight'])) {
				$criteria['user_overnight'] = ':user_overnight';
				$executable['user_overnight'] = $_REQUEST['search_user_overnight'];
			}
			if(isset($_REQUEST['search_user_travel'])) {
				$criteria['user_travel'] = ':user_travel';
				$executable['user_travel'] = $_REQUEST['search_user_travel'];
			}
			if(isset($_REQUEST['search_user_permanent'])) {
				$criteria['user_permanent'] = ':user_permanent';
				$executable['user_permanent'] = $_REQUEST['search_user_permanent'];
			}
			if(isset($_REQUEST['search_user_newborn_exp'])) {
				$criteria['user_newborn_exp'] = ':user_newborn_exp';
				$executable['user_newborn_exp'] = $_REQUEST['search_user_newborn_exp'];
			}
			if(isset($_REQUEST['search_user_sick_kids'])) {
				$criteria['user_sick_kids'] = ':user_sick_kids';
				$executable['user_sick_kids'] = $_REQUEST['search_user_sick_kids'];
			}
			
			$sql_criteria = "";
			$executable_criteria = [];
			foreach($executable as $c => $k) {
				if($k == 'Yes') {
				    $sql_criteria .= ' AND UI.'.$c.' ='.$criteria[$c].' ';
                    $executable_criteria[$c] = $k;
                }
			}

            // free text search
            if (isset($_REQUEST['search_name']) && $_REQUEST['search_name'])
            {
                $sql_criteria .= " AND (UI.user_first_name LIKE :search_name " .
                "OR UI.user_last_name LIKE :search_name_last)";
                $executable_criteria['search_name'] = '%'.$_REQUEST['search_name'].'%';
                $executable_criteria['search_name_last'] = '%'.$_REQUEST['search_name'].'%';
            }

        if($_REQUEST['search_location_code']!='' || $_REQUEST['search_location_code']!=0) {
            $sql_criteria.=" AND UI.`location_code`=:location_code";
            $executable_criteria['location_code'] = $_REQUEST['search_location_code'];
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
					$search_query_sql.= $sql_criteria;

//          die($search_query_sql);
					$search_query = $db->get($search_query_sql,$executable_criteria);
if(count($search_query)>0)
{
	foreach($search_query as $R)
	{
		 $search_booking_date_query =  "select * from book_management where 
		 sitter_user_id='".$R->user_id."' and 
		 sitter_approval!='2'";
		 $executable = null;
		 if(isset($_REQUEST['search_from_date'])) {
		     $executable['search_from_date'] = $_REQUEST['search_from_date'];
             $executable['search_to_date'] = $_REQUEST['search_to_date'];
             $search_booking_date_query .= 'AND `booking_date` between :search_from_date and :search_to_date';
         }
		$search_booking_date = $db->query($search_booking_date_query,$executable);
		if($search_booking_date->rowCount() > 0)
		{
			
			$flag_arr_exist  =array();
			while($S = $search_booking_date->fetch())
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
