<?php

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
			
			$this->months=array(1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December');
			$this->days=array('Sunday','Monday','Tuesday','Wednessday','Thursday','Friday','Saturday');
			$this->currYear=date('Y');
			$this->currMonth=intval(date('m'));
			$this->currDate=date('d');
			
			$startyear=mysql_fetch_object(mysql_query("select settingValue from setting where id=18"));
			$YY=$this->currYear-$startyear->settingValue;
			#print $YY.'asdasd';
			if(isset($_GET['yearID'],$_GET['monthID']) && is_numeric($_GET['yearID']) && is_numeric($_GET['monthID']))
			{
				if($_GET['yearID']>=$startyear->settingValue)
				{
					$this->yearID=$_GET['yearID'];
					#print 'in'.$this->yearID;
				}
				else
				{
					$this->yearID=$this->currYear;
					#print 'inelse';
				}
				
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
				#print 'current';
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
			
			$this->monthID1=intval($this->monthID)+1;
			if($this->monthID1<=12)
			{
				$this->daysInMonth1=cal_days_in_month(CAL_GREGORIAN,$this->monthID1,$this->yearID);
				#$this->fDay1=($this->monthID1==($this->currMonth+1) && $this->yearID==$this->currYear-1)?date('d'):1;
				$this->fDay1=1;
				#$this->lDay=($this->monthID==$this->currMonth && $this->yearID==$this->currYear+2)?date('d'):$this->daysInMonth;
				$this->lDay1=$this->daysInMonth1;
				$this->fDayofWeek1=$this->getDay($this->fDay1,$this->monthID1,$this->yearID);
				#$this->fmonthID1=($this->yearID==$this->currYear-1)?$this->currMonth:1;
				$this->fmonthID1=1;
				#$this->lmonthID=($this->yearID==$this->currYear+2)?$this->currMonth:12;
				$this->lmonthID1=12;
				
				$this->setDailyTickets();
			}
		}
		function setDailyTickets()
		{
			
			$Q="SELECT
				s.settingValue AS tick
				FROM
				setting AS s
				WHERE
				s.id =  '7'";
			$Rec=mysql_query($Q) or die(mysql_error());
			$R=mysql_fetch_object($Rec);
			$this->dailyTickets=$R->tick;
		}
		function getDay($date,$month,$year)
		{
			return date('w',mktime(0,0,0,$month,$date,$year));
		}
		function getNumTickets($id)
		{
			
			$Q="SELECT
				Sum(bm.bticket) AS sold
				FROM
				booking_master AS bm";
			$Rec=mysql_query($Q) or die(mysql_error());
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
		
			$QD="SELECT b.id AS id,coupon ,b.discount  FROM tbl_date AS b where isactive='1'";
			$RecD=mysql_query($QD) or die(mysql_error().'select 1');
			$ND=mysql_num_rows($RecD);
			if($ND)
			{
				for($dd=0;$dd<$ND;$dd++)
				{
					
					$obj_date=mysql_fetch_object($RecD);
					
					$df[]=$obj_date->coupon;
					$dt[]=$obj_date->discount;
				}
			}
			
			
?>
<tr>
  <td><table width="100%" border="0" cellspacing="0" cellpadding="1">
    <tr>
      <td width="29">
      <?
      	//print $this->currYear.'||'.$this->yearID.'||'.$this->monthID;
		if(($this->currYear<=$this->yearID && $this->monthID!=1) || ($this->currYear<$this->yearID))
		{
			if($this->monthID>1)
			{
				$pmonth=$this->monthID-2;
				$year=$this->yearID;
				
			}
			else
			{
				$pmonth=11;
				$year=$this->yearID-1;
			}
		
	  ?>
      <a href="#" onclick="javascript:return nextmonth(<?=($pmonth)?>,<?=$year?>)" title="<?=$pmonth.'||'.$year?>"><img src="images/prev.gif" alt="Previous" width="29" height="17" border="0" /></a>
      <?
      	}
	  ?>
      </td>
      <td width="253" align="center" class="month"><?=$this->months[$this->monthID]?></td>
      <td width="12" class="month"><?=$this->yearID?></td>
      <td width="253" align="center" class="month">
	  <?
      	if($this->monthID1<=12)
		{
	  ?>
	  <?=$this->months[$this->monthID1]?>
      <?
      	}
		else
			print '&nbsp;';	
	  ?>
      </td>
      <td width="29" align="right">
      <?
      	/*if($this->monthID1<12)
		{*/
		if($this->monthID1<12)
		{
			$nmonth=$this->monthID+2;
			$year=$this->yearID;
		}
		else
		{
			$nmonth=1;
			$year=$this->yearID+1;
		}
		
	  ?>
        <a href="#"  onclick="javascript:return nextmonth(<?=($nmonth)?>,<?=$year?>)"><img src="images/next.gif" alt="Next" width="29" height="17" border="0" /></a>
      <?
      	/*}*/
	  ?>
        </td>
    </tr>
  </table></td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
<div class="col-1">
    <div class="box2 ">
        <div class="indent3">
          <table width="100%" border="0" cellpadding="0" cellspacing="1" class="calendar">
            <tr class="day">
<?
	
	foreach($this->days as $day)
	{
?>
            <td align="center"><?=substr($day,0,3)?></td>
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
		
		$ticketday=mysql_fetch_object(mysql_query("select settingValue from setting where id=17"));
		$oncl='';
		$bg='';
		$Q="SELECT
			SUM(B.bticket) as totbookedticket
			FROM
			booking_master AS B
			WHERE
			B.bookindDate like('".$this->yearID.'-'.$this->monthID.'-'.$date."%')
			ORDER BY
			B.id ASC";
	
		$eRec=mysql_query($Q) or die(mysql_error());
		
		for($k=1;$eR=mysql_fetch_object($eRec);$k++)
		{
			if($eR->totbookedticket=='')
				$eR->totbookedticket=0;
			$text=$eR->totbookedticket.'<br>';
			$text1=$eR->totbookedticket;
		}
		
		$css='dayInMonth';
		if($this->yearID.'-'.$this->monthID.'-'.$date==$curtdate)
			$css='currentDayDec';
		else if($text==$ticketday->settingValue)
			$css='currentFull';
			
			if($i>=$this->fDayofWeek && $date>=$this->fDay && $date<=$this->lDay)
			{
				if($date<10)
					$date='0'.$date;
					
				$oncl='';
				$bg='';
				for($cd=0;$cd<count($dt);$cd++)
				{
					
					
					if($this->yearID.'-'.$this->monthID.'-'.$date>=$df[$cd] && $this->yearID.'-'.$this->monthID.'-'.$date<=$dt[$cd])
					{
						$bg='Sold Out';
						$oncl='';
						$css='currentFull_SD';
						break;
					}
					else
					{
						$bg='';
						$oncl='onclick="javascript:return getclickdate(\''.$this->yearID.'-'.$this->monthID.'-'.$date.'\')" style="cursor:pointer" title="Click To Set The Date Of Booking"';	
					}
				}	
			}
		if($i%7==0)
			echo '<tr>';
?>
            <td align="center" valign="middle" width="14%" class="<?=$css?>" <?=$oncl?>>
<?
		
		
		if($i>=$this->fDayofWeek && $date>=$this->fDay && $date<=$this->lDay)
		{
		$sel=$this->yearID.'/'.$this->monthID.'/'.$date;
		
	
					  	if($bg!='')
					  		print $bg;
						else
							print $date;
			$date++;
		}
		else
			echo '&nbsp;';
?>              </td>
<?
		if($i%7==6)
			echo '</tr>';
	}
?>
        </table>
        <div class="clear">
            </div>
        </div>
    </div>
</div>
<?
	if($this->monthID1<=12)
	{
?>
<div class="col-2 ">
    <div class="box2 ">
        <div class="indent3">
          <table width="100%" border="0" cellpadding="0" cellspacing="1" class="calendar">
            <tr class="day">
<?
	
	foreach($this->days as $day)
	{
?>
            <td align="center"><?=substr($day,0,3)?></td>
<?
	}
?>
          </tr>
<?
	$loop=ceil(($this->lDay1-$this->fDay1+1+$this->fDayofWeek1)/7)*7;
	$date=intval($this->fDay1);
	
	if($this->monthID1<10)
			$this->monthID1='0'.$this->monthID1;
			
			
	for($i=0;$i<$loop;$i++)
	{
		
		$ticketday=mysql_fetch_object(mysql_query("select settingValue from setting where id=17"));
		$oncl='';
		$bg='';
		$Q="SELECT
			SUM(B.bticket) as totbookedticket
			FROM
			booking_master AS B
			WHERE
			B.bookindDate like('".$this->yearID.'-'.$this->monthID1.'-'.$date."%')
			ORDER BY
			B.id ASC";
	
		$eRec=mysql_query($Q) or die(mysql_error());
		
		for($k=1;$eR=mysql_fetch_object($eRec);$k++)
		{
			if($eR->totbookedticket=='')
				$eR->totbookedticket=0;
			$text=$eR->totbookedticket.'<br>';
			$text1=$eR->totbookedticket;
		}
		
		$css='dayInMonth';
		if($this->yearID.'-'.$this->monthID1.'-'.$date==$curtdate)
			$css='currentDayDec';
		else if($text1==$ticketday->settingValue)
			$css='currentFull';
			
			if($i>=$this->fDayofWeek1 && $date>=$this->fDay1 && $date<=$this->lDay1)
			{
				if($date<10)
					$date='0'.$date;
					
				
				for($cd=0;$cd<count($dt);$cd++)
				{
					$bg='';
					$oncl='onclick="javascript:return getclickdate(\''.$this->yearID.'-'.$this->monthID1.'-'.$date.'\')" style="cursor:pointer" title="Click To Set The Date Of Booking"';
					if($this->yearID.'-'.$this->monthID1.'-'.$date>=$df[$cd] && $this->yearID.'-'.$this->monthID1.'-'.$date<=$dt[$cd])
					{
						$bg='Sold Out';
						$oncl='';
						$css='currentFull_SD';
						break;
					}
				}	
			}
		if($i%7==0)
			echo '<tr>';
?>
            <td align="center" valign="middle" width="14%" class="<?=$css?>" <?=$oncl?>>
<?
		
		
		if($i>=$this->fDayofWeek1 && $date>=$this->fDay1 && $date<=$this->lDay1)
		{
		$sel=$this->yearID.'/'.$this->monthID1.'/'.$date;
		
	
					  	if($bg!='')
					  		print $bg;
						else
							print $date;
			$date++;
		}
		else
			echo '&nbsp;';
?>              </td>
<?
		if($i%7==6)
			echo '</tr>';
	}
?>
        </table>
        </div>
    </div>
</div>
<?
	}
		}
	}
?>