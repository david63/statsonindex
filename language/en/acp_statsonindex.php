<?php
/**
*
* @package Statistics on Index Extension
* @copyright (c) 2015
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

/**
* DO NOT CHANGE
*/
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
	'ADMIN_STATS'				=> 'Only show Admin extended statistics',
	'ADMIN_STATS_EXPLAIN'		=> 'Hide the extended statistics on the board index from members.',

	'GUEST_STATS'				=> 'Show extended statistics to guests',
	'GUEST_STATS_EXPLAIN'		=> 'Allow guests to see the extended statistics.',

	'INCLUDE_BOTS'				=> 'Include Bots',
	'INCLUDE_BOTS_EXPLAIN'		=> 'Include Bots who have visited the board in the last 24 hours.',
	'INCLUDE_DAYS'				=> 'Include days',
	'INCLUDE_DAYS_EXPLAIN'		=> 'Include the number of days since the board was started.',
	'INCLUDE_SUMMARY'			=> 'Repeat summary items',
	'INCLUDE_SUMMARY_EXPLAIN'	=> 'Include the summary items with the extended statistics.',

	'SHOW_STATS'				=> 'Show extended statistics',
	'SHOW_STATS_EXPLAIN'		=> 'Show the extended statistics on the index page.',
	'SHOW_USERS'				=> 'Show user statistics',
	'SHOW_USERS_EXPLAIN'		=> 'Show the user visited in the last 24 hours statistics on the index page.',
	'STATS_ON_INDEX_EXPLAIN'	=> 'Here you can set the display options for the displaying of extended statistics.',
	'STATS_ON_INDEX_OPTIONS'	=> 'Extended statistics options',
));
