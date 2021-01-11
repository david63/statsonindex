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
	public function module()
	{
		return [
			'filename'	=> '\david63\statsonindex\acp\statsonindex_module',
			'title' 	=> 'STATS_ON_INDEX',
			'modes' 	=> [
				'main'	=> ['title' => 'STATS_ON_INDEX_MANAGE', 'auth' => 'ext_david63/statsonindex && acl_a_forum', 'cat' => ['STATS_ON_INDEX']],
			],
		];
	}
}
