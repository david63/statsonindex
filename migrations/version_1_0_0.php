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
		return [
			['config.add', ['statsonindex_admin', 0]],
			['config.add', ['statsonindex_bots', 1]],
			['config.add', ['statsonindex_days', 0]],
			['config.add', ['statsonindex_guests', 1]],
			['config.add', ['statsonindex_summary', 1]],
			['config.add', ['statsonindex_stats', 1]],
			['config.add', ['statsonindex_users', 1]],

			// Add the ACP module
			['module.add', ['acp', 'ACP_CAT_DOT_MODS', 'STATS_ON_INDEX']],

			['module.add', [
				'acp', 'STATS_ON_INDEX', [
					'module_basename' => '\david63\statsonindex\acp\statsonindex_module',
					'modes' => ['main'],
				],
			]],
		];
	}
}
