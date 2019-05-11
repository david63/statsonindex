<?php
/**
*
* @package Statistics on Index Extension
* @copyright (c) 2015
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\statsonindex\controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use david63\statsonindex\ext;

/**
* Admin controller
*/
class admin_controller implements admin_interface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var string Custom form action */
	protected $u_action;

	/**
	* Constructor for admin controller
	*
	* @param \phpbb\config\config		$config		Config object
	* @param \phpbb\request\request		$request	Request object
	* @param \phpbb\template\template	$template	Template object
	* @param \phpbb\user				$user		User object
	* @param phpbb\language\language	$language
	* @param \phpbb\log\log				$log
	*
	* @return \david63\statsonindex\controller\admin_controller
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, \phpbb\language\language $language, \phpbb\log\log $log)
	{
		$this->config		= $config;
		$this->request		= $request;
		$this->template		= $template;
		$this->user			= $user;
		$this->language		= $language;
		$this->log			= $log;
	}

	/**
	* Display the options a user can configure for this extension
	*
	* @return null
	* @access public
	*/
	public function display_options()
	{
		// Add the language file
		$this->language->add_lang('acp_statsonindex', 'david63/statsonindex');

		// Create a form key for preventing CSRF attacks
		$form_key = 'stats_on_index';
		add_form_key($form_key);

		// Is the form being submitted
		if ($this->request->is_set_post('submit'))
		{
			// Is the submitted form is valid
			if (!check_form_key($form_key))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// If no errors, process the form data
			// Set the options the user configured
			$this->set_options();

			// Add option settings change action to the admin log
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'STATS_ON_INDEX_LOG');

			// Option settings have been updated and logged
			// Confirm this to the user and provide link back to previous page
			trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		// Template vars for header panel
		$this->template->assign_vars(array(
			'HEAD_TITLE'		=> $this->language->lang('STATS_ON_INDEX'),
			'HEAD_DESCRIPTION'	=> $this->language->lang('STATS_ON_INDEX_EXPLAIN'),

			'VERSION_NUMBER'	=> ext::STATS_ON_INDEX_VERSION,
		));

		// Set output vars for display in the template
		$this->template->assign_vars(array(
			'ADMIN_STATS'				=> isset($this->config['statsonindex_admin']) ? $this->config['statsonindex_admin'] : '',
			'GUEST_STATS'				=> isset($this->config['statsonindex_guests']) ? $this->config['statsonindex_guests'] : '',
			'INCLUDE_BOTS'				=> isset($this->config['statsonindex_bots']) ? $this->config['statsonindex_bots'] : '',
			'INCLUDE_DAYS'				=> isset($this->config['statsonindex_days']) ? $this->config['statsonindex_days'] : '',
			'INCLUDE_SUMMARY'			=> isset($this->config['statsonindex_summary']) ? $this->config['statsonindex_summary'] : '',
			'SHOW_STATS'				=> isset($this->config['statsonindex_stats']) ? $this->config['statsonindex_stats'] : '',
			'SHOW_USERS'				=> isset($this->config['statsonindex_users']) ? $this->config['statsonindex_users'] : '',
			'STATS_ON_INDEX_VERSION'	=> ext::STATS_ON_INDEX_VERSION,
			'U_ACTION'					=> $this->u_action,
		));
	}

	/**
	* Set the options a user can configure
	*
	* @return null
	* @access protected
	*/
	protected function set_options()
	{
		$this->config->set('statsonindex_admin', $this->request->variable('statsonindex_admin', 0));
		$this->config->set('statsonindex_bots', $this->request->variable('statsonindex_bots', 0));
		$this->config->set('statsonindex_days', $this->request->variable('statsonindex_days', 0));
		$this->config->set('statsonindex_guests', $this->request->variable('statsonindex_guests', 0));
		$this->config->set('statsonindex_summary', $this->request->variable('statsonindex_summary', 0));
		$this->config->set('statsonindex_stats', $this->request->variable('statsonindex_stats', 0));
		$this->config->set('statsonindex_users', $this->request->variable('statsonindex_users', 0));
	}
}
