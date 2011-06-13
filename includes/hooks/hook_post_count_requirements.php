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
* Class that contains all hooked methods
**/
abstract class pcr_hook
{
	/**
	* Register all hooks
	* @author Erik Frèrejean
	**/
	static public function register(&$phpbb_hook)
	{
		$phpbb_hook->register('phpbb_user_session_handler', 'pcr_hook::post_count_requirements_init');
		$phpbb_hook->register(array('template', 'display'), 'pcr_hook::post_count_requirements_pages');
	}

	/**
	* A hook that is used to initialise the Post Count Requirements core
	* @author Erik Frèrejean
	**/
	static public function post_count_requirements_init(&$hook)
	{

		if (!class_exists('pcr_phpbb'))
		{
			global $phpbb_root_path, $phpEx;

			require($phpbb_root_path . 'includes/mods/post_count_requirements/pcr_phpbb.' . $phpEx);
			pcr_phpbb::init();
		}

		if (!class_exists('pcr_core'))
		{
			global $phpbb_root_path, $phpEx;

			require ($phpbb_root_path . 'includes/mods/post_count_requirements/pcr_core.' . $phpEx);
			pcr_core::init();
		}
	}

	/**
	* A hook that checks auth for pages
	**/
	static public function post_count_requirements_pages(&$hook)
	{
		global $phpbb_root_path, $phpEx;

		if (!empty(pcr_phpbb::$user->page['page_dir']))
		{
			return;
		}

		// Is user allowed to bypass the post count requirements?
		$pcr_bypass = false;

		$sql = "SELECT * 
			FROM " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g 
			WHERE ug.user_id = " . pcr_phpbb::$user->data['user_id'] . " AND ug.group_id = g.group_id";
		$result = pcr_phpbb::$db->sql_query($sql);

		while ($row = pcr_phpbb::$db->sql_fetchrow($result))
		{
			if ($row['group_bypass_post_req'] == 1)
			{
				$pcr_bypass = true;
			}
		}
		pcr_phpbb::$db->sql_freeresult($result);

		// Page specific cases
		switch (pcr_phpbb::$user->page['page_name'])
		{
			case 'posting.' . $phpEx:
				global $forum_id;

				// Does the user have the required post count to post in this forum?
				$forum_id = intval($forum_id);
				$sql = "SELECT f.*
					FROM " . FORUMS_TABLE . " f
					WHERE f.forum_id = $forum_id";
				$result = pcr_phpbb::$db->sql_query($sql);
				$forum_data = pcr_phpbb::$db->sql_fetchrow($result);
				pcr_phpbb::$db->sql_freeresult($result);

				if (pcr_core::check_pcr($forum_id, 'post') == false && $pcr_bypass == false)
				{
					$remaining_posts = ($forum_data['forum_postcount_post'] - pcr_phpbb::$user->data['user_posts']);
					$posts_var_1 = ($forum_data['forum_postcount_post'] == 1) ? pcr_phpbb::$user->lang['POSTREQ_POST'] : pcr_phpbb::$user->lang['POSTREQ_POSTS'];
					$posts_var_2 = ($remaining_posts == 1) ? pcr_phpbb::$user->lang['POSTREQ_POST'] : pcr_phpbb::$user->lang['POSTREQ_POSTS'];
					$access_error = sprintf(pcr_phpbb::$user->lang['POSTREQ_NOACCESS_POST'], $forum_data['forum_postcount_post'], $posts_var_1);
					if (pcr_phpbb::$user->data['user_id'] != ANONYMOUS)
					{
						$needed_posts = "<br /><br />" . sprintf(pcr_phpbb::$user->lang['POSTREQ_NOACCESS_MORE'], $remaining_posts, $posts_var_2);
					}
					else
					{
						$needed_posts = '';
					}

					trigger_error($access_error . $needed_posts);
				}
			break;

			case 'viewforum.' . $phpEx:
				global $forum_id;

				// Does the user have the required post count to view this forum?
				$forum_id = intval($forum_id);
				$sql = "SELECT f.*
					FROM " . FORUMS_TABLE . " f
					WHERE f.forum_id = $forum_id";
				$result = pcr_phpbb::$db->sql_query($sql);
				$forum_data = pcr_phpbb::$db->sql_fetchrow($result);
				pcr_phpbb::$db->sql_freeresult($result);

				if (pcr_core::check_pcr($forum_id, 'view') == false && $pcr_bypass == false)
				{
					$remaining_posts = ($forum_data['forum_postcount_view'] - pcr_phpbb::$user->data['user_posts']);
					$posts_var_1 = ($forum_data['forum_postcount_view'] == 1) ? pcr_phpbb::$user->lang['POSTREQ_POST'] : pcr_phpbb::$user->lang['POSTREQ_POSTS'];
					$posts_var_2 = ($remaining_posts == 1) ? pcr_phpbb::$user->lang['POSTREQ_POST'] : pcr_phpbb::$user->lang['POSTREQ_POSTS'];
					$access_error = sprintf(pcr_phpbb::$user->lang['POSTREQ_NOACCESS_VIEW'], $forum_data['forum_postcount_view'], $posts_var_1);
					if (pcr_phpbb::$user->data['user_id'] != ANONYMOUS)
					{
						$needed_posts = "<br /><br />" . sprintf(pcr_phpbb::$user->lang['POSTREQ_NOACCESS_MORE'], $remaining_posts, $posts_var_2);
					}
					else
					{
						$needed_posts = '';
					}

					trigger_error($access_error . $needed_posts);
				}
			break;

			case 'viewtopic.' . $phpEx:
				global $forum_id;

				// Does the user have the required post count to view this forum?
				$forum_id = intval($forum_id);
				$sql = "SELECT f.*
					FROM " . FORUMS_TABLE . " f
					WHERE f.forum_id = $forum_id";
				$result = pcr_phpbb::$db->sql_query($sql);
				$forum_data = pcr_phpbb::$db->sql_fetchrow($result);
				pcr_phpbb::$db->sql_freeresult($result);

				if (pcr_core::check_pcr($forum_id, 'view') == false && $pcr_bypass == false)
				{
					$remaining_posts = ($forum_data['forum_postcount_view'] - pcr_phpbb::$user->data['user_posts']);
					$posts_var_1 = ($forum_data['forum_postcount_view'] == 1) ? pcr_phpbb::$user->lang['POSTREQ_POST'] : pcr_phpbb::$user->lang['POSTREQ_POSTS'];
					$posts_var_2 = ($remaining_posts == 1) ? pcr_phpbb::$user->lang['POSTREQ_POST'] : pcr_phpbb::$user->lang['POSTREQ_POSTS'];
					$access_error = sprintf(pcr_phpbb::$user->lang['POSTREQ_NOACCESS_VIEW'], $forum_data['forum_postcount_view'], $posts_var_1);
					if (pcr_phpbb::$user->data['user_id'] != ANONYMOUS)
					{
						$needed_posts = "<br /><br />" . sprintf(pcr_phpbb::$user->lang['POSTREQ_NOACCESS_MORE'], $remaining_posts, $posts_var_2);
					}
					else
					{
						$needed_posts = '';
					}

					trigger_error($access_error . $needed_posts);
				}
			break;
		}
	}
}

pcr_hook::register($phpbb_hook);

?>