<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class SDGAME
{
	// -----------------------------------------------------------------------------------------------------------------
	
	public static function pwEncode($pw, $salt)
	{
		return md5( substr($salt, 0, 4) . $pw . substr($salt, 4) );
	}

	public static function createSalt()
	{
		// generate an 8 character salt used in various occasions
		$salt = md5(date('YmdHis'));
		$salt = substr($salt, 0, 8);
		return $salt;
	}

	// -----------------------------------------------------------------------------------------------------------------
	
	public static function time()
	{
		date_default_timezone_set(Yii::app()->params['baseTimeZone']);
		return time(); // returns the current time measured in the number of seconds since the Unix Epoch 
	}
	
	public static function datetime()
	{
		date_default_timezone_set(Yii::app()->params['baseTimeZone']);
		return date('Y-m-d H:i:s');
	}
	
	public static function timeDiffInSeconds($t1, $t2)
	{
		// datetime is saved in seconds, so simple subtraction is enough
		return $t1 - $t2;
	}
	
	public static function formatedDateFromTS($timestamp, $include_day=false, $short_month=false, $include_time=false, $inc_year=true)
	{	
		date_default_timezone_set(Yii::app()->params['baseTimeZone']);
		
		if ($short_month)
		{
			return date(($include_day?"j ":"") . "M".($inc_year?" Y":"").($include_time?", H:i":""), $timestamp);
		}

		return date(($include_day?"j ":"") . "F".($inc_year?" Y":"").($include_time?", H:i":""), $timestamp);
	}
		
	public static function formatedDateFromDT($datetime, $include_day=false, $short_month=false, $include_time=false, $inc_year=true)
	{
		return SDGAME::formatedDateFromTS(strtotime($datetime), $include_day, $short_month, $include_time, $inc_year);
	}

	// -----------------------------------------------------------------------------------------------------------------
	
	public static function getFirstError($arr)
	{	// return first element of element in array else empty string
		if (count($arr)>0)
		{
			foreach($arr as $a)
			{
				return $a[0]; // just return with first one hit
			}
		}
		return "";
	}
	
	// -----------------------------------------------------------------------------------------------------------------
}