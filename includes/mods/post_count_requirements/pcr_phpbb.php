<?php
/**
*
* @package Post Count Requirements
* @author Erik Frèrejean
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
**/

/**
* @ignore
**/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* Class for common phpBB objects
**/
abstract class pcr_phpbb
{
	/**
	* Common phpBB objects
	**/
	static public $auth		= null;
	static public $cache	= null;
	static public $config	= array();
	static public $db		= null;
	static public $template	= null;
	static public $user		= null;

	/**
	* Initialise this object
	**/
	static public function init()
	{
		// Run only once
		if (self::$cache instanceof acm)
		{
			return;
		}

		// Set phpBB objects
		global $auth, $config, $cache, $db, $template, $user;
		self::$auth		= &$auth;
		self::$cache	= &$cache;
		self::$config	= &$config;
		self::$db		= &$db;
		self::$template	= &$template;
		self::$user		= &$user;
	}
}

?>