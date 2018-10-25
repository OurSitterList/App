<?php include('includes/connection.php');?>
<?php include('includes/header2.php');?>
<section class="about_outer">
	<div class="container">
    	<div class="about_cont clearfix">
         <?php if(isset($_SESSION['is_mail']))
	   {?> 
       <div class="message"><?=$_SESSION['is_mail']?></div>
       <?php  
	   unset($_SESSION['is_mail']);
	   }

	
	   ?>
        	<div class="about_left col-lg-4 col-md-4 col-sm-4 col-xs-12">
            	<div class="founder_pic">
                	<img src="images/contact-pic.png" alt="" />
                </div>
            </div>
            <div class="about_right col-lg-8 col-md-8 col-sm-8 col-xs-12">
            	<div class="about_para">
                	<div class="contact-cont-box">
                    	<h3>Contact Us</h3>
                    </div>
                </div>
                
                <div class="form-box2">
                	<div class="row">
                    	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">                            
                             <form class="form-horizontal" role="form" id="contact_form" action="<?=$base_path?>/contact_form_submit.php" method="post">
                              <div class="form-group">
                                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12" for="name">Name:</label>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" class="form-control" id="contact_name" name="contact_name">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12" for="email">Email:</label>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                  <input type="email" class="form-control" id="contact_email" name="contact_email">
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-9 col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 col-xs-12">
                                  <div class="checkbox">
                                    <label><input type="radio" name="contact_as" value="sitter" checked> Sitter </label>
                                    <label><input type="radio" name="contact_as" value="family"> Family </label>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12" for="comment">Comments:</label>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                  <textarea class="form-control" rows="5" id="contact_comment" name="contact_comment"></textarea>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-9 col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 col-xs-12">
                                  <button type="submit" class="btn btn-default btn-warning btn-lg">Submit</button>
                                </div>
                              </div>
                            </form>
                        </div>
                    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">&nbsp;</div>
                    </div>
                </div>
                <br>
                <br>
                <div class="contact-cont-box">
                	<p>Visit Us: Nashville, TN 37205</p>
                	<p>For questions or comments, please contact us at <a href="mailto:<?=mysql_fetch_object(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='5'"))->settingValue?>"><?=mysql_fetch_object(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='5'"))->settingValue?></a></p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include('includes/footer.php');?>
</body>
</html>
