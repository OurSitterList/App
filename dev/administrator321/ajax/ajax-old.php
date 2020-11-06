<?php

	chdir("..");

	include("config/admin-includes.php");

	chdir("ajax");

	

	$con=new DBConnection(host,user,pass,db);

	$conObj=$con->connectDB(true);

	



	if(isset($_POST['mode']))

	{

		extract($_POST);

		switch($mode)

		{

			case 'checking_copy':

			echo '123';

			break;
			
			
			case 'get_area_list':

			$run_query=mysql_query("SELECT * FROM `country_state` where parent_id='".$hid."'");
			$msg.='<option value="0" selected="selected">Select A Area</option>';
			
			if(mysql_num_rows($run_query)>0)
			{
				while($R=mysql_fetch_object($run_query))
				{
				$msg.='<option value="'.$R->id.'">'.$R->country_state_name.'</option>';
				}
			}
			echo $msg;

			break;
			
			case 'city_entry':
			mysql_query("SET NAMES 'utf8'");
			$city_search=mysql_query("SELECT * FROM `country_state` where country_state_name like'".$city_init."%' and parent_id='0'");
			if(mysql_num_rows($city_search)>0)
			{
			$msg='<ul>';
			while($R=mysql_fetch_object($city_search))
			{
			$msg.='<li><a href="#" id="'.$R->id.'" onclick="set_city(\''.$R->country_state_name.'\')" >'.$R->country_state_name.'</a></li>';
			}
			$msg.='</ul>';
			}
			else
			{
			$msg=0;
			}
			echo $msg;
			
			break;
			case 'check_city':
			
			$city_search=mysql_query("SELECT * FROM `country_state` where country_state_name='".$city_input."' and parent_id='0'");
			if(mysql_num_rows($city_search)>0)
			{
			$msg=1;
			}
			else
			{
			$msg=0;
			}
			echo $msg;
			
			break;
			case 'check_city_again':
			
			$city_search=mysql_query("SELECT * FROM `country_state` where country_state_name='".$city_input."' and parent_id='0'");
			if(mysql_num_rows($city_search)>0)
			{
			$msg=1;
			}
			else
			{
			$msg=0;
			}
			echo $msg;
			
			break;
			case 'category_entry':
			
			$what_search=mysql_query("SELECT * FROM `category_management` where category_title like'".$what_init."%'");
			if(mysql_num_rows($what_search)>0)
			{
			$msg='<ul>';
			while($R=mysql_fetch_object($what_search))
			{
			$msg.='<li><a href="#" id="'.$R->category_id.'" onclick="set_category(\''.$R->category_title.'\')" >'.$R->category_title.'</a></li>';
			}
			$msg.='</ul>';
			}
			else
			{
			$msg=0;
			}
			echo $msg;
			
			break;
			
			case 'area_entry':
			
			$city_search=mysql_fetch_object(mysql_query("SELECT * FROM `country_state` where country_state_name ='".$city_init."' and parent_id='0'"))->id;
			$area_search=mysql_query("SELECT * FROM `country_state` where country_state_name like '".$area_init."%' and parent_id='".$city_search."'");
			if(mysql_num_rows($area_search)>0)
			{
			$msg='<ul>';
			while($R=mysql_fetch_object($area_search))
			{
			$msg.='<li><a href="#" id="'.$R->id.'" onclick="set_area(\''.$R->country_state_name.'\')" >'.$R->country_state_name.'</a></li>';
			}
			$msg.='</ul>';
			}
			else
			{
			$msg=0;
			}
			echo $msg;
			
			break;
			default:

					echo "- ERROR.";

				break;

		}

	}

	else

		echo "- ERROR.";

	ob_flush();

?>