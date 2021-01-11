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
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use phpbb\language\language;
use phpbb\log\log;
use david63\statsonindex\core\functions;

/**
 * Admin controller
 */
class admin_controller
{
	/** @var config */
	protected $config;

	/** @var request */
	protected $request;

	/** @var template */
	protected $template;

	/** @var user */
	protected $user;

	/** @var language */
	protected $language;

	/** @var log */
	protected $log;

	/** @var functions */
	protected $functions;

	/** @var string */
	protected $ext_images_path;

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor for admin controller
	 *
	 * @param config         $config             Config object
	 * @param request        $request            Request object
	 * @param template       $template           Template object
	 * @param user           $user               User object
	 * @param language       $language           Language object
	 * @param log            $log                Log object
	 * @param functions      $functions          Functions for the extension
	 * @param string         $ext_images_path    Path to this extension's images
	 *
	 * @return \david63\statsonindex\controller\admin_controller
	 * @access public
	 */
	public function __construct(config $config, request $request, template $template, user $user, language $language, log $log, functions $functions, string $ext_images_path)
	{
		$this->config          = $config;
		$this->request         = $request;
		$this->template        = $template;
		$this->user            = $user;
		$this->language        = $language;
		$this->log             = $log;
		$this->functions       = $functions;
		$this->ext_images_path = $ext_images_path;
	}

	/**
	 * Display the options a user can configure for this extension
	 *
	 * @return null
	 * @access public
	 */
	public function display_options()
	{
		// Add the language files
		$this->language->add_lang(['acp_statsonindex', 'acp_common'], $this->functions->get_ext_namespace());

		// Create a form key for preventing CSRF attacks
		$form_key = 'stats_on_index';
		add_form_key($form_key);

		$back = false;

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
		$version_data = $this->functions->version_check();

		// Are the PHP and phpBB versions valid for this extension?
		$valid = $this->functions->ext_requirements();

		$this->template->assign_vars([
			'DOWNLOAD' 			=> (array_key_exists('download', $version_data)) ? '<a class="download" href =' . $version_data['download'] . '>' . $this->language->lang('NEW_VERSION_LINK') . '</a>' : '',

			'EXT_IMAGE_PATH' 	=> $this->ext_images_path,

			'HEAD_TITLE' 		=> $this->language->lang('STATS_ON_INDEX'),
			'HEAD_DESCRIPTION'	=> $this->language->lang('STATS_ON_INDEX_EXPLAIN'),

			'NAMESPACE' 		=> $this->functions->get_ext_namespace('twig'),

			'PHP_VALID' 		=> $valid[0],
			'PHPBB_VALID' 		=> $valid[1],

			'S_BACK' 			=> $back,
			'S_VERSION_CHECK' 	=> (array_key_exists('current', $version_data)) ? $version_data['current'] : false,

			'VERSION_NUMBER' 	=> $this->functions->get_meta('version'),
		]);

		// Set output vars for display in the template
		$this->template->assign_vars([
			'ADMIN_STATS' 		=> isset($this->config['statsonindex_admin']) ? $this->config['statsonindex_admin'] : '',
			'GUEST_STATS' 		=> isset($this->config['statsonindex_guests']) ? $this->config['statsonindex_guests'] : '',
			'INCLUDE_BOTS' 		=> isset($this->config['statsonindex_bots']) ? $this->config['statsonindex_bots'] : '',
			'INCLUDE_DAYS' 		=> isset($this->config['statsonindex_days']) ? $this->config['statsonindex_days'] : '',
			'INCLUDE_SUMMARY'	=> isset($this->config['statsonindex_summary']) ? $this->config['statsonindex_summary'] : '',
			'SHOW_STATS' 		=> isset($this->config['statsonindex_stats']) ? $this->config['statsonindex_stats'] : '',
			'SHOW_USERS' 		=> isset($this->config['statsonindex_users']) ? $this->config['statsonindex_users'] : '',
			'U_ACTION' 			=> $this->u_action,
		]);
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
