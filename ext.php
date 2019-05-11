<?php
/**
*
* @package Quick Login Extension
* @copyright (c) 2015 PayBas
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace paybas\quicklogin;

use phpbb\extension\base;

class ext extends base
{
	/**
	* Enable extension if phpBB version requirement is met
	*
	* @var string Require 3.2.6 due to updated 3.2 syntax and login changes
	*
	* @return bool
	* @access public
	*/
	public function is_enableable()
 	{
		// Requires phpBB 3.2.6 or newer.
		$is_enableable = phpbb_version_compare(PHPBB_VERSION, '3.2.6', '>=');

		// Display a custom warning message if requirement fails.
		if (!$is_enableable)
		{
			// Need to cater for 3.1 and 3.2
			if (phpbb_version_compare(PHPBB_VERSION, '3.2.1-RC1', '>='))
			{
				$this->container->get('language')->add_lang('ext_enable_error', 'paybas/quicklogin');
			}
			else
			{
				$this->container->get('user')->add_lang_ext('paybas/quicklogin', 'ext_enable_error');
			}
		}

		return $is_enableable;
 	}
}
