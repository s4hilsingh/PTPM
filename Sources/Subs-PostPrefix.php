<?php

/**
 * @package SMF Post Prefix
 * @version 1.0
 * @author Diego Andrés <diegoandres_cortes@outlook.com>
 * @copyright Copyright (c) 2015, Diego Andrés
 * @license http://www.mozilla.org/MPL/MPL-1.1.html
 */

if (!defined('SMF'))
	die('No direct access...');

class PostPrefix
{
	public static $name = 'PostPrefix';
	public static $version = '2.0.2';

	/**
	 * PostPrefix::load_theme()
	 *
	 * We need to load the css and jquery for get the colorpicker
	 * @global $context, $settings
	 * @return
	 */
	public static function load_theme()
	{
		global $context, $settings;

		// Color picker
		if ((isset($_REQUEST['action']) && ($_REQUEST['action'] == 'admin')) && (isset($_REQUEST['area']) && ($_REQUEST['area'] == 'postprefix')) && (isset($_REQUEST['sa']) && (($_REQUEST['sa'] == 'add') || ($_REQUEST['sa'] == 'edit'))))
		{
			$context['html_headers'] .= '
				<script type="text/javascript">!window.jQuery && document.write(unescape(\'%3Cscript src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"%3E%3C/script%3E\'))</script>
				<link rel="stylesheet" type="text/css" href="'. $settings['default_theme_url']. '/css/colpick.css" />
				<script type="text/javascript" src="'. $settings['default_theme_url']. '/scripts/colpick.js"></script>';
		}
	}

	/**
	 * PostPrefix::permissions()
	 *
	 * Permissions for manage prefixes and a global permission for use the prefixes
	 * @param array $permissionGroups An array containing all possible permissions groups.
	 * @param array $permissionList An associative array with all the possible permissions.
	 * @return
	 */
	public static function permissions(&$permissionGroups, &$permissionList)
	{
		// We gotta load our language file.
		loadLanguage(self::$name);

		// Manage prefix
		$permission = array('manage_prefixes');
		foreach ($permission as $p)
			$permissionList['membergroup'][$p] = array(false,'maintenance','administrate');

		// Topic?
		$permission2 = array('set_prefix');
		foreach ($permission2 as $p)
			$permissionList['board'][$p] = array(false,'topic','make_posts');
	}

	/**
	 * PostPrefix::admin_areas()
	 *
	 * Add our new section and load the language and template
	 * @param array $admin_menu An array with all the admin settings buttons
	 * @global $scripturl, $context
	 * @return
	 */
	public static function admin_areas(&$admin_areas)
	{
		global $scripturl, $context;

		loadtemplate(self::$name);
		loadLanguage(self::$name);

		$insert = 'postsettings';
		$counter = 0;

		foreach ($admin_areas['layout']['areas'] as $area => $dummy)
			if (++$counter && $area == $insert )
				break;

		$admin_areas['layout']['areas'] = array_merge(
			array_slice($admin_areas['layout']['areas'], 0, $counter),
			array(
				'postprefix' => array(
					'label' => self::text('main'),
					'icon' => 'news.gif',
					'file' => 'PostPrefixAdmin.php',
					'function' => 'PostPrefixAdmin',
					'permission' => array('manage_prefixes'),
					'subsections' => array(
						'general' => array(self::text('tab_general')),
						'prefixes' => array(self::text('tab_prefixes')),
						'add' => array(self::text('tab_prefixes_add')),
						'require' => array(self::text('tab_require')),
						'permissions' => array(self::text('tab_permissions')),
						'settings' => array(self::text('tab_settings')),
					),
				),
			),
			array_slice($admin_areas['layout']['areas'], $counter)
		);

		// Post Prefix copyright :)
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'admin' && isset($_REQUEST['area']) && $_REQUEST['area'] == 'postprefix')
		{
			$context['template_layers'][] = 'postprefix';
			$context['copyright'] = self::copyright();
		}
	}

	/**
	 * PostPrefix::formatPrefix()
	 *
	 * Styling the prefix.
	 * @param int $prefix the prefix id.
	 * @global $smcFunc, $topic
	 * @return
	 * @author Diego Andrés <diegoandres_cortes@outlook.com>
	 */
	public static function formatPrefix($prefix)
	{
		global $smcFunc, $topic;

		$prefix = (int) $prefix;

		$request = $smcFunc['db_query']('', '
			SELECT p.id, p.name, p.color, p.bgcolor, p.icon, p.icon_url
			FROM {db_prefix}postprefixes AS p
			WHERE p.id = {int:id}
			LIMIT 1',
			array(
				'id' => $prefix,
			)
		);

		$row = $smcFunc['db_fetch_assoc']($request);

		$format = '';

		if (!empty($row))
		{
			if (empty($row['icon']))
			{
				$format .= '<span class="postprefix-all" id="postprefix-'. $row['id']. '" ';

				if (!empty($topic) || $row['bgcolor'] == 1 || !empty($row['color']))
				{
					$format .= 'style="';
					
					if ($row['bgcolor'] == 1 && !empty($row['color']))
						$format .= 'padding: 4px; border-radius: 2px; color: #f5f5f5; background-color: '. $row['color'];
					elseif (!empty($row['color']) && empty($row['bgcolor']))
						$format .= 'color: '. $row['color'];

					$format .= '"';
				}

				$format .= '>';
				$format .= $row['name'];
				$format .= '</span>';
			}
			else
			{
				$format = '<img class="postprefix-all" id="postprefix-'. $row['id']. '" style="vertical-align: middle;" src="'. $row['icon_url']. '" alt="'. $row['name']. '" title="'. $row['name']. '" />';
			}

		}

		return $format;
	}

	/**
	 * PostPrefix::getPrefix()
	 *
	 * It will return the list of prefixes.
	 * @param int $board The board id.
	 * @global $smcFunc, $context, $user_info, $memberContext, $user_settings, $modSettings
	 * @return
	 * @author Diego Andrés <diegoandres_cortes@outlook.com>
	 */
	public static function getPrefix($board, $all = false)
	{
		global $smcFunc, $context, $user_info, $memberContext, $user_settings, $modSettings;

		loadLanguage(PostPrefix::$name);

		$board = (int) $board;

		$temp = loadMemberData($user_info['id'], false, 'profile');
		if (empty($temp))
		{
			$group = '';
			$postg = '';
		}
		else
		{
			loadMemberContext($user_info['id']);
			$group = (int) $memberContext[$user_info['id']]['group_id'];
			$postg = (int) $user_settings['id_post_group'];
		}

		// Order by thing
		$orderby = $modSettings['PostPrefix_select_order'];
		if ($orderby == 0)
			$order = 'name';
		elseif ($orderby == 1)
			$order = 'id';
		elseif ($orderby == 2)
			$order = 'added';
		// Direction
		$direction = $modSettings['PostPrefix_select_order_dir'];
		if ($direction == 0)
			$dir = 'DESC';
		else
			$dir = 'ASC';

		$context['prefix']['post'] = array();
		if (allowedTo('set_prefix') || allowedTo('manage_prefixes'))
		{
			$request = $smcFunc['db_query']('', '
				SELECT p.id, p.status, p.name, p.added, p.boards, p.member_groups, p.deny_member_groups
				FROM {db_prefix}postprefixes AS p
				WHERE p.status = 1'. ($user_info['is_admin'] || allowedTo('manage_prefixes') ? '' : ('
					AND (FIND_IN_SET({int:id_group}, p.member_groups) OR FIND_IN_SET({int:post_group}, p.member_groups))' . (!empty($modSettings['permission_enable_deny']) ? ('
					AND (NOT FIND_IN_SET({int:id_group}, p.deny_member_groups) AND NOT FIND_IN_SET({int:post_group}, p.deny_member_groups))') : '') . '')) . '
					'. ($all == true ? '' : '
					AND FIND_IN_SET({int:board}, p.boards)
				ORDER by p.{raw:order} {raw:dir}'),
				array(
					'id_group' => $group,
					'post_group' => $postg,
					'board' => $board,
					'order' => $order,
					'dir' => $dir,
				)
			);
			while ($row = $smcFunc['db_fetch_assoc']($request))
				$context['prefix']['post'][] = array(
					'id' => $row['id'],
					'name' => $row['name'],
					'boards' => explode(',', $row['boards']),
					'groups' => explode(',', $row['member_groups']),
					'deny_groups' => explode(',', $row['deny_member_groups']),
				);
			$smcFunc['db_free_result']($request);
		}
	}

	/**
	 * PostPrefix::countTopics()
	 *
	 * It will return the number of topics in X board
	 * @param $board, $prefix
	 * @global $smcFunc, $context, $user_info, $memberContext, $user_settings, $modSettings
	 * @return
	 * @author Diego Andrés <diegoandres_cortes@outlook.com>
	 */
	public static function countTopics($board, $prefix)
	{
		global $smcFunc;

		if (isset($_REQUEST['prefix']))
		{
			$request = $smcFunc['db_query']('', '
				SELECT id_board, id_prefix
				FROM {db_prefix}topics
				WHERE id_prefix = {int:topic_prefix}
					AND id_board = {int:board}',
				array(
					'topic_prefix' => $prefix,
					'board' => $board,
				)
			);
			return $smcFunc['db_num_rows']($request);
		}
	}

	public static function credits(&$crappy)
	{
		global $context;

		if (!empty($context['current_action']) && $context['current_action'] == 'credits')
			$context['copyrights']['mods'][] = '<a href="http://smftricks.com" title="SMF Themes & Mods">SMF Post Prefix &copy Diego Andr&eacute;s & SMF Tricks</a>';
	}

	public static function copyright()
	{
		$copy = '<div class="centertext"><a href="http://smftricks.com" target="_blank">Powered by SMF Post Prefix &copy; SMF Tricks '. date('Y') . '</a></div>';
		return $copy;
	}

	/**
	 * PostPrefix::filter()
	 *
	 * Add the filter topics by prefix box on messageindex
	 * @global $topic, $board, $modSettings, $context
	 * @return
	 */
	public static function filter()
	{
		global $topic, $board, $modSettings, $context;

		if (empty($_REQUEST['action']) && !empty($modSettings['PostPrefix_enable_filter']))
		{
			// Topic is empty, and action is empty.... MessageIndex!
			if (!empty($board) && empty($topic))
			{
				// Get a list of prefixes
				self::getPrefix($context['current_board']);
				// Load the sub-template
				template_filterPrefix();
			}
		}
	}

	/**
	 * PostPrefix::text()
	 *
	 * Gets a string key, and returns the associated text string.
	 * @param string $var The text string key.
	 * @global $txt
	 * @return string|boolean
	 * @author Jessica González <suki@missallsunday.com>
	 */
	public static function text($var)
	{
		global $txt;

		if (empty($var))
			return false;

		// Load the mod's language file.
		loadLanguage(self::$name);

		if (!empty($txt[self::$name. '_' .$var]))
			return $txt[self::$name. '_' .$var];

		else
			return false;
	}

	/**
	 * @return array
	 */
	public function dev_credits()
	{
		// Dear contributor, please feel free to add yourself here.
		$credits = array(
			'dev' => array(
				'name' => 'Developer(s)',
				'users' => array(
					'diego' => array(
						'name' => 'Diego Andr&eacute;s',
						'site' => 'http://smftricks.com',
					),
				),
			),
			'scripts' => array(
				'name' => 'Third Party Scripts',
				'users' => array(
					'jquery' => array(
						'name' => 'jQuery',
						'site' => 'http://jquery.com',
					),
					'colpick' => array(
						'name' => 'ColPick',
						'site' => 'http://colpick.com/plugin',
					),
				),
			),
		);

		// Oh well, one can dream...
		call_integration_hook('integrate_postprefix_credits', array(&$credits));

		return $credits;
	}
}