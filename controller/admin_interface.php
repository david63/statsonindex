<?php
/**
*
* @package Statistics on Index Extension
* @copyright (c) 2015
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\statsonindex\controller;

/**
* Interface for our admin controller
*
* This describes all of the methods we'll use for the admin front-end of this extension
*/
interface admin_interface
{
	/**
	* Display the options a user can configure for this extension
	*
	* @return null
	* @access public
	*/
	public function display_options();
}
