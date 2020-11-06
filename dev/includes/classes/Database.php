<?php
class Database
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
	function connectDB($standard = false){
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
?>