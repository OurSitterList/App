<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php if(!isset($_SESSION['user_id']) && $_SESSION['user_id']=='')
			{
				
				header('Location:'.$base_path);
				
			}
?>
<section class="sitter_details_outer">
	<div class="container">
          <div class="sitter_app_heading">
        <h3>Reviews and Ratings</h3>
        </div>
		<?php
                $sql = "SELECT
					book_management.booking_date,
					CONCAT(user_information.user_first_name,' ',user_information.user_last_name) AS `name`,
					user_information.user_image,
					review_management.family_user_id,
					review_management.review_status,
					review_management.score,
					review_management.review_message
					FROM
					review_management
					LEFT JOIN user_information ON user_information.user_id = review_management.family_user_id
					LEFT JOIN book_management ON book_management.book_id = review_management.book_id
					WHERE
					review_management.sitter_user_id = ".$_SESSION['user_id']."
					ORDER BY
					book_management.booking_date DESC
					LIMIT 0, 20
					";		
              
              $query	= mysql_query($sql);
              $num 		= mysql_num_rows($query);
              if( $num > 0) {
				  ?>
    	<div class="sitter_detail_inner">
        <?php while($reviews = mysql_fetch_object($query)) { ?>
<div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="sitter_details_one">
                <div class="sitter_pic"> <a href="<?=$base_path?>/family_details.php?sitter_id=<?=base64_encode($reviews->family_user_id)?>"><img src="<?=$base_path?>/images/user_images/<?=$reviews->user_image?>" alt="" /></a> </div>
              </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="top-pad">
                      <div class="sitter_personal_detl">
                        <h3>Booking Date</h3>
                        <p>
                          <?=$reviews->booking_date?>
                        </p>
                      </div>
                      <div class="sitter_personal_detl">
                        <h3>Name</h3>
                        <p>
                          <?=$reviews->name?>
                        </p>
                      </div>
                      <div class="sitter_personal_detl sitr_detl_w">
                        <h3>Review</h3>
                        <p>
                          <?=$reviews->review_message?>
                        </p>
                      </div>
                      <div class="sitter_personal_detl sitr_detl_w">
                        <h3>Rating</h3>
                        <p>
                          <?php
                          for($i = 1; $i <= $reviews->score; $i++) { ?>
                          <img src="<?=$base_path?>/images/star_full.png" alt="" />
                          <?php							  
						  }
						  ?>
                        </p>
                      </div>
                    </div>
                  </div>                  
                </div>
              </div>
            </div>
          </div>
        </div>    
        <?php } ?>    
        </div>
        <?php
			  }
			  else {
				  echo "<p>No review at this moment. $sql</p>";
			  }
		?>
		
    </div>
</section>
<?php include('includes/footer.php');?>