<?php
	class PageStructure
	{
		var $title;
		
		function PageStructure($title="")
		{
			$this->title=$title;  
		}
		function pageTop()
		{
			error_reporting(E_ALL & ~E_NOTICE);			
			ob_start();
			session_start();
		}
		function condition()
		{
		
		}
		function pageHeadTag()
		{

		}
	}
?>