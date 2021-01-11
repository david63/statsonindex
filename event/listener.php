<?php
/**
 *
 * @package Statistics on Index Extension
 * @copyright (c) 2015
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace david63\statsonindex\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use david63\statsonindex\controller\main_controller;
use phpbb\template\template;
use david63\statsonindex\core\functions;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	/** @var template */
	protected $template;

	/** @var functions */
	protected $functions;

	/**
	 * Constructor for listener
	 *
	 * @param main_controller	$main_controller    Main controller
	 * @param template			$template			Template object
	 * @param functions			$functions          Functions for the extension
	 *
	 * @access public
	 */
	public function __construct(main_controller $main_controller, template $template, functions $functions)
	{
		$this->main_controller	= $main_controller;
		$this->template			= $template;
		$this->functions		= $functions;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.index_modify_page_title'	=> 'add_stats_settings',
			'core.page_header_after' 		=> 'page_header',
		];
	}

	/**
	 * Update the data
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function add_stats_settings($event)
	{
		$this->main_controller->add_stats_settings();
	}

	/**
	 * Update the template variables
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function page_header($event)
	{
		$this->template->assign_var('SI_NAMESPACE', $this->functions->get_ext_namespace('twig'));
	}
}
