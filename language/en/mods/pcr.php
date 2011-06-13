<?php
/**
*
* @package Post Count Requirements
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
**/

/**
* DO NOT CHANGE
**/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'POSTREQ_POST'				=>	'post',
	'POSTREQ_POSTS'				=>	'posts',
	'POSTREQ_NOACCESS_VIEW'		=>	'You do not have the required post count to view this forum.<br />In order to view this forum, you must have %1$d %2$s.',
	'POSTREQ_NOACCESS_POST'		=>	'You do not have the required post count to post in this forum.<br />In order to make a post in this forum, you must have %1$d %2$s.',
	'POSTREQ_NOACCESS_MORE'		=>	'You only need %1$d more %2$s.',

	'POSTREQ_VIEW_TITLE'		=>	'View Forum Post Requirement',
	'POSTREQ_VIEW_EXPLAIN'		=>	'By setting this value to 0, this post count requirement will be disabled.',
	'POSTREQ_POST_TITLE'		=>	'New Topic/Reply Post Requirement',
	'POSTREQ_POST_EXPLAIN'		=>	'By setting this value to 0, this post count requirement will be disabled.',

	'POSTREQ_BYPASS'			=>	'Bypass Post Count Requirements',
	'POSTREQ_BYPASS_EXPLAIN'	=>	'This group and its members can access forums even if they do not have the required post count.',

));

?>