<?php
/**
 * @package RSS Images
 * @author digger http://mysmf.net
 * @copyright 2016-2017
 * @license The MIT License (MIT) https://opensource.org/licenses/MIT
 * @version 1.0.3
 */

if (!defined('SMF')) {
    die('Hacking attempt...');
}

/**
 * Load all needed hooks
 */
function loadRssImagesHooks()
{
    add_integration_function('integrate_admin_areas', 'addRssImagesAdminArea', false);
    add_integration_function('integrate_modify_modifications', 'addRssImagesAdminAction', false);
    add_integration_function('integrate_menu_buttons', 'addRssImagesCopyright', false);
    add_integration_function('integrate_rss_description', 'addRssImagesToDescription', false);
}

/**
 * Add admin area
 * @param $admin_areas
 */
function addRssImagesAdminArea(&$admin_areas)
{
    global $txt;
    loadLanguage('RssImages/RssImages');

    $admin_areas['config']['areas']['modsettings']['subsections']['rss_images'] = array($txt['rss_images']);
}

/**
 * Add admin area action
 * @param $subActions
 */
function addRssImagesAdminAction(&$subActions)
{
    $subActions['rss_images'] = 'addRssImagesAdminSettings';
}

/**
 * Addmin area settings
 * @param bool $return_config
 * @return array config vars
 */
function addRssImagesAdminSettings($return_config = false)
{
    global $txt, $scripturl, $context;
    loadLanguage('RssImages/RssImages');

    $context['page_title'] = $txt['rss_images'];
    $context['post_url'] = $scripturl . '?action=admin;area=modsettings;save;sa=rss_images';

    $config_vars = array(
        array('title', 'rss_images'),
        array('check', 'rss_images_enabled'),
        array('check', 'rss_images_quote'),
    );

    if ($return_config) {
        return $config_vars;
    }

    if (isset($_GET['save'])) {
        checkSession();
        saveDBSettings($config_vars);
        redirectexit('action=admin;area=modsettings;sa=rss_images');
    }

    prepareDBSettingContext($config_vars);
}

/**
 * Add image to rss item desctiption
 * @param $id_msg int
 * @param $description string
 * @return bool
 */
function addRssImagesToDescription($id_msg = 0, &$description = '')
{
    global $smcFunc, $modSettings;

    if (empty($modSettings['rss_images_enabled']) || empty($id_msg) || empty($description)
    ) {
        return;
    }

    // Remove images from quotes
    if (empty($modSettings['rss_images_quote'])) {
        $description = preg_replace('/\<blockquote.*\>.*(\<img.*\>\<\/img\>).*\<\/blockquote\>/i', '', $description);
    }

    if (strpos($description, '<img') !== false) {
        return;
    }

    $request = $smcFunc['db_query']('', '
                SELECT body
                FROM {db_prefix}messages
                WHERE id_msg = {int:id_msg}
                LIMIT 1',
        array(
            'id_msg' => (int)$id_msg
        )
    );

    list ($body) = $smcFunc['db_fetch_row']($request);
    $smcFunc['db_free_result']($request);

    preg_match('/\[img.*](.+)\[\/img]/i', $body, $image);
    if (!empty($image[1])) {
        $image = '<img alt="" src="' . trim($image[1]) . '" /><br />';
    }

    if (!empty($image)) {
        $description = $image . $description;
    }

}

/**
 * Add mod copyright to the forum credit's page
 */
function addRssImagesCopyright()
{
    global $context;

    if ($context['current_action'] == 'credits') {
        $context['copyrights']['mods'][] = '<a href="http://mysmf.net/mods/rss-images" title="SMF RSS Images Mod" target="_blank">RSS Images</a> &copy; 2016-2017, digger';
    }
}
