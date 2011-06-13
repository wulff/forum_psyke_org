<?php
/**
*
* @package Post Count Requirements
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
* Class for Post Count Requirements core
**/
abstract class pcr_core
{
	static public function init()
	{
		pcr_phpbb::$user->add_lang('mods/pcr');
	}

	static public function check_pcr($forum_id, $type)
	{
		$forum_id = intval($forum_id);
		$sql = "SELECT f.*
			FROM " . FORUMS_TABLE . " f
			WHERE f.forum_id = $forum_id";
		$result = pcr_phpbb::$db->sql_query($sql);
		$forum_data = pcr_phpbb::$db->sql_fetchrow($result);
		pcr_phpbb::$db->sql_freeresult($result);
		
		switch ($type)
		{
			case 'view':
				if (pcr_phpbb::$user->data['user_posts'] < $forum_data['forum_postcount_view'])
				{
					return false;
				}
				else
				{
					return true;
				}
			break;

			case 'post':
				if (pcr_phpbb::$user->data['user_posts'] < $forum_data['forum_postcount_post'])
				{
					return false;
				}
				else
				{
					return true;
				}
			break;
		}
	}
}

?>