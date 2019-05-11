<?php
/**
*
* @package Statistics on Index Extension
* @copyright (c) 2015 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\statsonindex\migrations;

class version_1_0_0 extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(
			array('config.add', array('statsonindex_admin', 0)),
			array('config.add', array('statsonindex_bots', 1)),
			array('config.add', array('statsonindex_days', 0)),
			array('config.add', array('statsonindex_guests', 1)),
			array('config.add', array('statsonindex_summary', 1)),
			array('config.add', array('statsonindex_stats', 1)),
			array('config.add', array('statsonindex_users', 1)),

			// Add the ACP module
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'STATS_ON_INDEX')),

			array('module.add', array(
				'acp', 'STATS_ON_INDEX', array(
					'module_basename'	=> '\david63\statsonindex\acp\statsonindex_module',
					'modes'				=> array('main'),
				),
			)),
		);
	}
}
