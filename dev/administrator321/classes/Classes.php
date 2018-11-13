<?php
	class DBConnection
	{
		var $host;
		var $uname;
		var $pass;
		var $db;
		var $DBLink;
		
		function DBConnection($host,$uname,$pass,$db)
		{
			$this->host=$host;
			$this->uname=$uname;
			$this->pass=$pass;
			$this->db=$db;
			$this->DBLink=NULL;
		}
		function connectDB(){
			/*$ini = parse_ini_file('http://supercloudten.com/maintenence/connect.ini'); 
				while(list($key,$value) = each($ini)){ 
				  if($key == 'hostName'){ 
					$hostName = $value; 
				  } 
				  else if($key == 'userName'){ 
					$userName = $value; 
				  } 
				  else if($key == 'password'){ 
					$password = $value; 
				  } 
				  else if($key == 'databaseName'){ 
					$databaseName = $value; 
				  } 
				  else if($key == 'persistent'){ 
					$persistent = $value; 
				  } 
				  else if($key == 'databaseCharset'){ 
					$databaseCharset = $value; 
				  } 
				}
				$conn = mysql_connect($hostName,$userName,$password);
				mysql_select_db($databaseName,$conn);
				$this->DBLink = $conn;
				return $this->DBLink;*/
		
		
			if($con=@mysql_connect($this->host,$this->uname,$this->pass))
			{
				$this->DBLink=$con;
				@mysql_select_db($this->db,$this->DBLink);
			}
			return $this->DBLink;
		
		
		
	}
		function getConnectionRef()
		{
			return $this->DBLink;
		}
		function closeConnection()
		{
			mysql_close($this->DBLink);
		}
	}
	class DBTools
	{
		var $con;
		var $recSet;
		var $SQL;
		var $errorMsg;
		var $successMsg;
		function DBTools($con)
		{
			$this->con=$con;
			$this->recSet=NULL;
			$this->SQL = "";
		}
		
		function insert($tablename,$updatequery)
		{
		$queryStr = "Insert into  ".$tablename." Set ";

$updatequery_terms = count($updatequery);
foreach ($updatequery as $field => $value)
{
    $updatequery_terms--;
    $queryStr .= $field ." = '".mysql_real_escape_string($value)."'";
    if ($updatequery_terms)
    {
        $queryStr .= " , ";
    }
}

		$rs = mysql_query($queryStr,$this->con);
		if($rs=== false)
		{
			
			$this->errorMsg = mysql_errno($this->con) . ": " . mysql_error($this->con);
			$this->displayError();
		}
		
		
		return mysql_insert_id();
	}
	function update($tablename,$updatequery,$conditionalArray)
	{
		$queryStr = "Update  ".$tablename." Set ";

$updatequery_terms = count($updatequery);
foreach ($updatequery as $field => $value)
{
    $updatequery_terms--;
    $queryStr .= $field ." = '".mysql_real_escape_string($value)."'";
    if ($updatequery_terms)
    {
        $queryStr .= " , ";
    }
}

 $queryStr .= " Where ";
 $conditionalArray_terms = count($conditionalArray);
foreach ($conditionalArray as $field => $value)
{
    $conditionalArray_terms--;
    $queryStr .= $field ." = '".$value."'";
    if ($conditionalArray_terms)
    {
        $queryStr .= " AND ";
    }
}	
		
		
	//echo $queryStr;
		$rs = mysql_query($queryStr,$this->con);
		if($rs=== false)
		{
			
			$this->errorMsg = mysql_errno($this->con) . ": " . mysql_error($this->con);
			$this->displayError();
		}
		
	
		return mysql_affected_rows();
		
	}
	function displayError($stop=1)
	{
		echo "<p><font color='#FF0000'>".$this->errorMsg."</font></p>";
		if($stop==1)
			exit();
	}
		function resetClass()
		{
			$this->con=NULL;
			$this->recSet=NULL;
		}
		function executeNonQuery($Q)
		{
			return @mysql_query($Q,$this->con);
		}
		function executeQuery($Q)
		{
			if($Rec=@mysql_query($Q,$this->con))
			{
				$this->recSet=array();
				while($R=mysql_fetch_assoc($Rec))
					array_push($this->recSet,$R);
			}
			return $this->recSet;
		}
		function getNumRowsFetched()
		{
			return @mysql_num_rows($this->recSet);
		}
		function getColsFromCond($tab,$colArr,$cond="")
		{
			$Q="SELECT `".implode("`,`",$colArr)."` FROM `".$tab."`";
			if(!empty($cond))
				$Q.=" WHERE ".$cond;
			
			return $this->executeQuery($Q);
		}		
		/*function insert($table,$colarr,$valarr)
		{
			$Q="INSERT INTO ".$table." (".implode(",",$colarr).") VALUES(".implode(",",$valarr).")";						
			return $this->executeNonQuery($Q);
		}
		function update($table,$colarr,$valarr,$cond="")
		{
			$Q="UPDATE ".$table." SET ";
			for($i=0;$i<count($colarr);$i++)
				$Q.=$colarr[$i]."=".$valarr[$i].",";
			$Q=rtrim($Q,",");
			if(!empty($cond))
				$Q.=" WHERE ".$cond;				
			return $this->executeNonQuery($Q);
		}*/
		function Populate($table,$option,$value,$selected="")
		{			
		$Q=mysql_query(("select `$option`,`$value` from `$table`"),$this->con);
			
				while($R=mysql_fetch_object($Q))
				{							
					$sel="";
					if($selected == $R->$value)
						$sel=" selected";
				echo '<option value='.$R->$value.''.$sel.'>'.$R->$option.'</option>';					
				}	
		}
	}
	class Authentication
	{
		var $dbObj;
		function Authentication($con)
		{
			$this->dbObj=new DBTools($con);
		}
		function login($tab,$cond,$sessArr,$timeCol="")
		{
			$R=$this->dbObj->getColsFromCond($tab,array_keys($sessArr),$cond);
			
			if(is_null($R))
				return false;
			else
			{
				if(count($R)==0)
					return false;
				else
				{
					foreach($sessArr as $k=>$v)
					{
						//session_register($v);
						$_SESSION[$v]=$R[0][$k];
					}
					if(!empty($timeCol))
					{
						$Q="UPDATE ".$tab." SET `".$timeCol."`=".mktime();
						if(!empty($cond))
							$Q.=" WHERE ".$cond;
						$this->dbObj->executeNonQuery($Q);
					}
					return true;
				}
			}
		}
		function logout($sess)
		{
			foreach($sess as $s)
			{
				//session_unregister($s);
				unset($_SESSION[$s]);
			}
		}
	}
	class Pagination
	{
		var $selectedCSS;
		var $numbersCSS;
		var $nextPrevCSS;
		var $numData;
		var $toShowData;
		var $toShowNumbers;
		var $pageNumber;
		var $numSeperator;
		
		var $getNumPages;
		var $pageData;
		
		var $prevChar;
		var $nextChar;
		var $pageURL;
		
		function Pagination($selectedCSS,$numbersCSS,$nextPrevCSS)
		{
			$this->selectedCSS=$selectedCSS;
			$this->numbersCSS=$numbersCSS;
			$this->nextPrevCSS=$nextPrevCSS;
			$this->numData=0;
			$this->toShowData=5;
			$this->toShowNumbers=9;
			$this->pageNumber=0;
			$this->numSeperator='|';
			
			$this->getNumPages=0;
			$this->pageData='';
			
			$this->prevChar='Previous';
			$this->nextChar='Next';
			$this->pageURL=$_SERVER['PHP_SELF'];
		}
		function initialize()
		{
			if(isset($_GET['page']))
				$this->pageNumber=(intval($_GET['page'])>=0?intval($_GET['page']):0);
			else
				$this->pageNumber=0;
			
			$this->getNumPages=ceil($this->numData/$this->toShowData);
			
			$this->pageData='';
			if(count($_GET))
			{
				$get=$_GET;
				unset($get['page']);
				foreach($get as $k=>$v)
					$this->pageData.='&'.$k.'='.$v;
			}
		}
		function queryBuilder($Q)
		{
			$this->initialize();
			$start=$this->pageNumber*$this->toShowData;
			$Q.=" LIMIT ".$start.",".$this->toShowData;
			return $Q;
		}
		function getPrevious($flag=true)
		{
			if($this->pageNumber==0)
			$extraclass='ui-state-disabled';
			if($flag)
				$this->initialize();
			if($this->numData)
				return '<a href="'.$this->pageURL.'?page=0" class="'.$this->nextPrevCSS.' '.$extraclass.'">First</a><a href="'.$this->pageURL.'?page='.($this->pageNumber?($this->pageNumber-1):0).$this->pageData.'" class="'.$this->nextPrevCSS.' '.$extraclass.'">'.$this->prevChar.'</a>';
			else
				return '';
		}
		function getNext($flag=true)
		{
			if($this->pageNumber==$this->getNumPages-1)
			$extraclass='ui-state-disabled';
			if($flag)
				$this->initialize();
			if($this->numData)
				return '<a href="'.$this->pageURL.'?page='.(($this->pageNumber<$this->getNumPages-1)?($this->pageNumber+1):($this->getNumPages-1)).$this->pageData.'" class="'.$this->nextPrevCSS.' '.$extraclass.'">'.$this->nextChar.'</a><a href="'.$this->pageURL.'?page='.($this->getNumPages-1).'" class="'.$this->nextPrevCSS.' '.$extraclass.'">Last</a>';
			else
				return '';
		}
		function getNumbers($flag=true)
		{
			if($flag)
				$this->initialize();
			$numbers='';
			
			if($this->getNumPages>$this->toShowNumbers)
			{
				if($this->pageNumber>=ceil($this->toShowNumbers/2))
				{
					$start=$this->pageNumber-floor($this->toShowNumbers/2);
					$end=$start+$this->toShowNumbers;
					if($end>$this->getNumPages)
					{
						$end=$this->getNumPages;
						$start=$end-$this->toShowNumbers;
					}
				}
				else
				{
					$start=0;
					$end=$this->toShowNumbers;
				}
			}
			else
			{
				$start=0;
				$end=$this->getNumPages;
			}
			$numbers='<span>';
			for($i=$start;$i<$end;$i++)
			{
				if($i>$start)
					$numbers.=$this->numSeperator;
				if($i==$this->pageNumber)
					$numbers.='<a class="'.$this->selectedCSS.' '.$this->numbersCSS.'" tabindex="0">'.($i+1).'</a>';
				else
					$numbers.='<a href="'.$this->pageURL.'?page='.$i.$this->pageData.'" class="'.$this->numbersCSS.'" tabindex="0">'.($i+1).'</a>';
			}
			$numbers.='</span>';
			return $numbers;
		}
		function paginationPanel()
		{
			$this->initialize();
			return $this->getPrevious(false).$this->getNumbers(false).$this->getNext(false);
		}
		
		function totalnum()
		{
			$this->initialize();
			return $this->getNumPages;
			
		}
		function currentpage()
		{
			$this->initialize();
			return $this->pageNumber+1;
		}
		function nextpage()
		{
			$this->initialize();
			return $this->getNext(false);
		}
		function previouspage()
		{
			$this->initialize();
			return $this->getPrevious(false);
		}
		
	}
	class Pagination1
	{
		var $selectedCSS;
		var $numbersCSS;
		var $nextPrevCSS;
		var $numData;
		var $toShowData;
		var $toShowNumbers;
		var $pageNumber;
		var $numSeperator;
		
		var $getNumPages;
		var $pageData;
		
		var $prevChar;
		var $nextChar;
		var $pageURL;
		
		function Pagination1($selectedCSS,$numbersCSS,$nextPrevCSS)
		{
			$this->selectedCSS=$selectedCSS;
			$this->numbersCSS=$numbersCSS;
			$this->nextPrevCSS=$nextPrevCSS;
			$this->numData=0;
			$this->toShowData=5;
			$this->toShowNumbers=9;
			$this->pageNumber=0;
			$this->numSeperator='|';
			
			$this->getNumPages=0;
			$this->pageData='';
			
			$this->prevChar='&laquo;';
			$this->nextChar='&raquo;';
			$this->pageURL=$_SERVER['PHP_SELF'];
		}
		function initialize()
		{
			if(isset($_GET['page1']))
				$this->pageNumber=(intval($_GET['page1'])>=0?intval($_GET['page1']):0);
			else
				$this->pageNumber=0;
			
			$this->getNumPages=ceil($this->numData/$this->toShowData);
			
			$this->pageData='';
			if(count($_GET))
			{
				$get=$_GET;
				unset($get['page1']);
				foreach($get as $k=>$v)
					$this->pageData.='&'.$k.'='.$v;
			}
		}
		function queryBuilder($Q)
		{
			$this->initialize();
			$start=$this->pageNumber*$this->toShowData;
			$Q.=" LIMIT ".$start.",".$this->toShowData;
			return $Q;
		}
		function getPrevious($flag=true)
		{
			if($flag)
				$this->initialize();
			if($this->numData)
				return '<a href="'.$this->pageURL.'?page1='.($this->pageNumber?($this->pageNumber-1):0).$this->pageData.'" class="'.$this->nextPrevCSS.'">'.$this->prevChar.'</a>';
			else
				return '';
		}
		function getNext($flag=true)
		{
			if($flag)
				$this->initialize();
			if($this->numData)
				return '<a href="'.$this->pageURL.'?page1='.(($this->pageNumber<$this->getNumPages-1)?($this->pageNumber+1):($this->getNumPages-1)).$this->pageData.'" class="'.$this->nextPrevCSS.'">'.$this->nextChar.'</a>';
			else
				return '';
		}
		function getNumbers($flag=true)
		{
			if($flag)
				$this->initialize();
			$numbers='';
			
			if($this->getNumPages>$this->toShowNumbers)
			{
				if($this->pageNumber>=ceil($this->toShowNumbers/2))
				{
					$start=$this->pageNumber-floor($this->toShowNumbers/2);
					$end=$start+$this->toShowNumbers;
					if($end>$this->getNumPages)
					{
						$end=$this->getNumPages;
						$start=$end-$this->toShowNumbers;
					}
				}
				else
				{
					$start=0;
					$end=$this->toShowNumbers;
				}
			}
			else
			{
				$start=0;
				$end=$this->getNumPages;
			}
			for($i=$start;$i<$end;$i++)
			{
				if($i>$start)
					$numbers.='&nbsp;'.$this->numSeperator.'&nbsp;';
				if($i==$this->pageNumber)
					$numbers.='<span class="'.$this->selectedCSS.'">'.($i+1).'</span>';
				else
					$numbers.='<a href="'.$this->pageURL.'?page1='.$i.$this->pageData.'" class="'.$this->numbersCSS.'">'.($i+1).'</a>';
			}
			return $numbers;
		}
		function paginationPanel()
		{
			$this->initialize();
			return $this->getPrevious(false).'&nbsp;&nbsp;&nbsp;&nbsp;'.$this->getNumbers(false).'&nbsp;&nbsp;&nbsp;&nbsp;'.$this->getNext(false);
		}
	}
	class AjaxPagination
	{
		var $selectedCSS;
		var $numbersCSS;
		var $nextPrevCSS;
		var $numData;
		var $toShowData;
		var $toShowNumbers;
		var $pageNumber;
		var $numSeperator;
		var $separator;
		
		var $getNumPages;
		var $pageData;
		var $newPageData;
		
		var $prevChar;
		var $nextChar;
		var $pageValiable;
		
		var $jsFunction;
		
		function AjaxPagination($selectedCSS,$numbersCSS,$nextPrevCSS)
		{
			$this->selectedCSS=$selectedCSS;
			$this->numbersCSS=$numbersCSS;
			$this->nextPrevCSS=$nextPrevCSS;
			$this->numData=0;
			$this->toShowData=5;
			$this->toShowNumbers=9;
			$this->pageNumber=0;
			$this->numSeperator='|';
			$this->separator='&nbsp;';
			
			$this->getNumPages=0;
			$this->pageData='';
			$this->newPageData=array();
			
			$this->prevChar='&laquo;';
			$this->nextChar='&raquo;';
			$this->pageValiable='pageID';
			
			$this->jsFunction='pagination';
		}
		function initialize()
		{
			if(isset($_REQUEST[$this->pageValiable]))
				$this->pageNumber=(intval($_REQUEST[$this->pageValiable])>=0?intval($_REQUEST[$this->pageValiable]):0);
			else
				$this->pageNumber=0;
			
			$this->getNumPages=ceil($this->numData/$this->toShowData);
			
			$this->pageData='';
			
			if(count($_REQUEST))
			{
				$get=$_REQUEST;
				unset($get[$this->pageValiable]);
				$data=array_merge($get,$this->newPageData);
				$data=array_unique($data);
				foreach($data as $k=>$v)
					$this->pageData.='&'.$k.'='.$v;
			}
			$this->pageData=addslashes($this->pageData);
		}
		function addNewPageData($index,$value)
		{
			$this->newPageData[$index]=$value;
		}
		function queryBuilder($Q)
		{
			$this->initialize();
			$start=$this->pageNumber*$this->toShowData;
			$Q.=" LIMIT ".$start.",".$this->toShowData;
			return $Q;
		}
		function getPrevious($flag=true)
		{
			if($flag)
				$this->initialize();
			if($this->numData)
				return '<a href="#" onClick="JavaScript: '.$this->jsFunction.'(\''.$this->pageValiable.'='.($this->pageNumber?($this->pageNumber-1):0).$this->pageData.'\'); return false;" class="'.$this->nextPrevCSS.'">'.$this->prevChar.'</a>';
			else
				return '';
		}
		function getNext($flag=true)
		{
			if($flag)
				$this->initialize();
			if($this->numData)
				return '<a href="#" onClick="JavaScript: '.$this->jsFunction.'(\''.$this->pageValiable.'='.(($this->pageNumber<$this->getNumPages-1)?($this->pageNumber+1):($this->getNumPages-1)).$this->pageData.'\'); return false;" class="'.$this->nextPrevCSS.'">'.$this->nextChar.'</a>';
			else
				return '';
		}
		function getNumbers($flag=true)
		{
			if($flag)
				$this->initialize();
			$numbers='';
			
			if($this->getNumPages>$this->toShowNumbers)
			{
				if($this->pageNumber>=ceil($this->toShowNumbers/2))
				{
					$start=$this->pageNumber-floor($this->toShowNumbers/2);
					$end=$start+$this->toShowNumbers;
					if($end>$this->getNumPages)
					{
						$end=$this->getNumPages;
						$start=$end-$this->toShowNumbers;
					}
				}
				else
				{
					$start=0;
					$end=$this->toShowNumbers;
				}
			}
			else
			{
				$start=0;
				$end=$this->getNumPages;
			}
			for($i=$start;$i<$end;$i++)
			{
				if($i>$start)
					$numbers.=$this->separator.$this->numSeperator.$this->separator;
				if($i==$this->pageNumber)
					$numbers.='<span class="'.$this->selectedCSS.'">'.($i+1).'</span>';
				else
					$numbers.='<a href="#" onClick="JavaScript: '.$this->jsFunction.'(\''.$this->pageValiable.'='.$i.$this->pageData.'\'); return false;" class="'.$this->numbersCSS.'">'.($i+1).'</a>';
			}
			return $numbers;
		}
		function paginationPanel()
		{
			$this->initialize();
			return $this->getPrevious(false).$this->separator.$this->separator.$this->separator.$this->separator.$this->getNumbers(false).$this->separator.$this->separator.$this->separator.$this->separator.$this->getNext(false);
		}
	}
	class MailTools
	{
		var $to;
		var $from;
		var $subject;
		var $msgBody;
		var $attachments;
		var $attachmentsType;
		var $msgType;
		var $replyTo;
		
		var $mail_boundary;
		
		function MailTools()
		{
			$this->to='';
			$this->from='';
			$this->subject='';
			$this->msgBody='';
			$this->attachments=array();
			$this->attachmentsType=array();
			$this->msgType='text/html';
			$this->replyTo='';
			
			$this->mail_boundary='';
		}
		function setAttachMents($file,$type)
		{
			array_push($this->attachments,$file);
			array_push($this->attachmentsType,$type);
		}
		/**
		* Sends Mail.
		*
		* @param string $to
		* @param string $subject
		* @param string $body
		* @param string $from
		* @param string[optional] $type
		* @param string[optional] $replyto
		*/
		function getHeaders()
		{
			if(count($this->attachments))
			{
				$border_random = md5(time());
				$this->mail_boundary = 'x'.$border_random.'x';
				
				$headers = 'From: '.$this->from."\r\n";
				$headers .= 'To: '.$this->to."\r\n";
				$headers .= 'Reply-to: '.$this->from."\r\n";
				$headers .= 'MIME-Version: 1.0\r\n';
				$headers .= 'Content-type: multipart/mixed; boundary="'.$this->mail_boundary.'"'."\r\n";
				/*$headers .= 'This is a multi-part message in MIME format.'."\r\n\r\n";
				$headers .= '--'.$this->mail_boundary."\r\n";
				$headers .= 'Content-type: text/plain; charset="iso-8859-1'."\r\n";
				$headers .= 'Content-Transfer-Encoding:7bit'."\r\n\r\n";*/
				$headers .= $this->msgBody."\r\n\r\n";
				$headers = $this->getEncodedFile().$headers;
			}
			else
			{
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: ".$this->msgType."; charset=iso-8859-1\r\n";
				$headers .= "From: ".$this->from."\r\n";
				if(!empty($this->replyTo))
					$headers .= "Reply-To: ".$this->replyTo."\r\n";
			}
			return $headers;
		}
		function getEncodedFile()
		{
			$new_e_message='';
			for($i=0;$i<count($this->attachments);$i++)
			{
				$myFile_type = $this->attachmentsType[$i];
				$myFile_name = basename($this->attachments[$i]);
				$myFile_size = filesize($this->attachments[$i]);
				
				$fp = fopen($this->attachments[$i],"rb");
				$fileData = fread($fp,$myFile_size);
				fclose($fp);
				
				$file = base64_encode($fileData);
				$file = chunk_split($file);
				
				$new_e_message .= '--'.$this->mail_boundary."\r\n";
				$new_e_message .= 'Content-type: '.$myFile_type.'; name='.$myFile_name."\r\n";
				$new_e_message .= 'Content-Transfer-Encoding:base64\r\n';
				$new_e_message .= 'Content-Disposition: attachment; filename="'.$myFile_name."\r\n\r\n";
				$new_e_message .= $file."\r\n\r\n";
			}
			return $new_e_message;
		}
		function sendMail()
		{
			$headers=$this->getHeaders();
			if(count($this->attachments))
				return @mail($this->to,$this->subject,'',$headers);
			else
				return @mail($this->to,$this->subject,$this->msgBody,$headers);
		}
	}
	class ShoppingCart
	{
		var $sessItem;
		var $sessQty;
		var $qtyIncrease;
		
		function ShoppingCart($sessItem,$sessQty='',$qtyIncrease=false)
		{
			$this->sessItem=$sessItem;
			$this->sessQty=$sessQty;
			$this->qtyIncrease=$qtyIncrease;
		}
		function initCart()
		{
			if(!session_is_registered($this->sessItem))
			{
				session_register($this->sessQty);
				if($this->isQtyEnabled())
					session_register($this->sessQty);
			}
		}
		function isQtyEnabled()
		{
			return empty($this->sessQty)?false:true;
		}
		function isEmptySession($session)
		{
			return empty($_SESSION[$session])?true:false;
		}
		function setItem($itm,$qty=1)
		{
			$this->initCart();
			if($this->isEmptySession($this->sessItem))
			{
				$_SESSION[$this->sessItem]=$itm;
				if($this->isQtyEnabled())
					$_SESSION[$this->sessQty]=$qty;
				return true;
			}
			else
			{
				$item=$this->getItemArray();
				if(in_array($itm,$item))
				{
					if($this->qtyIncrease)
						$this->iscreaseQtyByOne($itm);
					return false;
				}
				else
				{
					$_SESSION[$this->sessItem].=','.$itm;
					if($this->isQtyEnabled())
						$_SESSION[$this->sessQty].=','.$qty;
					return true;
				}
			}
		}
		function iscreaseQtyByOne($itm)
		{
			$item=$this->getItemArray();
			$quantity=$this->getQtyArray();
			if(in_array($itm,$item))
			{
				$quantity[array_search($itm,$item)]+=1;
				$_SESSION[$this->sessQty]=implode(',',$quantity);
			}
		}
		function setQuantity($itm,$qty)
		{
			$item=$this->getItemArray();
			$quantity=$this->getQtyArray();
			if(in_array($itm,$item))
			{
				$quantity[array_search($itm,$item)]=$qty;
				$_SESSION[$this->sessQty]=implode(',',$quantity);
			}
		}
		function getItemArray()
		{
			$this->initCart();
			if(empty($_SESSION[$this->sessItem]))
				return array();
			else
				return explode(',',$_SESSION[$this->sessItem]);
		}
		function getQtyArray()
		{
			$this->initCart();
			if(empty($_SESSION[$this->sessQty]))
				return array();
			else
				return explode(',',$_SESSION[$this->sessQty]);
		}
		function removeItem($itm)
		{
			$item=$this->getItemArray();
			if(in_array($itm,$item))
			{
				$index=array_search($itm,$item);
				unset($item[$index]);
				$_SESSION[$this->sessItem]=implode(',',$item);
				
				if($this->isQtyEnabled())
				{
					$quantity=$this->getQtyArray();
					unset($quantity[$index]);
					$_SESSION[$this->sessQty]=implode(',',$quantity);
				}
			}
		}
		function numItem()
		{
			return count($this->getItemArray());
		}
		function emptyCart()
		{
			session_unregister($this->sessItem);
			session_unregister($this->sessQty);
			unset($_SESSION[$this->sessItem]);
			unset($_SESSION[$this->sessQty]);
		}
	}
	class StringHandler
	{
		function strSplit($str,$len)
		{
			$strLen=strlen($str);
			$chunk=array();
			
			for($i=0;$i<$strLen;$i+=$len)
			{
				if($len<$strLen)
					array_push($chunk,substr($str,$i,$len));
				else
					array_push($chunk,substr($str,$i));
			}
			return $chunk;
		}
	}
	class DropPopulate
	{
		function Populate($table,$option,$value,$selected="",$cond=""){			
			$Q="select `".$option."`,`".$value."` from `".$table."`";
			if(!empty($cond))
				$Q.="WHERE ".$cond;
			$Rec=mysql_query($Q) or die(mysql_error().$Q);
			while($R=mysql_fetch_object($Rec)){							
				$sel="";
				if($selected == $R->$value)
					$sel=" selected";
			echo '<option value='.$R->$value.$sel.'>'.$R->$option.'</option>';					
			}	
		}
	}
	class Utility
	{
		function uploadpic($field,$dest,$pre="")
		{
			$file="";
			if(is_uploaded_file($_FILES[$field]['tmp_name']))
			{
				if(!(file_exists($dest) && is_dir($dest)))
				{
					mkdir($dest,0777);
					chmod($dest,0777);
				}
				$file=$pre.$_FILES[$field]['name'];
				$save=rtrim($dest,'/').'/'.$file;
				move_uploaded_file(($_FILES[$field]['tmp_name']),$save);
			}
			return $file;
		}
	}
	class DirectoryInfoTools
	{
		var $dirName;
		var $filesInFolder;
		var $onlyFiles;
		var $filters;
		var $blockfilters;
		var $onlyDirectories;
		var $prefix;
		
		var $flag;
		
		function DirectoryInfoTools()
		{
			$this->dirName="";
			$this->filesInFolder=array();
			$this->onlyFiles=array();
			$this->filters=array();
			$this->blockfilters=array();
			$this->onlyDirectories=array();
			$this->prefix='';
			
			$this->flag=false;
		}
		function getFileExtension($file)
		{
			return strtolower(substr($file,strrpos($file,'.')+1));
		}
		function getPermission($find)
		{
			if(file_exists($find))
				return substr(sprintf('%o', fileperms($find)), -4);
			else
				return 0;
		}
		function scanDirectory()
		{
			if(file_exists($this->dirName))
			{
				$handle=@opendir($this->dirName);
				while($fileOrFolName=@readdir($handle))
				{
					if(!($fileOrFolName=="." || $fileOrFolName==".."))
						array_push($this->filesInFolder,$fileOrFolName);
				}
				return true;
			}
			else
				return false;
		}
		function addPermission($files)
		{
			if(count($this->filters)==0 && count($this->blockfilters)==0)
				return true;
			elseif(count($this->filters) && count($this->blockfilters)==0 && in_array($this->getFileExtension($files),$this->filters))
				return true;
			elseif(count($this->filters)==0 && count($this->blockfilters) && !in_array($files,$this->blockfilters))
				return true;
			elseif(count($this->filters) && count($this->blockfilters) && in_array($this->getFileExtension($files),$this->filters) && !in_array($files,$this->blockfilters))
				return true;
			else
				return false;
		}
		function scanForFiles()
		{
			if($this->scanDirectory())
			{
				foreach($this->filesInFolder as $files)
				{
					if(!is_dir($this->dirName.'/'.$files))
					{
						if($this->addPermission($files))
							array_push($this->onlyFiles,$files);
					}
				}
				return true;
			}
			else
				return false;
		}
		function addFilters()
		{
			for($i=0;$i<func_num_args();$i++)
			{
				$filter=func_get_arg($i);
				array_push($this->filters,strtolower($filter));
			}
		}
		function blockFilters($filter)
		{
			array_push($this->blockfilters,strtolower($filter));
		}
		function scanForDirectories()
		{
			if($this->scanDirectory())
			{
				foreach($this->filesInFolder as $dir)
				{
					if(is_dir($this->dirName.'/'.$dir))
						array_push($this->onlyDirectories,$dir);
				}
				return true;
			}
			else
				return false;
		}
		function copyFolder($sourceFolder,$destinationFolder)
		{
			if(!$this->flag && $this->getPermission($destinationFolder)!='0777')
				return false;
			else
				$this->flag=true;
			
			if(!file_exists($destinationFolder))
			{
				@mkdir($destinationFolder,0777);
				@chmod($destinationFolder,0777);
			}
			
			if(file_exists($sourceFolder) && is_dir($sourceFolder) && file_exists($destinationFolder) && is_dir($destinationFolder))
			{
				$dirf=new DirectoryInfoTools();
				$dirf->dirName=$sourceFolder;
				if($dirf->scanDirectory())
				{
					foreach($dirf->filesInFolder as $files)
					{
						if(is_dir($sourceFolder.'/'.$files))
							$this->copyFolder($sourceFolder.'/'.$files,$destinationFolder.'/'.$files);
						else
						{
							if(count($this->filters)==0 || in_array($this->getFileExtension($files),$this->filters))
								@copy($sourceFolder.'/'.$files,$destinationFolder.'/'.$this->prefix.$files);
						}
					}
					return true;
				}
				else
					return false;
			}
			else
				return false;
		}
		function copyFilesFolder($sourceFolder,$destinationFolder)
		{
			/*if(!$this->flag && $this->getPermission($destinationFolder)!='0777')
				return false;
			else
				$this->flag=true;*/
			
			if(!file_exists($destinationFolder))
			{
				@mkdir($destinationFolder,0777);
				@chmod($destinationFolder,0777);
			}
			
			if(file_exists($sourceFolder) && is_dir($sourceFolder) && file_exists($destinationFolder) && is_dir($destinationFolder))
			{
				$dirf=new DirectoryInfoTools();
				$dirf->dirName=$sourceFolder;
				if($dirf->scanDirectory())
				{
					foreach($dirf->filesInFolder as $files)
					{
						if(is_dir($sourceFolder.'/'.$files))
							$this->copyFilesFolder($sourceFolder.'/'.$files,$destinationFolder);
						else
						{
							if(count($this->filters)==0 || in_array($this->getFileExtension($files),$this->filters))
								@copy($sourceFolder.'/'.$files,$destinationFolder.'/'.$this->prefix.$files);
						}
					}
					return true;
				}
				else
					return false;
			}
			else
				return false;
		}
		function deleteFolder($sourceFolder)
		{
			if(!$this->flag && $this->getPermission($sourceFolder)!='0777')
				return false;
			else
				$this->flag=true;
			
			if(file_exists($sourceFolder) && is_dir($sourceFolder))
			{
				$dirf=new DirectoryInfoTools();
				$dirf->dirName=$sourceFolder;
				if($dirf->scanDirectory())
				{
					foreach($dirf->filesInFolder as $files)
					{
						if(is_dir($sourceFolder.'/'.$files))
						{
							$this->deleteFolder($sourceFolder.'/'.$files);
							if(count($this->filters)==0)
								@rmdir($sourceFolder.'/'.$files);
						}
						else
						{
							if(count($this->filters)==0 || in_array($this->getFileExtension($files),$this->filters))
								@unlink($sourceFolder.'/'.$files);
						}
					}
					return true;
				}
				else
					return false;
			}
			else
				return false;
		}
		function moveFolder($sourceFolder,$destinationFolder)
		{
			if(!$this->flag && $this->getPermission($destinationFolder)!='0777')
				return false;
			else
				$this->flag=true;
			
			if(!file_exists($destinationFolder))
			{
				@mkdir($destinationFolder,0777);
				@chmod($destinationFolder,0777);
			}
			
			if(file_exists($sourceFolder) && is_dir($sourceFolder) && file_exists($destinationFolder) && is_dir($destinationFolder))
			{
				$dirf=new DirectoryInfoTools();
				$dirf->dirName=$sourceFolder;
				if($dirf->scanDirectory())
				{
					foreach($dirf->filesInFolder as $files)
					{
						if(is_dir($sourceFolder.'/'.$files))
						{
							$this->copyFolder($sourceFolder.'/'.$files,$destinationFolder.'/'.$files);
							if(count($this->filters)==0)
								@rmdir($sourceFolder.'/'.$files);
						}
						else
						{
							if(count($this->filters)==0 || in_array($this->getFileExtension($files),$this->filters))
							{
								@copy($sourceFolder.'/'.$files,$destinationFolder.'/'.$this->prefix.$files);
								@unlink($sourceFolder.'/'.$files);
							}
						}
					}
					return true;
				}
				else
					return false;
			}
			else
				return false;
		}
	}
	class Upload
	{
		function uploadpic($field,$dest,$pre="")
		{
			$file="";
			if(is_uploaded_file($_FILES[$field]['tmp_name']))
			{
				if(!(file_exists($dest) && is_dir($dest)))
				{
					mkdir($dest,0777);
					chmod($dest,0777);
				}
				$file=$pre.$_FILES[$field]['name'];
				$save=rtrim($dest,'/').'/'.$file;
				move_uploaded_file(($_FILES[$field]['tmp_name']),$save);
			}
			return $file;
		}
	}
?>