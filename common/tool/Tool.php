<?php
namespace common\tool;

class Tool
{
	public static function getCurrentUrl()
	{
		return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	}

}
