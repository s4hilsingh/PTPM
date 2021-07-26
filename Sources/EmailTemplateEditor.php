<?php
/*****************************************************
* EmailTemplateEditor.php                            *
*----------------------------------------------------*
* Project Name: Email Template Editor                *
* Version: 1.0                                       *
* Written by: Labradoodle-360                        *
*----------------------------------------------------*
* Copyright 2011 Matthew Kerle                       *
*****************************************************/

if (!defined('SMF'))
	die ('Hacking Attempt...');

function ModifyEmailTemplates()
{

	// Globalize what we need...
	global $context, $txt, $scripturl, $sourcedir, $modSettings, $settings;

	// Some source files...
	require_once($sourcedir. '/Subs-List.php');
	require_once($sourcedir. '/Subs-Post.php');
	require_once($sourcedir. '/Subs-EmailTemplateEditor.php');

	// SMF's Email Templates.
	loadLanguage('EmailTemplates');

	// Some things we need of OURS.
	loadLanguage('EmailTemplateEditor');
	loadTemplate('EmailTemplateEditor');
	EmailTemplates();

	// Throw our copyright into template layers...
	$context['template_layers'][] = 'copyright';

	// Define a page title...
	$context['page_title'] = $txt['email_template_editor'];

	// Some final head content...
	$context['html_headers'] .= '
		<style type="text/css">
			.ete_box
			{
				padding: 0.5em 1em;
				font-size: 0.9em;
				line-height: 1.3em;
				border: 1px solid #bbb;
				background: #f0f6f0;
				margin: 0.2em 1px 1em 1px;
			}
			.ete_box:hover
			{
				background-color: #E0E2E0;
			}
			.rfix
			{
				margin-top: -1px;
			}
		</style>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function()
			{
				$(\'#profile_success\').delay(2000).slideUp(2500);
				$(\'#profile_error\').delay(2000).slideUp(2500);
			});
		</script>';

	// Our possible "needles".
	$possible_needles = array('add', 'add2', 'add3', 'delete', 'modify', 'modify2', 'testemail', 'emailsent');

	// Global Pre-Set Variables...
	$context['email_templates']['preset_variables']['global'] = array(
		'forumname' => '{FORUMNAME}',
		'scripturl' => '{SCRIPTURL}',
		'themeurl' => '{THEMEURL}',
		'imagesurl' => '{IMAGESURL}',
		'default_themeurl' => '{DEFAULT_THEMEURL}',
		'regards' => '{REGARDS}'
	);

	// Notifications FTW!
	if (isset($_REQUEST['completed']) && in_array($_REQUEST['completed'], array('true', 'false')) && isset($_REQUEST['from']) && in_array($_REQUEST['from'], $possible_needles))
	{
		// Possibilities...
		$context['email_templates']['notifications'] = array(
			'add' => array(
				'true' => $txt['email_template_noti_true']. ' '. $txt['email_template_noti_added'],
				'false' => $txt['email_template_noti_false']. ' '. $txt['email_template_noti_added']
			),
			'delete' => array(
				'true' => $txt['email_template_noti_true']. ' '. $txt['email_template_noti_deleted'],
				'false' => $txt['email_template_noti_false']. ' '. $txt['email_template_noti_deleted']
			),
			'modify' => array(
				'true' => $txt['email_template_noti_true']. ' '. $txt['email_template_noti_modified'],
				'false' => $txt['email_template_noti_false']. ' '. $txt['email_template_noti_modified']
			),
			'emailsent' => array(
				'true' => $txt['email_template_noti_true_emailsent'],
				'false' => $txt['email_template_noti_false_emailsent']
			)
		);
		foreach ($context['email_templates']['notifications'] as $act => $notification)
		{
			// Only one notification at a time. Throw the rest down the hill Zach. ;)
			if ($act != $_REQUEST['from'])
				unset($context['email_templates']['notifications'][$act]);
		}
	}

	// This is simply for wackos.
	foreach ($txt['emails'] as $act => $email)
		$context['email_templates']['full'][$act] = ucwords(str_replace('_', ' ', $act));
	$context['email_templates']['leftovers'] = array_diff_key($context['email_templates']['full'], $context['email_templates']['id_template']);

	// Some validation of URL input put into needles.
	$needle = isset($_REQUEST['query']) && !empty($_REQUEST['query']) && in_array($_REQUEST['query'], $possible_needles) ? $_REQUEST['query'] : '';
	$general_needle = isset($_REQUEST['template']) && !empty($_REQUEST['template']) && in_array(ucwords(str_replace('_', ' ', $_REQUEST['template'])), $context['email_templates']['full']) ? $_REQUEST['template'] : '';

	// If we have an existing ID set...we want to modify, not add.
	if (!empty($needle) && $needle == 'add' && !empty($general_needle) && !in_array(ucwords(str_replace('_', ' ', $general_needle)), $context['email_templates']['leftovers']))
		redirectexit('action=admin;area=emailtemplates;query=modify;template='. $_REQUEST['template']);

	// Add; 1 - Simply process the inputted id and continue.
	if (!empty($needle) && $needle == 'add2' && isset($_POST['basedon']))
		redirectexit('action=admin;area=emailtemplates;query=add;template='. $_POST['basedon']);

	// Add; 2 - This is the actual "add" form.
	elseif (!empty($needle) && $needle == 'add' && !empty($general_needle))
	{
		$context['sub_template'] = 'add';
		$context['page_title'] = $txt['email_template_add']. ' - '. $txt['email_template_editor'];
		$context['linktree'][] = array(
			'url' => '',
			'name' => $txt['email_template_add']. ' '.$context['email_templates']['full'][$_REQUEST['template']],
		);
	}

	// Add; 3 - Here, we actually submit the input and redirect.
	elseif (!empty($needle) && $needle == 'add3')
	{
		addCustomEmailTemplate();
		redirectexit('action=admin;area=emailtemplates;completed=true;from=add');
	}

	// Deleting
	elseif (!empty($needle) && $needle == 'delete' && !empty($general_needle))
	{
		delete_custom_template($general_needle);
		redirectexit('action=admin;area=emailtemplates;completed=true;from=delete');
	}

	// Modifying
	elseif (!empty($needle) && $needle == 'modify' && !empty($general_needle))
	{
		$context['sub_template'] = 'modify';
		$context['page_title'] = $txt['email_template_modify']. ' - '. $txt['email_template_editor'];
		$context['linktree'][] = array(
			'url' => $scripturl. '?action=admin;area=emailtemplates;query=modify;template='. $general_needle,
			'name' => $txt['email_template_modify']. ' '. $context['email_templates']['id_template'][$general_needle]['display_name'],
		);
	}
	elseif (!empty($needle) && $needle == 'modify2')
	{
		modify_custom_template($general_needle);
		redirectexit('action=admin;area=emailtemplates;completed=true;from=modify');
	}

	// Test Email?
	if (!empty($needle) && $needle == 'testemail' && isset($_POST['recipient']) && isset($_POST['template']) && !empty($_POST['recipient']))
	{
		checkSession('post', '', true);
		$replacements = array();
		$testMailData = loadEmailTemplate($_POST['template'], $replacements, 'english', true);
		sendmail($_POST['recipient'], $testMailData['subject'], $testMailData['body'], null, null, false, 2);
		redirectexit('action=admin;area=emailtemplates;completed=true;from=emailsent');
	}

	// If we tried to submit without an email, return and let them know.
	elseif (!empty($needle) && $needle == 'testemail' && isset($_POST['recipient']) && isset($_POST['template']) && empty($_POST['recipient']))
		redirectexit('action=admin;area=emailtemplates;testemail=norecipient;completed=false;from=emailsent');	

	// Our list options.
	$listOptions = array(
		'id' => 'custom_email_templates',
		'items_per_page' => $modSettings['defaultMaxMessages'],
		'no_items_label' => $txt['email_template_empty_list'],
		'base_href' => $scripturl. '?action=admin;area=emailtemplates',
		'default_sort_col' => 'id',
		'get_items' => array(
			'function' => 'get_email_templates',
			'params' => array(),
		),
		'get_count' => array(
			'function' => 'get_email_templates_count',
			'params' => array(),
		),
		'columns' => array(
			'id' => array(
				'header' => array(
					'value' => $txt['email_template_name'],
				),
				'data' => array(
					'db' => 'display_name',
				),
				'sort' => array(
					'default' => 'et.id_template',
					'reverse' => 'et.id_template DESC',
				),
			),
			'subject' => array(
				'header' => array(
					'value' => $txt['email_template_subject'],
				),
				'data' => array(
					'db' => 'subject',
				),
				'sort' => array(
					'default' => 'et.subject',
					'reverse' => 'et.subject DESC',
				),
			),
			'body' => array(
				'header' => array(
					'value' => $txt['email_template_body'],
				),
				'data' => array(
					'db' => 'body',
				),
				'sort' => array(
					'default' => 'et.body',
					'reverse' => 'et.body DESC',
				),
			),
			'actions' => array(
				'header' => array(
					'value' => $txt['email_template_actions'],
				),
				'data' => array(
					'db' => 'actions',
					'style' => 'text-align: center;',
				),
			),
		),
	);

	// Create the list
	createList($listOptions);

}

?>