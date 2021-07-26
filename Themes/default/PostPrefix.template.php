<?php

/**
 * @package SMF Post Prefix
 * @version 2.0
 * @author Diego Andrés <diegoandres_cortes@outlook.com>
 * @copyright Copyright (c) 2015, Diego Andrés
 * @license http://www.mozilla.org/MPL/MPL-1.1.html
 */

function template_postprefix_general()
{
	global $context, $txt;

	// Welcome message for the admin.
	echo '
	<div id="admincenter">
		<div id="admin_main_section">
			<div id="live_news" class="floatleft">
				<div class="cat_bar">
					<h3 class="catbg">
						<span class="ie6_header floatleft">', $txt['PostPrefix_main_credits'], '</span>
					</h3>
				</div>
				<div class="windowbg nopadding">
				<span class="topslice"><span></span></span>
			<div class="padding">';

	// Print the credits array
	if (!empty($context['PostPrefix']['credits']))
		foreach ($context['PostPrefix']['credits'] as $c)
		{
			echo '
				<dl>
					<dt>
						<strong>', $c['name'], '</strong>
					</dt>';

			foreach ($c['users'] as $u)
				echo '
						<dd>
							<a href="', $u['site'] ,'">', $u['name'] ,'</a>', (isset($u['desc']) ? ' - <span class="smalltext">'. $u['desc']. '</span>' : ''), '
						</dd>';

			echo '
					</dl>';
		}

	echo '
				</div>
				<span class="botslice"><span></span></span>
				</div>
			</div>';

	// Show the mod version.
	echo '
			<div id="supportVersionsTable" class="floatright">
				<div class="cat_bar">
					<h3 class="catbg">
						', $txt['support_title'], '
					</h3>
				</div>
				<div class="windowbg nopadding">
					<span class="topslice"><span></span></span>
					<div class="content padding">
						<div id="version_details">
							<strong>', $txt['support_versions'], ':</strong><br />
							', $txt['PostPrefix_version'] , ':
							<em id="yourVersion" style="white-space: nowrap;">', $context['PostPrefix']['version'] , '</em><br />
						</div>
					</div>
					<span class="botslice"><span></span></span>
				</div>
			</div>
			<br class="clear" />
			
		</div>
	</div>
	<br />';

}

function template_postprefix_add()
{
	global $context, $txt, $scripturl, $modSettings, $boardurl;

	echo '
	<div class="windowbg">
		<span class="topslice"><span></span></span>
		<form name="PostPrefixAdd" class="content" id="PostPrefixAdd" method="post" action="', $scripturl, '?action=admin;area=postprefix;sa=add2">

			<dl class="settings">
				<dt>
					<a id="setting_name"></a>
					<span><label for="name">', $txt['PostPrefix_prefix_name'], ':</label></span>
				</dt>
				<dd>
					<input class="input_text" name="name" id="name" type="text" style="width: 200px">
				</dd>

				<dt>
					<a id="setting_status"></a>
					<span><label for="status">', $txt['PostPrefix_prefix_enable'], ':</label></span>
				</dt>
				<dd>
					<input class="input_check" type="checkbox" name="status" id="status" value="1">
				</dd>
			</dl>

			<dl class="settings">
				<dt>
					<a id="setting_color"></a>
					<span><label for="color">', $txt['PostPrefix_prefix_color'], ':</label></span>
				</dt>
				<dd>
					<input class="input_check" type="checkbox" name="usecolor" value="1" onclick="document.getElementById(\'color\').style.display = this.checked ? \'block\' : \'none\'; document.getElementById(\'bgcolor1\').style.display = this.checked ? \'block\' : \'none\'; document.getElementById(\'bgcolor2\').style.display = this.checked ? \'block\' : \'none\';">
					<input class="input_text" name="color" id="color" type="text" style="display: none; border-width: 1px 1px 1px 25px;">
				</dd>
				<dt id="bgcolor1" style="display: none;">
					<a id="setting_bgcolor"></a>
					<span><label for="bgcolor">', $txt['PostPrefix_use_bgcolor'], ':</label></span>
				</dt>
				<dd id="bgcolor2" style="display: none;">
					<input class="input_check" name="bgcolor" id="bgcolor" type="checkbox" value="1">
				</dd>
			</dl>

			<dl class="settings">
				<dt>
					<a id="setting_icon"></a>
					<span><label for="icon">', $txt['PostPrefix_prefix_icon_use'], ':</label></span>
				</dt>
				<dd>
					<input class="input_check" type="checkbox" name="icon" value="1" onclick="document.getElementById(\'icon_url1\').style.display = this.checked ? \'block\' : \'none\'; document.getElementById(\'icon_url2\').style.display = this.checked ? \'block\' : \'none\';">
				</dd>
				<dt id="icon_url1" style="display: none;">
					<a id="setting_icon_url"></a>
					<span><label for="icon_url">', $txt['PostPrefix_prefix_icon_url'], ':</label></span>
				</dt>
				<dd id="icon_url2" style="display: none;">
					<input class="input_text" name="icon_url" id="icon_url" type="text" style="width: 200px">
				</dd>
			</dl>

			<dl class="settings">
				<dt>
					<a id="setting_groups"></a>
					<span><label for="groups">', $txt['PostPrefix_prefix_groups'], ':</label></span>
				</dt>
				<dd>
					', template_postprefix_groups_list(), '
				</dd>
				<dt>
					<a id="setting_boards"></a>
					<span><label for="boards">', $txt['PostPrefix_prefix_boards'], ':</label></span>
				</dt>
				<dd>
					', template_postprefix_boards_list(), '
				</dd>
			</dl>

			<input class="button_submit floatleft" type="submit" value="', $txt['PostPrefix_add_prefix'], '">
			<br class="clear" />

		</form>
		<span class="botslice"><span></span></span>
	</div><br />';
}

function template_postprefix_edit()
{
	global $context, $txt, $scripturl, $modSettings, $boardurl;

	echo '
	<div class="windowbg">
		<span class="topslice"><span></span></span>
		<form name="PostPrefixAdd" class="content" id="PostPrefixAdd" method="post" action="', $scripturl, '?action=admin;area=postprefix;sa=edit2;id=', $_REQUEST['id'], '">

			<dl class="settings">
				<dt>
					<a id="setting_name"></a>
					<span><label for="name">', $txt['PostPrefix_prefix_name'], ':</label></span>
				</dt>
				<dd>
					<input class="input_text" name="name" id="name" type="text" value="', $context['prefix']['name'], '" style="width: 200px">
				</dd>

				<dt>
					<a id="setting_status"></a>
					<span><label for="status">', $txt['PostPrefix_prefix_enable'], ':</label></span>
				</dt>
				<dd>
					<input class="input_check" type="checkbox" name="status" id="status"', ($context['prefix']['status'] == 1 ? ' checked' : ''), ' value="1">
				</dd>
			</dl>

			<dl class="settings">
				<dt>
					<a id="setting_color"></a>
					<span><label for="color">', $txt['PostPrefix_prefix_color'], ':</label></span>
				</dt>
				<dd>
					<input class="input_check" type="checkbox" name="usecolor" value="1"', !empty($context['prefix']['color']) ? ' checked' : '', ' onclick="document.getElementById(\'color\').style.display = this.checked ? \'block\' : \'none\'; document.getElementById(\'bgcolor1\').style.display = this.checked ? \'block\' : \'none\'; document.getElementById(\'bgcolor2\').style.display = this.checked ? \'block\' : \'none\';">
					<input class="input_text" name="color" id="color" type="text" style="', !empty($context['prefix']['color']) ? 'display: block; ' : 'display: none; ', 'border-width: 1px 1px 1px 25px;" value="', $context['prefix']['color'], '">
				</dd>
				<dt id="bgcolor1" style="', !empty($context['prefix']['color']) ? 'display: block;' : 'display: none;', '">
					<a id="setting_bgcolor"></a>
					<span><label for="bgcolor">', $txt['PostPrefix_use_bgcolor'], ':</label></span>
				</dt>
				<dd id="bgcolor2" style="', !empty($context['prefix']['color']) ? 'display: block;' : 'display: none;', '">
					<input class="input_check" name="bgcolor" id="bgcolor" type="checkbox"', ($context['prefix']['bgcolor'] == 1 ? ' checked' : ''), ' value="1">
				</dd>
			</dl>

			<dl class="settings">
				<dt>
					<a id="setting_icon"></a>
					<span><label for="icon">', $txt['PostPrefix_prefix_icon_use'], ':</label></span>
				</dt>
				<dd>
					<input class="input_check" type="checkbox" name="icon" value="1"', !empty($context['prefix']['icon']) ? ' checked' : '', ' onclick="document.getElementById(\'icon_url1\').style.display = this.checked ? \'block\' : \'none\'; document.getElementById(\'icon_url2\').style.display = this.checked ? \'block\' : \'none\';">
				</dd>
				<dt id="icon_url1" style="', !empty($context['prefix']['icon']) ? 'display: block;' : 'display: none;', '">
					<a id="setting_icon_url"></a>
					<span><label for="icon_url">', $txt['PostPrefix_prefix_icon_url'], ':</label></span>
				</dt>
				<dd id="icon_url2" style="', !empty($context['prefix']['icon']) ? 'display: block;' : 'display: none;', '">
					<input class="input_text" name="icon_url" id="icon_url" type="text" value="', $context['prefix']['icon_url'], '" style="width: 200px">
				</dd>
			</dl>

			<dl class="settings">
				<dt>
					<a id="setting_groups"></a>
					<span><label for="groups">', $txt['PostPrefix_prefix_groups'], ':</label></span>
				</dt>
				<dd>
					', template_postprefix_groups_list(), '
				</dd>
				<dt>
					<a id="setting_boards"></a>
					<span><label for="boards">', $txt['PostPrefix_prefix_boards'], ':</label></span>
				</dt>
				<dd>
					', template_postprefix_boards_list(), '
				</dd>
			</dl>

			<input class="button_submit floatleft" type="submit" value="', $txt['PostPrefix_save_prefix'], '">
			<br class="clear" />

		</form>
		<span class="botslice"><span></span></span>
	</div><br />';
}

function template_postprefix_groups_list($collapse = true)
{
	global $context, $txt, $modSettings;

	// This looks really weird, but it keeps things nested properly...
	echo '
											<fieldset id="visible_groups">
												<legend>', $txt['PostPrefix_prefix_groups_desc'], '</legend>';
	if (empty($modSettings['permission_enable_deny']))
		echo '
												<ul class="reset padding floatleft">';
	else
		echo '
												<div class="information">', $txt['permissions_option_desc'], '</div>
												<dl class="settings">
													<dt>
													</dt>
													<dd>
														<span class="perms"><strong>', $txt['permissions_option_on'], '</strong></span>
														<span class="perms"><strong>', $txt['permissions_option_off'], '</strong></span>
														<span class="perms red"><strong>', $txt['permissions_option_deny'], '</strong></span>
													</dd>';
	foreach ($context['member_groups'] as $group)
	{
		if (!empty($modSettings['permission_enable_deny']))
			echo '
													<dt>';
		else
			echo '
													<li>';

		if (empty($modSettings['permission_enable_deny']))
			echo '
														<input type="checkbox" name="usegroup[', $group['id'], ']" value="', $group['id'], '"', $group['allow'] ? ' checked' : '', ' class="input_check">';
		else
			echo '
														<span', $group['is_post_group'] ? ' style="border-bottom: 1px dotted #000; cursor: help;" title="' . $txt['mboards_groups_post_group'] . '"' : ($group['id'] == 0 ? ' style="border-bottom: 1px dotted #000; cursor: help;" title="' . $txt['mboards_groups_regular_members'] . '"' : ''), '>', $group['name'], '</span>';

		if (!empty($modSettings['permission_enable_deny']))
			echo '
													</dt>
													<dd>
														<span class="perms"><input type="radio" name="usegroup[', $group['id'], ']" value="allow"', $group['allow'] ? ' checked' : '', ' class="input_radio"></span>
														<span class="perms"><input type="radio" name="usegroup[', $group['id'], ']" value="ignore"', !$group['allow'] && !$group['deny'] ? ' checked' : '', ' class="input_radio"></span>
														<span class="perms"><input type="radio" name="usegroup[', $group['id'], ']" value="deny"', $group['deny'] ? ' checked' : '', ' class="input_radio"></span>
													</dd>';
		else
			echo '
														<span', $group['is_post_group'] ? ' style="border-bottom: 1px dotted #000; cursor: help;" title="' . $txt['mboards_groups_post_group'] . '"' : ($group['id'] == 0 ? ' style="border-bottom: 1px dotted #000; cursor: help;" title="' . $txt['mboards_groups_regular_members'] . '"' : ''), '>', $group['name'], '</span>
													</li>';
	}

	if (empty($modSettings['permission_enable_deny']))
		echo '

												</ul>';
	else
		echo '
												</dl>';

	if (empty($modSettings['permission_enable_deny']))
		echo '
												<br class="clear">
												<input type="checkbox" id="checkall_check" class="input_check" onclick="invertAll(this, this.form, \'usegroup\');"> <label for="checkall_check"><em>', $txt['check_all'], '</em></label>
											</fieldset>';

	else
		echo '
												<span class="select_all_box">
													<em>', $txt['all'], ': </em>
													<input type="radio" name="select_all" id="allow_all" class="input_radio" onclick="selectAllRadio(this, this.form, \'usegroup\', \'allow\');"> <label for="allow_all">', $txt['permissions_option_on'], '</label>
													<input type="radio" name="select_all" id="ignore_all" class="input_radio" onclick="selectAllRadio(this, this.form, \'usegroup\', \'ignore\');"> <label for="ignore_all">', $txt['permissions_option_off'], '</label>
													<input type="radio" name="select_all" id="deny_all" class="input_radio" onclick="selectAllRadio(this, this.form, \'usegroup\', \'deny\');"> <label for="deny_all">', $txt['permissions_option_deny'], '</label>
												</span>
											</fieldset>
											<script><!-- // --><![CDATA[
												$(document).ready(function () {
													$(".select_all_box").each(function () {
														$(this).removeClass(\'select_all_box\');
													});
												});
											// ]]></script>';

	if ($collapse)
		echo '
							<a href="javascript:void(0);" onclick="document.getElementById(\'visible_groups\').style.display = \'block\'; document.getElementById(\'visible_groups_link\').style.display = \'none\'; return false;" id="visible_groups_link" style="display: none;">[ ', $txt['PostPrefix_select_visible_groups'], ' ]</a>
							<script><!-- // --><![CDATA[
								document.getElementById("visible_groups_link").style.display = "";
								document.getElementById("visible_groups").style.display = "none";
							// ]]></script>';
}

function template_postprefix_boards_list($collapse = true)
{
	global $context, $txt, $modSettings;

	echo '
							<fieldset id="visible_boards">
								<legend>', $txt['PostPrefix_prefix_boards_desc'], '</legend>
								<ul class="reset padding floatleft">';

	foreach ($context['categories'] as $category)
	{
			echo '
									<li class="category">
										<a href="javascript:void(0);" onclick="selectBoards([', implode(', ', $category['child_ids']), '], \'PostPrefixAdd\'); return false;"><strong>', $category['name'], '</strong></a>
										<ul style="width:100%">';

		foreach ($category['boards'] as $board)
		{
				echo '
											<li class="board" style="margin-', $context['right_to_left'] ? 'right' : 'left', ': ', $board['child_level'], 'em;">
												<input type="checkbox" id="brd', $board['id'], '" name="useboard[', $board['id'], ']" value="', $board['id'], '"', $board['allow'] ? ' checked' : '', ' class="input_check"> <label for="useboard[', $board['id'], ']">', $board['name'], '</label>
											</li>';
		}

		echo '
										</ul>
									</li>';
	}

		echo '
								</ul>
								<br class="clear"><br>
								<input type="checkbox" id="checkall_check" class="input_check" onclick="invertAll(this, this.form, \'useboard\');"> <label for="checkall_check"><em>', $txt['check_all'], '</em></label>
							</fieldset>';

	if ($collapse)
		echo '
							<a href="javascript:void(0);" onclick="document.getElementById(\'visible_boards\').style.display = \'block\'; document.getElementById(\'visible_boards_link\').style.display = \'none\'; return false;" id="visible_boards_link" style="display: none;">[ ', $txt['PostPrefix_select_visible_boards'], ' ]</a>
							<script><!-- // --><![CDATA[
								document.getElementById("visible_boards_link").style.display = "";
								document.getElementById("visible_boards").style.display = "none";
								function selectBoards(ids)
								{
									var toggle = true;

									for (i = 0; i < ids.length; i++)
										toggle = toggle & document.forms.PostPrefixAdd["brd" + ids[i]].checked;

									for (i = 0; i < ids.length; i++)
										document.forms.PostPrefixAdd["brd" + ids[i]].checked = !toggle;
								}
							// ]]></script>';
}

function template_postprefix_showgroups()
{
	global $context, $boardurl, $settings, $modSettings, $txt;

	echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"', $context['right_to_left'] ? ' dir="rtl"' : '', '>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=', $context['character_set'], '" />
		<meta name="robots" content="noindex" />
		<title>', $context['page_title'], '</title>
		<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/index.css" />
		<script type="text/javascript" src="', $settings['default_theme_url'], '/scripts/script.js"></script>
	</head>
	<body id="postprefix_showgroups_popup">
		<div class="windowbg">
			<table class="table_grid clear">
				<thead>
					<tr class="title_bar">
						<th class="titlebg">
							', $txt['PostPrefix_prefix_groups'], '
						</th>
					</tr>
				</thead>
				<tbody>';

	if ($context['empty_groups'] == 1)
	{
		echo '
					<tr class="up_contain">
						<td>
							', $txt['PostPrefix_empty_groups'], '
						</td>
					</tr>';
	}
	else
	{
		// We're going to list all the groups...
		foreach ($context['member_groups'] as $group)
		{
			echo '
					<tr class="stripes">
						<td>
							<span', $group['is_post_group'] ? ' style="border-bottom: 1px dotted #000; cursor: help;" title="' . $txt['mboards_groups_post_group'] . '"' : ($group['id'] == 0 ? ' style="border-bottom: 1px dotted #000; cursor: help;" title="' . $txt['mboards_groups_regular_members'] . '"' : ''), '>
								', $group['name'], '
							</span>
						</td>
					</tr>';
		}
	}

	echo '
				</tbody>
			</table>
		</div>
	</body>
</html>';
}

function template_postprefix_showboards()
{
	global $context, $settings, $modSettings, $txt, $scripturl;

	echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"', $context['right_to_left'] ? ' dir="rtl"' : '', '>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=', $context['character_set'], '" />
		<meta name="robots" content="noindex" />
		<title>', $context['page_title'], '</title>
		<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/index.css" />
		<script type="text/javascript" src="', $settings['default_theme_url'], '/scripts/script.js"></script>
	</head>
	<body id="postprefix_showboards_popup">
		<div class="windowbg">
			<div class="title_bar">
				<h4 class="titlebg">
					', $txt['PostPrefix_prefix_boards'], '
				</h4>
			</div>';

	if ($context['empty_boards'] == 1)
	{
		echo '
			<div class="up_contain">
					', $txt['PostPrefix_empty_boards'], '
			</div>';
	}
	else
	{
		// We're going to list all the boards...
		foreach ($context['categories'] as $category)
		{
			echo '
			<div class="cat_bar">
				<h3 class="catbg">
					<a href="', $scripturl, '/index.php#c', $category['id'], '">', $category['name'], '</a>
				</h3>
			</div>';

			foreach ($category['boards'] as $board)
			{
				echo '
				<div class="up_contain" style="min-height: 15px;">
					<span style="margin-', $context['right_to_left'] ? 'right' : 'left', ': ', $board['child_level'], 'em;"><a class="subject" href="', $scripturl, '?board=', $board['id'], '.0">', $board['name'], '</a></span>
				</div>';
			}
		}
	}

	echo '
			<br class="clear">
		</div>
	</body>
</html>';
}

function template_require_prefix()
{
	global $context, $txt, $scripturl;

	// Updated?
	echo $context['required']['updated'];

	echo '
	<div class="windowbg">
		<span class="topslice"><span></span></span>
		<form name="PostPrefixRequire" class="content" id="PostPrefixRequire" method="post" action="', $scripturl, '?action=admin;area=postprefix;sa=require2">

			<dl class="settings">
				<dt>
					<a id="setting_boards"></a>
					<span><label for="boards">', $txt['PostPrefix_prefix_boards_require'], ':</label></span>
				</dt>
				<dd>
							<fieldset id="visible_boards">
								<legend>', $txt['PostPrefix_prefix_boards_require_desc'], '</legend>
								<ul class="reset padding floatleft">';

	foreach ($context['categories'] as $category)
	{
			echo '
									<li class="category">
										<a href="javascript:void(0);" onclick="selectBoards([', implode(', ', $category['child_ids']), '], \'PostPrefixRequire\'); return false;"><strong>', $category['name'], '</strong></a>
										<ul style="width:100%">';

		foreach ($category['boards'] as $board)
		{
				echo '
											<li class="board" style="margin-', $context['right_to_left'] ? 'right' : 'left', ': ', $board['child_level'], 'em;">
												<input type="checkbox" id="brd', $board['id'], '" name="requireboard[', $board['id'], ']" value="', $board['id'], '"', $board['require'] ? ' checked' : '', ' class="input_check"> <label for="requireboard[', $board['id'], ']">', $board['name'], '</label>
											</li>';
		}

		echo '
										</ul>
									</li>';
	}

		echo '
								</ul>
								<br class="clear"><br>
								<input type="checkbox" id="checkall_check" class="input_check" onclick="invertAll(this, this.form, \'requireboard\');"> <label for="checkall_check"><em>', $txt['check_all'], '</em></label>
							</fieldset>
							<a href="javascript:void(0);" onclick="document.getElementById(\'visible_boards\').style.display = \'block\'; document.getElementById(\'visible_boards_link\').style.display = \'none\'; return false;" id="visible_boards_link" style="display: none;">[ ', $txt['PostPrefix_select_visible_boards'], ' ]</a>
							<script><!-- // --><![CDATA[
								document.getElementById("visible_boards_link").style.display = "";
								document.getElementById("visible_boards").style.display = "none";
								function selectBoards(ids)
								{
									var toggle = true;

									for (i = 0; i < ids.length; i++)
										toggle = toggle & document.forms.PostPrefixAdd["brd" + ids[i]].checked;

									for (i = 0; i < ids.length; i++)
										document.forms.PostPrefixAdd["brd" + ids[i]].checked = !toggle;
								}
							// ]]></script>
				</dd>
			</dl>

			<input class="button_submit floatleft" type="submit" value="', $txt['save'], '">
			<br class="clear" />

		</form>
		<span class="botslice"><span></span></span>
	</div>
	<br />';
}

function template_postprefix_above()
{
}

function template_postprefix_below()
{
	global $context;

	echo $context['copyright'];
}