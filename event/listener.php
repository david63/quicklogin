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
use phpbb\event\dispatcher_interface;

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

	/** @var dispatcher_interface */
	protected $dispatcher;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string PHP extension */
	protected $php_ext;

	/**
	 * Constructor for listener
	 *
	 * @param auth           		$auth_provider_collection   auth object
	 * @param config       			$config                     phpBB config
	 * @param template   			$template                   phpBB template
	 * @param user                	$user                       User object
	 * @param dispatcher_interface	$dispatcher                 phpBB dispatcher
	 * @param string				$root_path                  phpBB root path
	 * @param string				$php_ext                    phpBB extension
	 *
	 * @access public
	 */
	public function __construct(provider_collection $auth_provider_collection, config $config, template $template, user $user, dispatcher_interface $dispatcher, string $root_path, string $php_ext)
	{
		$this->auth_provider_collection = $auth_provider_collection;
		$this->config                   = $config;
		$this->template                 = $template;
		$this->user                     = $user;
		$this->dispatcher               = $dispatcher;
		$this->root_path                = $root_path;
		$this->php_ext                  = $php_ext;
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
			'core.page_header_after' => 'quick_login',
		];
	}

	/**
	 * Quick Log In
	 *
	 * @access public
	 */
	public function quick_login($event)
	{
		// Check that QL is on index page
		$ql_flag = $event['display_online_list'];

		if (!$this->user->data['is_registered'] && !$this->user->data['is_bot'])
		{
			add_form_key('login', '_LOGIN');

			$auth_provider      = $this->auth_provider_collection->get_provider();
			$auth_provider_data = $auth_provider->get_login_data();

			if ($auth_provider_data)
			{
				if (isset($auth_provider_data['BLOCK_VAR_NAME']) && ($auth_provider_data['BLOCK_VAR_NAME'] == 'oauth'))
				{
					foreach ($auth_provider_data['BLOCK_VARS'] as $oauth_provider => $block_vars)
					{
						$oauth_provider             = str_replace('auth.provider.oauth.service.', '', $oauth_provider);
						$redirect_url               = append_sid($this->root_path . './ucp.' . $this->php_ext . '?mode=login&amp;login=external&amp;oauth_service=' . $oauth_provider);
						$block_vars['REDIRECT_URL'] = $redirect_url;

						$this->template->assign_block_vars('ql_' . $auth_provider_data['BLOCK_VAR_NAME'], $block_vars);
					}
				}
			}

			$tpl_vars = [
				'S_QUICK_LOGIN' 		=> true,
				'U_SEND_PASSWORD_EXT'	=> ($this->config['email_enable']) ? append_sid("{$this->root_path}ucp.$this->php_ext", 'mode=sendpassword') : '',
			];

			/**
			 * Event to allow setting template variables
			 *
			 * @event paybas.quicklogin.login_forum_box
			 *
			 * @var  array  tpl_vars    The template variables
			 * @var  bool	ql_flag		Flag to indicate on Index page		 
			 *
			 * @since 2.0.2
			 */
			$vars = [
				'tpl_vars',
				'ql_flag',
			];
			extract($this->dispatcher->trigger_event('paybas.quicklogin.login_forum_box', compact($vars)));

			$this->template->assign_vars($tpl_vars);
		}
	}
}
