<?php
/*****************************************************
* EmailTemplateEditor.template.php                   *
*----------------------------------------------------*
* Project Name: Email Template Editor                *
* Version: 1.0                                       *
* Written by: Labradoodle-360                        *
*----------------------------------------------------*
* Copyright 2011 Matthew Kerle                       *
*****************************************************/

function template_main()
{

	// Globalize what we need...
	global $txt, $context, $scripturl, $settings;

	// Here is our global header.
	echo '<div class="cat_bar">
			<h3 class="catbg">
				<span class="floatleft" style="display: block; width: 18px;', !$context['browser']['is_ie'] ? ' margin-top: 8px;' : '', '">
					<img src="', $settings['images_url'], '/admin/application_view_tile.png" alt="*" border="" />
				</span>', $txt['email_template_editor'], '</h3>
		</div>
	<div class="information">', $txt['email_template_editor_acp_desc'], '</div>';
							
	// New Custom Template
	if (!empty($context['email_templates']['leftovers']))
	{
		echo '<div class="cat_bar" style="height: 28px;">
				<h3 class="catbg">
					<label for="basedon">', $txt['email_template_custom_from'], '</label>
				</h3>
			</div>
			<div class="roundframe rfix">
				<div class="innerframe">
					<div class="content">
						<form action="', $scripturl, '?action=admin;area=emailtemplates;query=add2" method="post">
							<select name="basedon" id="basedon">';
								foreach ($context['email_templates']['leftovers'] as $act => $email_template)
									echo '<option value="', $act, '">', $email_template, '&nbsp;</option>';
							echo '</select>
							<input type="submit" value="', $txt['email_template_custom_create'], '" class="button_submit" />
						</form>
					</div>
				</div>
			</div>
		<span class="lowerframe"><span></span></span><br />';
	}

	if (isset($context['email_templates']['notifications']))
	{
		echo '<div id="', $_REQUEST['completed'] == 'true' ? 'profile_success' : 'profile_error', '">
				<div class="floatleft" style="width: 18px; margin-top: 1px;">
					<img src="', $settings['images_url'], '/email_templates/', $_REQUEST['completed'] == 'true' ? 'tick.png"' : 'cross.png"', ' alt="*" border="" />
				</div>', $context['email_templates']['notifications'][$_REQUEST['from']][$_REQUEST['completed']], '
		</div>';
	}

	// List Header
	echo '<div class="cat_bar">
			<h3 class="catbg">', $txt['email_template_list_header'], '</h3>
		</div>';

	// Actual List
	template_show_list('custom_email_templates');

	// Only show "Send Test Email" if we have custom email templates.
	if (!empty($context['email_templates']['id_template']))
	{
		echo '<br /><div class="cat_bar" style="height: 28px;">
				<h3 class="catbg">
						<a href="', $scripturl, '?action=helpadmin;help=email_template_help_send_test_email" onclick="return reqWin(this.href);">
							<span class="floatleft" style="display: block; margin-top: 7px; margin-right: 4px;">
								<img src="', $settings['images_url'],'/helptopics.gif" border="" alt="*" />
							</span>
						</a>', $txt['email_template_test_email'], '</h3>
			</div>
			<div class="roundframe rfix">
				<div class="innerframe">
					<div class="content">
						<form action="', $scripturl, '?action=admin;area=emailtemplates;query=testemail" method="post">
							<div class="floatleft" style="width: 35%;">
								<label for="template"><strong>', $txt['email_template_select'], ':</strong></label>&nbsp;
									<select name="template" id="template">';
										foreach ($context['email_templates']['id_template'] as $key => $template)
										echo '<option value="', $key, '">', $template['display_name'], '</option>';
									echo '</select>
							</div>
							<div class="floatright" style="width: 65%;">
								<label for="recipient"><strong><span', isset($_REQUEST['testemail']) && $_REQUEST['testemail'] == 'norecipient' ? ' style="color: #ff0000;"' : '', '>', $txt['email_template_recipient'], ':</span></strong></label>&nbsp;
									<input type="text" name="recipient" id="recipient" class="input_text" style="width: 35%;" value="', $context['user']['email'], '" />
									<div class="floatright">
										<input type="submit" value="', $txt['email_template_send'], '" class="button_submit" />
									</div>
							</div>
							<br class="clear" />
							<div class="smalltext"><em>', $txt['email_template_test_help'], '</em></div>
							<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
						</form>
					</div>
				</div>
			</div>
		<span class="lowerframe"><span></span></span>';
	}

}

function template_add()
{

	// Globalize what we need...
	global $txt, $context, $settings, $scripturl;

	// Here is our global header.
	echo '<div class="cat_bar">
			<h3 class="catbg">
				<span class="floatleft" style="display: block; width: 18px; margin-top: 8px;">
					<img src="', $settings['images_url'], '/admin/application_view_tile.png" alt="*" border="" />
				</span>', $txt['email_template_editor'], '</h3>
		</div>
	<div class="information">', $txt['email_template_editor_acp_desc'], '</div>';

	// 1) Global Pre-Set Variables
	echo '<div class="floatleft" style="width: 20%;">
			<div class="cat_bar" style="height: 28px;">
				<h3 class="catbg">
					<a href="', $scripturl, '?action=helpadmin;help=email_template_help_global_presets" onclick="return reqWin(this.href);">
						<span class="floatleft" style="display: block; margin-top: 7px; margin-right: 4px;">
							<img src="', $settings['images_url'],'/helptopics.gif" border="" alt="*" />
						</span>
					</a>', $txt['email_template_global_presets'], '</h3>
			</div>
			<div class="roundframe rfix">
				<div class="innerframe">
					<div class="content">';
						foreach ($context['email_templates']['preset_variables']['global'] as $key => $global_presetvar)
							echo '<div class="ete_box">', $global_presetvar, '</div>';
					echo '</div>
				</div>
			</div>
		<span class="lowerframe"><span></span></span>
	</div>';

	// 2) Main Column
	/* -- Return the id to it's db form. -- */
	$db_id_template_name = strtolower(str_replace(' ', '_', $context['email_templates']['full'][$_REQUEST['template']]));
	echo '<div class="floatright" style="width: 79%;">
			<div class="cat_bar" style="height: 28px;">
				<h3 class="catbg">', $txt['email_template_add'], ' ', $context['email_templates']['full'][$_REQUEST['template']], '</h3>
			</div>
			<div class="roundframe rfix">
				<div class="innerframe">
					<div class="content">
						<form action="', $scripturl, '?action=admin;area=emailtemplates;query=add3" method="post">
							<div class="ete_box">
								<div class="floatleft" style="width: 20%;">
									<label for="subject"><strong>', $txt['email_template_subject'], ':</strong></label> 
								</div>
								<div class="floatright" style="width: 80%; text-align: left;">
									<input type="text" id="subject" name="subject" value="', $txt['emails'][$_REQUEST['template']]['subject'], '" maxlength="255" style="width: 50%;" />
								</div>
								<br class="clear" />
							</div>
							<div class="ete_box">
									<label for="body"><strong>', $txt['email_template_body'], ':</strong></label>
								<div class="floatleft" style="width: 20%;">
								</div>
								<div class="floatright"  style="width: 80%; text-align: left;">
									<textarea id="body" name="body" style="width: 50%;" rows="10">', $txt['emails'][$_REQUEST['template']]['body'], '</textarea>
								</div>
								<br class="clear" />
							</div>
							<div class="floatright ete_box" style="width: 65%; text-align: left;">
								<input type="submit" value="', $txt['email_template_save'], '" class="button_submit" />
							</div>
							<br class="clear" />
							<input type="hidden" value="', $db_id_template_name, '" id="id_template" name="id_template" />
							<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
						</form>
					</div>
				</div>
			</div>
		<span class="lowerframe"><span></span></span>
	</div>
	<br class="clear" />';

}

function template_modify()
{

	// Globalize what we need...
	global $txt, $context, $settings, $scripturl;

	// Here is our global header.
	echo '<div class="cat_bar">
			<h3 class="catbg">
				<span class="floatleft" style="display: block; width: 18px; margin-top: 8px;">
					<img src="', $settings['images_url'], '/admin/application_view_tile.png" alt="*" border="" />
				</span>', $txt['email_template_editor'], '</h3>
		</div>
	<div class="information">', $txt['email_template_editor_acp_desc'], '</div>';

	// 1) Global Pre-Set Variables
	echo '<div class="floatleft" style="width: 20%;">
			<div class="cat_bar" style="height: 28px;">
				<h3 class="catbg">
					<a href="', $scripturl, '?action=helpadmin;help=email_template_help_global_presets" onclick="return reqWin(this.href);">
						<span class="floatleft" style="display: block; margin-top: 7px; margin-right: 4px;">
							<img src="', $settings['images_url'],'/helptopics.gif" border="" alt="*" />
						</span>
					</a>', $txt['email_template_global_presets'], '</h3>
			</div>
			<div class="roundframe rfix">
				<div class="innerframe">
					<div class="content">';
						foreach ($context['email_templates']['preset_variables']['global'] as $key => $global_presetvar)
							echo '<div class="ete_box">', $global_presetvar, '</div>';
					echo '</div>
				</div>
			</div>
		<span class="lowerframe"><span></span></span>
	</div>';

	// 2) Main Column
	echo '<div class="floatright" style="width: 79%;">
			<div class="cat_bar" style="height: 28px;">
				<h3 class="catbg">', $txt['email_template_modify'], ' ', $context['email_templates']['id_template'][$_REQUEST['template']]['display_name'], '</h3>
			</div>
			<div class="roundframe rfix">
				<div class="innerframe">
					<div class="content">
						<form action="', $scripturl, '?action=admin;area=emailtemplates;query=modify2" method="post">
							<div class="ete_box">
								<div class="floatleft" style="width: 20%;">
									<label for="subject"><strong>', $txt['email_template_subject'], ':</strong></label> 
								</div>
								<div class="floatright" style="width: 80%; text-align: left;">
									<input type="text" id="subject" name="subject" value="', $context['email_templates']['id_template'][$_REQUEST['template']]['subject'], '" maxlength="255" style="width: 50%;" />
								</div>
								<br class="clear" />
							</div>
							<div class="ete_box">
								<div class="floatleft" style="width: 20%;">
									<label for="body"><strong>', $txt['email_template_body'], ':</strong></label>
								</div>
								<div class="floatright"  style="width: 80%; text-align: left;">
									<textarea id="body" name="body" style="width: 50%;" rows="10">', $context['email_templates']['id_template'][$_REQUEST['template']]['body'], '</textarea>
								</div>
								<br class="clear" />
							</div>
							<div class="floatright ete_box" style="width: 65%; text-align: left;">
								<input type="submit" value="', $txt['email_template_save'], '" class="button_submit" />
							</div>
							<br class="clear" />
							<input type="hidden" value="', $_REQUEST['template'], '" id="id_template" name="id_template" />
							<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
						</form>
					</div>
				</div>
			</div>
		<span class="lowerframe"><span></span></span>
	</div>
	<br class="clear" />';

}

// !! Copyright; DO NOT MODIFY OR REMOVE
function template_copyright_above()
{
}
function template_copyright_below()
{
	global $txt;
	echo '<div class="centertext smalltext">', $txt['email_template_copyright'], '</div>';
}

?>