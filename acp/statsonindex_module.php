<?php
/**
*
* @package Statistics on Index Extension
* @copyright (c) 2015
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\statsonindex\acp;

class statsonindex_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $phpbb_container;

		$this->tpl_name		= 'stats_on_index';
		$this->page_title	= $phpbb_container->get('language')->lang('STATS_ON_INDEX');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('david63.statsonindex.admin.controller');

		$admin_controller->display_options();
	}
}
