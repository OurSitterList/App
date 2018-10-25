<?php include('includes/connection.php');?>
<?php include('includes/header-ajax.php');?>
<?php if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='')
			{
				if($_SESSION['user_type']=='sitter')
				{
				header('Location:'.$base_path.'/sitter_dashboard.php');
				}
				if($_SESSION['user_type']=='family')
				{
				header('Location:'.$base_path.'/family_dashboard.php');
				}
			}
			?>
<section class="body_cont_outer" >
	<div class="container" >
    	<div class="body_cont clearfix" id="signuparea">
        	<!--<div class="get_sitter col-lg-6 col-md-6 col-sm-12 col-xs-12">
            	<div class="get_sitter_img">
                
                </div>
                <div class="get_sitter_tag">
                	<a href="#"  class="md-trigger" data-modal="modal-customer-signup"></a>
                </div>
                
            </div>-->
            <!--<div class="watch_child col-lg-6 col-md-6 col-sm-12 col-xs-12">
            	<div class="watch_child_img"></div>
                <div class="watch_child_tag">
                	<a href="#"  class="md-trigger" data-modal="modal-sitter-signup"></a>
                </div>
            </div>-->
            
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            	<div class="img-box">
                	<img src="<?=$base_path?>/images/home_cont_bg.png" alt="" />
                    <a href="#"  class="md-trigger" data-modal="modal-customer-signup">
                    <span class="btn-box">
                    <p>Get a Sitter</p>
                    <img src="<?=$base_path?>/images/get_sitter_tag.png" alt="" /></span>
                    </a>
                </div>                
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            	<div class="img-box">
                	<img src="<?=$base_path?>/images/watch_child.png" alt="" />
                    <a href="#"  class="md-trigger" data-modal="modal-sitter-signup">
                    <span class="btn-box">
                    <p>Watch a child</p>
                    <img src="<?=$base_path?>/images/watch_child_tag.png" alt="" />
                    </span>
                    </a>
                </div>                
            </div>
        </div>
    </div>
</section>
<?php include('includes/footer.php');?>