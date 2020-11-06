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
			case 'model_upload':
			//print_r($_POST);exit;
					echo 'dwu';
				break;
			case 'search_category':
			//print_r($_POST);exit;
					$query=mysql_query("select * from `category_management` where parent_id='".$group_id."'");
					if(mysql_num_rows($query)>0)
					{
					$msg.='<tr class="innertable"><td><strong>Category Title</strong></td><td><strong>Status</strong></td><td><strong>Edit</strong></td><td><strong>Delete</strong></td></tr>';
						while($rr=mysql_fetch_object($query))
						{
						  echo $msg.='<tr class="innertable2"><td><a href="#">'.$rr->cat_title.'</a></td><td>'.$rr->status.'</td><td  onclick="editdetails($rr->cat_id);" style="cursor:pointer;"><input type="text" name="edit_value'.$rr->cat_id.'" id="edit_value'.$rr->cat_id.'" value="'.$rr->cat_id.'">Edit</td><td  onclick="deletedetails();" style="cursor:pointer;"><input type="text" name="del_value" id="del_value" value="'.$rr->cat_id.'">Delete</td></tr>';
						
						}
					   
					}
					else
					{
					$msg='<tr><td>No results matched your search criteria</td></tr></tbody></table></td></tr>';
					}
					echo $msg;
			break;
			
			case 'cat_load':
			//print_r($_POST);exit;
					$query=mysql_query("select * from category_management where parent_id='".$group_id."'");
					$msg='<option value="0" selected="selected">Select A Category</option>';
					while($R=mysql_fetch_object($query))
					{
					$msg.='<option value="'.$R->cat_id.'">'.$R->cat_title.'</option>';
					}
					echo $msg;
			break;
				case 'sub_cat_load':
			//print_r($_POST);exit;
					$query=mysql_query("select * from category_management where parent_id='".$cat_id."'");
					$msg='<option value="0" selected="selected">Select A Sub Category</option>';
					while($R=mysql_fetch_object($query))
					{
					$msg.='<option value="'.$R->cat_id.'">'.$R->cat_title.'</option>';
					}
					echo $msg;
			break;
			case 'search_product':
			//print_r($_POST);exit;
					$query=mysql_query("select * from `product_management` where cat_id='".$cat_id."'");
					if(mysql_num_rows($query)>0)
					{
					$msg.='<tr class="innertable"><td><strong>Name</strong></td><td><strong>product_description</strong></td><td><strong>Status</strong></td><td><strong>Price</strong></td><td><strong>Vat</strong></td><td><strong>Stock Amount</strong></td><td><strong>Edit</strong></td><td><strong>Delete</strong></td></tr>';
						while($rr=mysql_fetch_object($query))
						{
						$msg.='<tr class="innertable2"><td><a href="#">'.$rr->product_name.'</a></td><td>'.$rr->product_description.'</td><td>'.$rr->status.'</td><td>'.$rr->product_price.'</td><td>'.$rr->product_vat.'</td><td>'.$rr->no_of_product.'</td><td><img src="images/edit.png" width="20px" style="cursor:pointer;" border="0px" onclick="edit_table();" /></td><td><img src="images/no.png" width="20px" style="cursor:pointer;" border="0px" onclick="delete_table();"  /></td></tr>';
						}
					}
					else
					{
					$msg='<tr><td>No results matched your search criteria</td></tr></tbody></table></td></tr>';
					}
					echo $msg;
			break;
				case 'delete_product':
			//print_r($_POST);exit;
					$query=mysql_fetch_object(mysql_query("select cat_id from `product_management` where product_id='".$product_id."'"))->cat_id;
				$query_del=mysql_query("delete from `product_management` where product_id='".$product_id."'");
					echo $query;
			break;			
			
			
			case 'sub_cat_specification':
			//print_r($_POST);
			
			        $query=mysql_query("select * from `specification` where cat_id='".$sub_cat_id."'");
					//$msg='<input type="checkbox" name="chkbox">';
					$i=0;
					while($R=mysql_fetch_object($query))
					{
					       $new_arr[$i]=$R->specify.'<input type="checkbox" name="chkbox[]" id="chkbox" value="'.$R->id.'">';
                              $i++;
                            $specification=implode(" ",$new_arr);
					       
					}
					 $msg=$specification;
					
					 echo $msg;
					
			break;
			
			
			
			case 'delete_subcat':
			//print_r($_POST);exit;
					$query=mysql_fetch_object(mysql_query("select cat_id from `product_management` where product_id='".$product_id."'"))->cat_id;
				$query_del=mysql_query("delete from `category_management` where cat_id='".$subcat_id."'");
					echo $query;
			break;
			default:
					echo "- ERROR.";
				break;
								
						
			case 'search_memeber':
			//print_r($_POST);
				 $query=mysql_query("select * from `tirupati_customer` where ".$searchType." like '%".$searchQuery."%'");
					if(mysql_num_rows($query)>0)
					{
					  
					$msg.='<tr class="innertable"><td><strong>Username</strong></td><td><strong> Address-1</strong></td><td><strong>Address-2</strong></td><td><strong>city</strong></td><td><strong>State</strong></td><td><strong>Zip_Code</strong></td><td><strong>Phone</strong></td><td><strong>Email</strong></td><td><strong>Country</strong></td></tr>';
						while($rr=mysql_fetch_object($query))
						{
						$msg.='<tr class="innertable2"><td><a href="#">'.$rr->first_name.'</a></td><td>'.$rr->address_1.'</td><td>'.$rr->address_2.'</td><td>'.$rr->city.'</td><td>'.$rr->state.'</td><td>'.$rr->zip_code.'</td><td>'.$rr->phone.'</td><td>'.$rr->email.'</td><td>'.$rr->country.'</td></tr>';
						}
					}
					else
					{
					$msg='<tr><td>No results matched your search criteria</td></tr></tbody></table></td></tr>';
					}
					echo $msg;
			break;
			
			case 'search_order':
			//print_r($_POST);
				 $query=mysql_query("select * from `order` where ".$searchType." like '%".$searchQuery."%'");
					if(mysql_num_rows($query)>0)
					{
					  
					$msg.='<tr class="innertable"><td><strong>Order Id</strong></td><td><strong>Order Date</strong></td><td><strong>Customer Id</strong></td><td><strong>Address</strong></td><td><strong>city</strong></td><td><strong>State</strong></td><td><strong>Country</strong></td><td><strong>Total Cost</strong></td><td><strong>Email</strong></td></tr>';
						while($rr=mysql_fetch_object($query))
						{
						$msg.='<tr class="innertable2"><td><a href="#">'.$rr->order_id.'</a></td><td>'.$rr->order_date.'</td><td>'.$rr->customer_id.'</td><td>'.$rr->shipping_address1.'</td><td>'.$rr->shipping_city.'</td><td>'.$rr->shipping_state.'</td><td>'.$rr->shipping_country.'</td><td>'.$rr->cost_total.'</td><td>'.$rr->shipping_email.'</td></tr>';
						}
					}
					else
					{
					$msg='<tr><td>No results matched your search criteria</td></tr></tbody></table></td></tr>';
					}
					echo $msg;
			break;
			
			
			
			case 'show_all_member':
			//print_r($_POST);exit;
					$query=mysql_query("select * from `member_registration`");
					if(mysql_num_rows($query)>0)
					{
					$msg.='<tr class="innertable"><td><strong>Username</strong></td><td><strong>Email Address</strong></td><td><strong>Account Status</strong></td><td><strong>Last Login IP</strong></td><td><strong>Last Logged In</strong></td><td><strong>Balance</strong></td></tr>';
						while($rr=mysql_fetch_object($query))
						{
						$msg.='<tr class="innertable2"><td><a href="#">'.$rr->member_username.'</a></td><td>'.$rr->member_email.'</td><td>'.$rr->member_account_status.'</td><td>'.$rr->member_join_ip.'</td><td>'.$rr->member_joindate.'</td><td>'.$rr->member_balance.'</td></tr>';
						}
					}
					else
					{
					$msg='<tr><td>Still No Member</td></tr></tbody></table></td></tr>';
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