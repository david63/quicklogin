<?php
/**
*
* @package Quick Login Extension
* @copyright (c) 2015 PayBas
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace paybas\quicklogin\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\auth\provider_collection;
use phpbb\config\config;
use phpbb\template\template;
use phpbb\user;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\auth\auth */
	protected $auth_provider_collection;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string PHP extension */
	protected $phpEx;

	/**
	* Constructor for listener
	*
	* @param \phpbb\auth\auth			$auth_provider_collection	auth object
	* @param \phpbb\config\config		$config						phpBB config
	* @param \phpbb\template\template	$template					phpBB template
	* @param \phpbb\user				$user						User object
	* @param string 					$root_path					phpBB root path
	* @param string 					$phpEx						phpBB extension
	*
	* @access public
	*/
	public function __construct(provider_collection $auth_provider_collection, config $config, template $template, user $user, $root_path, $phpEx)
	{
		$this->auth_provider_collection	= $auth_provider_collection;
		$this->config    				= $config;
		$this->template  				= $template;
		$this->user                     = $user;
		$this->root_path 				= $root_path;
		$this->phpEx     				= $phpEx;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header_after' => 'quick_login',
		);
	}

	/**
	* Quick Log In
	*
	* @access public
	*/
	public function quick_login()
	{
		if (!$this->user->data['is_registered'] && !$this->user->data['is_bot'])
		{
			add_form_key('login', '_LOGIN');

			$auth_provider 		= $this->auth_provider_collection->get_provider();
			$auth_provider_data	= $auth_provider->get_login_data();

			if ($auth_provider_data)
			{
				if (isset($auth_provider_data['BLOCK_VAR_NAME']) && ($auth_provider_data['BLOCK_VAR_NAME'] == 'oauth'))
				{
					foreach ($auth_provider_data['BLOCK_VARS'] as $oauth_provider => $block_vars)
					{
						$oauth_provider 			= str_replace('auth.provider.oauth.service.', '', $oauth_provider);
						$redirect_url 				= append_sid($this->root_path . './ucp.'.$this->phpEx.'?mode=login&amp;login=external&amp;oauth_service='.$oauth_provider);
						$block_vars['REDIRECT_URL']	= $redirect_url;

						$this->template->assign_block_vars('ql_' . $auth_provider_data['BLOCK_VAR_NAME'], $block_vars);
					}
				}
			}

			$tpl_vars = array(
				'S_QUICK_LOGIN'       => true,
				'U_SEND_PASSWORD_EXT' => ($this->config['email_enable']) ? append_sid("{$this->root_path}ucp.$this->phpEx", 'mode=sendpassword') : '',
			);

			$this->template->assign_vars($tpl_vars);
		}
	}
}
