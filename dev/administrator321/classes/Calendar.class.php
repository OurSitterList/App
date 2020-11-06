<?
	class Calendar
	{
		var $months;
		var $days;
		var $daysInMonth;
		
		var $currYear;
		var $currMonth;
		var $currDate;
		
		var $monthID;
		var $yearID;
		
		var $fDay;
		var $lDay;
		var $fmonthID;
		var $lmonthID;
		
		var $dailyTickets;
		function Calendar()
		{
			$con=new DBConnection(host,user,pass,db);
			$conObj=$con->connectDB(true);
			$this->months=array(1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December');
			$this->days=array('Sunday','Monday','Tuesday','Wednessday','Thursday','Friday','Saturday');
			$this->currYear=date('Y');
			$this->currMonth=intval(date('m'));
			$this->currDate=date('d');
			
			$startyear=mysql_fetch_object(mysql_query("select settingValue from setting where id=18"));
			$YY=$this->currYear-$startyear->settingValue;
			if(isset($_GET['yearID'],$_GET['monthID']) && is_numeric($_GET['yearID']) && is_numeric($_GET['monthID']))
			{
				if($_GET['yearID']>=$this->currYear-$YY && $_GET['yearID']<=$this->currYear+2)
					$this->yearID=$_GET['yearID'];
				else
					$this->yearID=$this->currYear;
				
				if($_GET['monthID']>=1 && $_GET['monthID']<=12)
					$this->monthID=$_GET['monthID'];
				else
					$this->monthID=$this->currMonth;
				
				if(($this->yearID==$this->currYear-1 && $this->monthID<$this->currMonth) || ($this->yearID==$this->currYear+2 && $this->monthID>$this->currMonth))
				{
					$this->yearID=$this->currYear;
					$this->monthID=$this->currMonth;
				}
			}
			else
			{
				$this->yearID=$this->currYear;
				$this->monthID=$this->currMonth;
			}
			$this->yearID=intval($this->yearID);
			$this->monthID=intval($this->monthID);
			$this->daysInMonth=cal_days_in_month(CAL_GREGORIAN,$this->monthID,$this->yearID);
			#$this->fDay=($this->monthID==$this->currMonth && $this->yearID==$this->currYear-1)?date('d'):1;
			$this->fDay=1;
			#$this->lDay=($this->monthID==$this->currMonth && $this->yearID==$this->currYear+2)?date('d'):$this->daysInMonth;
			$this->lDay=$this->daysInMonth;
			$this->fDayofWeek=$this->getDay($this->fDay,$this->monthID,$this->yearID);
			#$this->fmonthID=($this->yearID==$this->currYear-1)?$this->currMonth:1;
			$this->fmonthID=1;
			#$this->lmonthID=($this->yearID==$this->currYear+2)?$this->currMonth:12;
			$this->lmonthID=12;
			
			$this->setDailyTickets();
		}
		function setDailyTickets()
		{
			$con=new DBConnection(host,user,pass,db);
			$conObj=$con->connectDB(true);
			$Q="SELECT
				s.settingValue AS tick
				FROM
				setting AS s
				WHERE
				s.id =  '7'";
			$Rec=mysql_query($Q,$conObj) or die(mysql_error());
			$R=mysql_fetch_object($Rec);
			$this->dailyTickets=$R->tick;
		}
		function getDay($date,$month,$year)
		{
			return date('w',mktime(0,0,0,$month,$date,$year));
		}
		function getNumTickets($id)
		{
			$con=new DBConnection(host,user,pass,db);
			$conObj=$con->connectDB(true);
			$Q="SELECT
				Sum(bm.bticket) AS sold
				FROM
				booking_master AS bm";
			$Rec=mysql_query($Q,$conObj) or die(mysql_error());
			$R=mysql_fetch_object($Rec);
			$this->dailyTickets=$R->ticket;
			if($R->sold=='')
				$remains=$this->dailyTickets;
			else
				$remains=$this->dailyTickets-$R->sold;
			
			return $remains;
		}
		function showCalendar()
		{
?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
      <tr>
        <td colspan="2" align="left" valign="top" class="cal_header">Calendar For <?=$this->months[$this->monthID]?>, <?=$this->yearID?></td>
      </tr>
      <tr>
        <td width="100" align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
          <tr>
            <td align="left" valign="middle" class="cal_month_header">Month</td>
          </tr>
<?
	
	for($i=$this->fmonthID;$i<=$this->lmonthID;$i++)
	{
		if($i==$this->monthID)
			$css='cal_month_hover';
		else
			$css='cal_month monthCal';
?>
          <tr>
            <td align="left" valign="middle" class="<?=$css?>" style="cursor:pointer;" title="<?=$i?>"><?=$this->months[$i]?></td>
          </tr>
<?
	}
?>
        </table></td>
        <td align="left" valign="top"><table border="0" align="left" cellpadding="3" cellspacing="1">
          <tr>
<?
	foreach($this->days as $day)
	{
?>
            <td width="100" align="center" valign="middle" class="cal_days"><?=$day?></td>
<?
	}
?>
          </tr>
<?
	$loop=ceil(($this->lDay-$this->fDay+1+$this->fDayofWeek)/7)*7;
	$date=intval($this->fDay);
	
	if($this->monthID<10)
			$this->monthID='0'.$this->monthID;
	for($i=0;$i<$loop;$i++)
	{
		
		if($this->currYear==$this->yearID && $this->currMonth==$this->monthID && $this->currDate==$date && $this->fDayofWeek==$i)
			$css='cal_curday';
		elseif($i%7==0)
		{
			echo '<tr>';
			$css='cal_sunday';
		}
		elseif($i%7==6)
			$css='cal_satday';
		else
			$css='cal_weekday';
?>
            <td align="center" valign="top" class="<?=$css?>">
<?
		$con=new DBConnection(host,user,pass,db);
		$conObj=$con->connectDB(true);
		
		if($i>=$this->fDayofWeek && $date>=$this->fDay && $date<=$this->lDay)
		{
		$sel=$this->yearID.'/'.$this->monthID.'/'.$date;
		
		#print $sel;
		$ticketday=mysql_fetch_object(mysql_query("select settingValue from setting where id=17"));
		
		if($date<10)
			$date='0'.$date;
			
		
		
		$Q="SELECT
			SUM(B.bticket) as totbookedticket
			FROM
			booking_master AS B
			WHERE
			B.bookindDate like('".$this->yearID.'-'.$this->monthID.'-'.$date."%')
			ORDER BY
			B.id ASC";
			
	
	#print $Q;
		$eRec=mysql_query($Q,$conObj) or die(mysql_error());
?>
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="browse" style="cursor:pointer;" title="<?=$date?>">
                <tr>
                  <td height="30" align="right" valign="top"><?=$date?></td>
                </tr>
                <tr>
                  <td height="30" align="right" valign="top">
<?
			for($k=1;$eR=mysql_fetch_object($eRec);$k++)
			{
				if($eR->totbookedticket=='')
					$eR->totbookedticket=0;
				$text=$eR->totbookedticket.'/'.$ticketday->settingValue.'<br>';
			}
			print $text
?>
				</td>
              </tr>
              </table>
<?
			$date++;
		}
		else
			echo '&nbsp;';
?>
              </td>
<?
		if($i%7==6)
			echo '</tr>';
	}
?>
        </table>
        </td>
      </tr>
    </table>
<?
		}
	}
?>