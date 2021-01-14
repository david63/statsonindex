<?php
/**
 *
 * @package Statistics on Index Extension
 * @copyright (c) 2015
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace david63\statsonindex\controller;

use phpbb\config\config;
use phpbb\template\template;
use phpbb\user;
use phpbb\db\driver\driver_interface;
use phpbb\cache\service;
use phpbb\auth\auth;
use phpbb\language\language;

/**
 * Main controller
 */
class main_controller
{
	/** @var config */
	protected $config;

	/** @var template */
	protected $template;

	/** @var user */
	protected $user;

	/** @var driver_interface */
	protected $db;

	/** @var service */
	protected $cache;

	/** @var auth */
	protected $auth;

	/** @var language */
	protected $language;

	/** @var array phpBB tables */
	protected $tables;

	/**
	 * Constructor for admin controller
	 *
	 * @param config                 $config     Config object
	 * @param template               $template   Template object
	 * @param user                   $user       User object
	 * @param driver_interface       $db         The db connection
	 * @param service                $cache      Cache object
	 * @param auth                   $auth       Auth object
	 * @param language               $language   Language object
	 * @param array                  $tables     phpBB db tables
	 *
	 * @return \david63\statsonindex\controller\main_controller
	 * @access public
	 */
	public function __construct(config $config, template $template, user $user, driver_interface $db, service $cache, auth $auth, language $language, array $tables)
	{
		$this->config   = $config;
		$this->template = $template;
		$this->user     = $user;
		$this->db       = $db;
		$this->cache    = $cache;
		$this->auth     = $auth;
		$this->language = $language;
		$this->tables   = $tables;
	}

	/**
	 * Display the options a user can configure for this extension
	 *
	 * @return null
	 * @access public
	 */
	public function add_stats_settings()
	{
		$display_output = false;

		// No point in doing the processing if it is not being displayed
		if ($this->config['statsonindex_guests'] || ($this->config['statsonindex_admin'] && $this->auth->acl_get('a_')) || (!$this->config['statsonindex_admin'] && $this->user->data['is_registered']))
		{
			$display_output = true;
			$this->language->add_lang('stats_on_index', 'david63/statsonindex');

			// Activity stats
			// Obtain posts/topics/new users activity
			$activity  = $this->obtain_activity_data();
			$tf_posts  = number_format($activity['posts'], '0');
			$tf_topics = number_format($activity['topics'], '0');
			$tf_users  = number_format($activity['users'], '0');

			// Obtain user activity data
			$active_users      = $this->obtain_active_user_data();
			$active_user_count = number_format(count($active_users), '0');

			// 24 hour users online list, assign to the template block: lastvisit
			foreach ($active_users as $row)
			{
				// Check that the user is valid
				if ($row['user_id'])
				{
					if ($row['user_type'] != USER_IGNORE)
					{
						$this->template->assign_block_vars('lastvisit_user', [
							'USERNAME_FULL' => get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
						]);
					}
					else
					{
						$this->template->assign_block_vars('lastvisit_bot', [
							'USERNAME_FULL' => get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']),
						]);
					}
				}
			}

			// Extended stats
			$files_per_day  = number_format($this->config['num_files'] / ceil((time() - $this->config['board_startdate']) / 86400), '2');
			$files_per_user = number_format($this->config['num_files'] / $this->config['num_users'], '2');
			$files_per_year = number_format($files_per_day * 364.25, '0');

			$posts_per_day   = number_format($this->config['num_posts'] / ceil((time() - $this->config['board_startdate']) / 86400), '2');
			$posts_per_topic = number_format($this->config['num_posts'] / $this->config['num_topics'], '2');
			$posts_per_user  = number_format($this->config['num_posts'] / $this->config['num_users'], '2');
			$posts_per_year  = number_format($posts_per_day * 364.25, '0');

			$topics_per_day  = number_format($this->config['num_topics'] / ceil((time() - $this->config['board_startdate']) / 86400), '2');
			$topics_per_user = number_format($this->config['num_topics'] / $this->config['num_users'], '2');
			$topics_per_year = number_format($topics_per_day * 364.25, '0');
			$total_files     = number_format($this->config['num_files'], '0');

			$users_per_day  = number_format($this->config['num_users'] / ceil((time() - $this->config['board_startdate']) / 86400), '2');
			$users_per_year = number_format($users_per_day * 364.25, '0');

			$none = $this->language->lang('NONE');

			$this->template->assign_vars([
				'FILES_PER_DAY' 		=> $this->language->lang('FILE_PER_DAY', ($files_per_day == 0) ? $none : $files_per_day),
				'FILES_PER_USER' 		=> $this->language->lang('FILES_PER_USER', ($files_per_user == 0) ? $none : $files_per_user),
				'FILES_PER_YEAR' 		=> $this->language->lang('FILES_PER_YEAR', ($files_per_year == 0) ? $none : $files_per_year),

				'POSTS_PER_DAY' 		=> $this->language->lang('POST_PER_DAY', ($posts_per_day == 0) ? $none : $posts_per_day),
				'POSTS_PER_TOPIC' 		=> $this->language->lang('POSTS_PER_TOPIC', ($posts_per_topic == 0) ? $none : $posts_per_topic),
				'POSTS_PER_USER' 		=> $this->language->lang('POSTS_PER_USER', ($posts_per_user == 0) ? $none : $posts_per_user),
				'POSTS_PER_YEAR' 		=> $this->language->lang('POSTS_PER_YEAR', ($posts_per_year == 0) ? $none : $posts_per_year),

				'TFHOUR_POSTS' 			=> $this->language->lang('TFHOUR_POSTS', ($tf_posts == 0) ? $none : $tf_posts),
				'TFHOUR_TOPICS' 		=> $this->language->lang('TFHOUR_TOPICS', ($tf_topics == 0) ? $none : $tf_topics),
				'TFHOUR_USERS' 			=> $this->language->lang('TFHOUR_USERS', ($tf_users == 0) ? $none : $tf_users),
				'TOPICS_PER_DAY' 		=> $this->language->lang('TOPIC_PER_DAY', ($topics_per_day == 0) ? $none : $topics_per_day),
				'TOPICS_PER_USER' 		=> $this->language->lang('TOPICS_PER_USER', ($topics_per_user == 0) ? $none : $topics_per_user),
				'TOPICS_PER_YEAR' 		=> $this->language->lang('TOPICS_PER_YEAR', ($topics_per_year == 0) ? $none : $topics_per_year),
				'TOTAL_FILES' 			=> $this->language->lang('TOTAL_FILES', ($total_files == 0) ? $none : $total_files),

				'USERS_PER_DAY' 		=> $this->language->lang('USER_PER_DAY', ($users_per_day == 0) ? $none : $users_per_day),
				'USERS_PER_YEAR' 		=> $this->language->lang('USERS_PER_YEAR', ($users_per_year == 0) ? $none : $users_per_year),
				'USERS_TFHOUR_TOTAL'	=> $this->language->lang('USERS_TFHOUR_TOTAL', ($active_user_count == 0) ? $none : (int) $active_user_count),

				'START_DATE' 			=> $this->user->format_date($this->config['board_startdate']),
				'ONLINE_FOR_DAYS' 		=> number_format(floor((time() - $this->config['board_startdate']) / 86400), '0'),

				'S_SHOW_BOTS' 			=> $this->config['statsonindex_bots'],
				'S_SHOW_DAYS' 			=> $this->config['statsonindex_days'],
				'S_SHOW_STATS' 			=> $this->config['statsonindex_stats'],
				'S_SHOW_SUMMARY' 		=> $this->config['statsonindex_summary'],
				'S_SHOW_USERS' 			=> $this->config['statsonindex_users'],

				// Reformat these for output consisency
				'TOTAL_POSTS' 			=> $this->language->lang('TOTAL_POSTS_COUNT', number_format($this->config['num_posts'], '0')),
				'TOTAL_TOPICS' 			=> $this->language->lang('TOTAL_TOPICS', number_format($this->config['num_topics'], '0')),
				'TOTAL_USERS' 			=> $this->language->lang('TOTAL_USERS', number_format($this->config['num_users'], '0')),
			]);
		}

		$this->template->assign_var('S_DISPLAY_STATS_OUTPUT', $display_output);
	}

	/**
	 * Obtain an array of active users over the last 24 hours.
	 *
	 * @return array
	 */
	protected function obtain_active_user_data()
	{
		if (($active_users = $this->cache->get('_active_users')) === false)
		{
			$active_users = [];

			// Grab a list of users who are currently online and users who have visited in the last 24 hours
			$sql_ary = [
				'SELECT'	=> 'u.user_id, u.user_colour, u.username, u.user_type',
				'FROM' 		=> [$this->tables['users'] => 'u'],
				'LEFT_JOIN' => [
					[
						'FROM'	=> [$this->tables['sessions'] => 's'],
						'ON' 	=> 's.session_user_id = u.user_id',
					],
				],
				'WHERE' 	=> 'u.user_lastvisit > ' . (time() - 86400) . ' OR s.session_user_id <> ' . ANONYMOUS,
				'GROUP_BY'	=> 'u.user_id',
				'ORDER_BY' 	=> 'u.username_clean',
			];

			$result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_ary));

			while ($row = $this->db->sql_fetchrow($result))
			{
				$active_users[$row['user_id']] = $row;
			}
			$this->db->sql_freeresult($result);

			// Cache this data for the same as online timespan, this improves performance
			$this->cache->put('_active_users', $active_users, $this->config['load_online_time']);
		}

		return $active_users;
	}

	/**
	 * Obtained cached 24 hour activity data
	 *
	 * @return array
	 */
	protected function obtain_activity_data()
	{
		if (($activity = $this->cache->get('_activity_mod')) === false)
		{
			// Set interval to 24 hours ago
			$interval = time() - 86400;

			$activity = [];

			// Total new posts in the last 24 hours
			$sql = 'SELECT COUNT(post_id) AS new_posts
                FROM ' . $this->tables['posts'] . '
                WHERE post_time > ' . (int) $interval;

			$result            = $this->db->sql_query($sql);
			$activity['posts'] = $this->db->sql_fetchfield('new_posts');

			$this->db->sql_freeresult($result);

			// Total new topics in the last 24 hours
			$sql = 'SELECT COUNT(topic_id) AS new_topics
                FROM ' . $this->tables['topics'] . '
                WHERE topic_time > ' . (int) $interval;

			$result             = $this->db->sql_query($sql);
			$activity['topics'] = $this->db->sql_fetchfield('new_topics');

			$this->db->sql_freeresult($result);

			// Total new users in the last 24 hours, counts inactive users as well
			$sql = 'SELECT COUNT(user_id) AS new_users
                FROM ' . $this->tables['users'] . '
                WHERE user_regdate > ' . (int) $interval;

			$result            = $this->db->sql_query($sql);
			$activity['users'] = $this->db->sql_fetchfield('new_users');

			$this->db->sql_freeresult($result);

			// Cache this data for the same as online timespan, this improves performance
			$this->cache->put('_activity_mod', $activity, $this->config['load_online_time']);
		}

		return $activity;
	}
}
