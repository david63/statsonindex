<?php
/**
*
* @package Statistics on Index Extension
* @copyright (c) 2015
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\statsonindex\acp;

class statsonindex_info
{
	function module()
	{
		return array(
			'filename'	=> '\david63\statsonindex\acp\statsonindex_module',
			'title'		=> 'STATS_ON_INDEX',
			'modes'		=> array(
				'main'	=> array('title' => 'STATS_ON_INDEX_MANAGE', 'auth' => 'ext_david63/statsonindex && acl_a_forum', 'cat' => array('STATS_ON_INDEX')),
			),
		);
	}
}
