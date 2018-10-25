<?php
	include("PageStructure.php");
	class SiteStructure extends PageStructure
	{
		function SiteStructure($title='Welcome to Mahalo Salons')
		{
			parent::PageStructure($title);
		}
		function pageHeadTag()
		{
		?>
        <title><?=$this->title?></title>
        <script language="javascript" type="text/javascript" src="admin/js/jquery.js"></script>
		
		<link href="css/style.css" rel="stylesheet" type="text/css" />	
		<?
		}
		function css()
		{
			
		}
		function js()
		{

		}
		function Header()
		{
			
		?>
		<form id="form1" name="form1" method="post" action="">
						<input type="hidden" name="hval" id="hval">
	     <table width="300" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="300" align="center" valign="bottom">&nbsp;</td>
            </tr>
          <tr>
            <td width="300" align="center" valign="bottom"><a href="./" style="text-decoration:none;"><img src="images/logo.png" alt="" width="272" border="0" /></a></td>
            </tr>
        </table>
		</form>
		<?
		}
	
		function bodytop()
		{
			$con=new DBConnection(host,user,pass,db);
			$conObj=$con->connectDB();
			$Q=mysql_fetch_object(mysql_query("select content from content_master where id='6'"));
		?>
     <table width="902" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="300" align="left" valign="top"><img src="images/main_img.jpg" alt="" /></td>
            <td width="602" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>
                <td align="left" valign="top" class="main_img_textbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="left" valign="middle"><img src="images/blank.gif" alt="" width="1" height="5" /></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="40" align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top" class="main_img_text"><?=stripslashes($Q->content)?>
                          </td>
                        <td width="20" align="left" valign="top">&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                 
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table>
    	<?
		}
		function Rightpanel()
		{
			$con=new DBConnection(host,user,pass,db);
			$conObj=$con->connectDB();
        ?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0"  bgcolor="#282828">
                  <tr>
                    <td align="left" valign="top"><table width="240" border="0" cellspacing="0" cellpadding="0">
					<?
						$W=mysql_query("select id,cat_name,img,description from blog_cat where `show`=1 and isactive=1 order by updtime desc") or die(mysql_error()."select id,cat_name,img,description from blog_cat where `show`=1 and isactive=1 order by updtime desc");
						if(mysql_num_rows($W))
						{
							while($AA=mysql_fetch_object($W))
							{
								$N=mysql_num_rows(mysql_query("select id from blog where cat_id='".$AA->id."'"));
						
					?>
                      <tr>
                        <td align="left" valign="top">
						
						<table width="230" border="0" align="right" cellpadding="0" cellspacing="0" style="border:1px solid #999; border-bottom:none;">
                          <tr>
                            <td height="25" align="left" valign="middle"  class="right_side_category"><?=stripslashes($AA->cat_name)?> </td>
                          </tr>
						  <?
						  if($AA->description!='')
									{
										 if(strlen($AA->description)>80)
										 {
											$de=str_replace('<p>','',substr($AA->description,0,200))."..";
											$de=str_replace('</p>','',$de);
										  }	
										else
										{
											$de=str_replace('<p>','',nl2br($AA->description));
											$de=str_replace('</p>','',$de);
										 }	
									}
									else
										$de='&nbsp;';
						  ?>
                          <tr>
                            <td align="left" valign="top" class="right_side_description">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"class="right_side_description"><img src="blogcat/<?=$AA->img?>" alt="" width="75" height="99" style="border:1px solid #fff; float:left; margin:5px" /><?=$de;?></td>
  </tr>
  
</table>
							
							</td>
                          </tr>
                          <tr>
                            <td height="20" align="right" valign="middle" bgcolor="#aaa381" class="right_side_read_more">
							<span class="aaa2"><a href="blog.php?catid=<?=$AA->id?>">Comment (<?=$N?>)</a></span><a href="blog.php?catid=<?=$AA->id?>">Read More</a></td>
                          </tr>
						  
                        </table>
						
						</td>
                      </tr>
                   <?
				   			}
				   		}
				   ?> 
				   <?php if(basename($_SERVER['PHP_SELF'])=='index.php' || basename($_SERVER['PHP_SELF'])=='underdog-game.php' || basename($_SERVER['PHP_SELF'])=='overunder-game.php'){?>
				     <tr>
				      <td align="left" valign="top">
					<table width="230" border="0" align="right" cellpadding="0" cellspacing="0" style="border:1px solid #999; border-bottom:none;">
                          <tr>
                            <td height="20" align="center" valign="middle" bgcolor="#aaa381" class="right_side_category">
							<a href="fantasy.php" style="text-decoration:none;" class="right_side_category">Weekly Fantasy Lineups</a></td>
                          </tr>
                        </table>
						</td> 
						</tr>
					<?php }?>
                      <tr>
                        <td align="left" valign="top">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="top">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="top">&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
        <?
		}
		function PageBody()
		{
		?>
		
        <?
		}
		
		function Footer()
		{
		?>
        <table width="900" border="0" cellspacing="0" cellpadding="0" class="footer" height="90">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="900" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="110" align="left" valign="top">&nbsp;</td>
                <td width="524" align="center" valign="top"><pre class="footer"><a href="./">Home</a>  |  <a href="about.php">About us</a>  |  <!--<a href="favorite.php">Favorite Game </a> |  <a href="underdog.php">Underdog   Game</a>  | <a href="over_under.php"> Over/Under</a>  | --> <a href="blog.php">Blog</a>  |  <a href="fantasy.php">Fantasy </a> | <a href="contact.php"> Contact us</a> 
				<br />
                  Copyright &copy; 2009, <a href="#">YouMakeTheOdds.com.</a> All rights reserved<br/>This website is in no way affilated with any casino or gambling site.</pre></td>
                <td width="190" align="left" valign="top">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        <?
		}
		function pageMetatag()
		{
		?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?
		}
		function pageView()
		{
			$this->pageTop();
			$this->condition();
?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>    
<?
			$this->pageMetatag();
			$this->pageHeadTag();
			$this->js();
			$this->css();
?>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center" valign="top" style="padding-top:190px;"><table width="160" border="0" cellspacing="0" cellpadding="0" style="display:none;" id="lEfT">
      <tr>
        <td><script type="text/javascript"><!--
google_ad_client = "pub-4981035099627018";
/* 160x600, created 10/9/09 */
google_ad_slot = "5688008841";
google_ad_width = 160;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></td>
      </tr>
    </table></td>
    <td align="left" valign="top" width="904"><table width="904" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><? $this->Header();?></td>
      </tr>
      <tr>
        <td align="left" valign="top"><? $this->bodytop();?></td>
      </tr>
      <tr>
        <td align="left" valign="top"><table width="901" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="top" bgcolor="#282828"><img src="images/blank.gif" alt="" width="1" height="12" /></td>
          </tr>
          <tr>
            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="660" align="left" valign="top"><? $this->PageBody();?></td>
                <td align="left" valign="top" ><? $this->Rightpanel();?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"><img src="images/bottom_border.gif" alt="" width="900" height="4" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="left" valign="top"><img src="images/blank.gif" alt="" width="1" height="64" /></td>
      </tr>
      <tr>
        <td height="90" align="left" valign="top"><? $this->Footer();?></td>
      </tr>
    </table></td>
    <td align="center" valign="top" style="padding-top:190px;"><table width="160" border="0" cellspacing="0" style="display:none;" cellpadding="0" id="rIgHt">
      <tr>
        <td><script type="text/javascript"><!--
google_ad_client = "pub-4981035099627018";
/* 160x600, created 10/9/09 */
google_ad_slot = "9064040063";
google_ad_width = 160;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></td>
      </tr>
    </table></td>
  </tr>
</table>
<script language="JavaScript1.2">
<!--
if (screen.width>1024) //if > 800x600
{
	document.getElementById('lEfT').style.display = "";
	document.getElementById('rIgHt').style.display = "";
}
//-->
</script>
</body>	
</html>
<?
		}
	}
?>