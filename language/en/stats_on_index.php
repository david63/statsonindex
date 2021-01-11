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
	$lang = [];
}

/**
 * DEVELOPERS PLEASE NOTE
 *
 * All language files should use UTF-8 as their encoding and the files must not contain a BOM.
 *
 * Placeholders can now contain order information, e.g. instead of
 * 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
 * translators to re-order the output of data while ensuring it remains correct
 *
 * You do not need this where single placeholders are used, e.g. 'Message %d' is fine
 * equally where a string contains only two placeholders which are used to wrap text
 * in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
 *
 * Some characters you may want to copy&paste:
 * ’ » “ ” …
 *
 */

$lang = array_merge($lang, [
	'BOTS'					=> 'Bots',

	'FILE_PER_DAY'			=> 'Attachments per day <strong>%1$s</strong>',
	'FILES_PER_USER'		=> 'Attachments per member <strong>%1$s</strong>',
	'FILES_PER_YEAR'		=> 'Attachments per year <strong>%1$s</strong>',

	'HIDE' 					=> '&nbsp;«« hide ««',

	'NONE'					=> 'None',

	'POST_PER_DAY'			=> 'Posts per day <strong>%1$s</strong>',
	'POSTS_PER_TOPIC'		=> 'Posts per topic <strong>%1$s</strong>',
	'POSTS_PER_USER'		=> 'Posts per member <strong>%1$s</strong>',
	'POSTS_PER_YEAR'		=> 'Posts per year <strong>%1$s</strong>',

	'START_DATE'			=> 'We have been online since',
	'SUMMARY'				=> '<strong>Summary</strong>',

	'TFHOUR_POSTS'			=> 'New Posts <strong>%1$s</strong>',
	'TFHOUR_TOPICS'			=> 'New Topics <strong>%1$s</strong>',
	'TFHOUR_USERS'			=> 'New users <strong>%1$s</strong>',
	'TOPIC_PER_DAY'			=> 'Topics per day <strong>%1$s</strong>',
	'TOPICS_PER_USER'		=> 'Topics per member <strong>%1$s</strong>',
	'TOPICS_PER_YEAR'		=> 'Topics per year <strong>%1$s</strong>',
	'TOTAL_FILES'			=> 'Total attachments <strong>%1$s</strong>',
	'TWENTYFOURHOUR_STATS'	=> 'Activity over the last 24 hours',

	'USER_PER_DAY'			=> 'Members per day <strong>%1$s</strong>',
	'USERS_PER_YEAR'		=> 'Members per year <strong>%1$s</strong>',
	'USERS_TFHOUR_TOTAL'	=> array(
		1	=> '%1$s User active over the last 24 hours',
		2	=> '%1$s Users active over the last 24 hours',
	),

	'VIEW' 					=> '»» view more »»',

	// Reformat these for output consisency
	'TOTAL_POSTS_COUNT'		=> 'Total posts <strong>%1$s</strong>',
	'TOTAL_TOPICS'			=> 'Total topics <strong>%1$s</strong>',
	'TOTAL_USERS'			=> 'Total members <strong>%1$s</strong>',
]);
