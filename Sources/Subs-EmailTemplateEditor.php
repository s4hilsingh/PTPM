<?php
/*****************************************************
* Subs-EmailTemplateEditor.php                       *
*----------------------------------------------------*
* Project Name: Email Template Editor                *
* Version: 1.0                                       *
* Written by: Labradoodle-360                        *
*----------------------------------------------------*
* Copyright 2011 Matthew Kerle                       *
*****************************************************/

if (!defined('SMF'))
	die ('Hacking Attempt...');

function get_email_templates($start, $items_per_page, $sort, $where_vars = array())
{
	global $smcFunc, $txt, $scripturl, $settings, $context, $sourcedir;
	$query = $smcFunc['db_query']('', '
		SELECT et.subject, et.body, et.id_template
		FROM {db_prefix}email_templates AS et
		ORDER BY ' . $sort . '
		LIMIT ' . $start . ', ' . $items_per_page,
		array_merge($where_vars, array(
		))
	);
	$email_templates = array();
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$email_templates[$row['id_template']] = array(
			'display_name' => ucwords(str_replace('_', ' ', $row['id_template'])),
			'subject' => $smcFunc['htmlspecialchars'](shorten_subject($row['subject'], 50), ENT_QUOTES),
			'body' => $smcFunc['htmlspecialchars'](shorten_subject($row['body'], 75), ENT_QUOTES),
			'id_template' => $row['id_template'],
			'actions' => '<a href="'. $scripturl. '?action=admin;area=emailtemplates;query=modify;template='. $row['id_template']. '" target="_self" title="['. $txt['email_template_modify']. ' - '. $row['id_template']. ']"><img src="'. $settings['images_url']. '/email_templates/pencil.png" alt="['. $txt['email_template_modify']. ']" border="" /></a>
							<a href="'. $scripturl. '?action=admin;area=emailtemplates;query=delete;template='. $row['id_template']. ';'. $context['session_var']. '='. $context['session_id']. '" target="_self" title="['. $txt['email_template_delete']. ' - '. $row['id_template']. ']"><img src="'. $settings['images_url']. '/email_templates/delete.png" alt="['. $txt['email_template_delete']. ']" border="" /></a>',
		);
	$smcFunc['db_free_result']($query);

	return $email_templates;
}

function get_email_templates_count($where_vars = array())
{
	global $smcFunc;
	$request = $smcFunc['db_query']('', '
		SELECT COUNT(id_template) AS email_templates_count
		FROM {db_prefix}email_templates',
		array_merge($where_vars, array(
		))
	);
	list ($count) = $smcFunc['db_fetch_row']($request);
	$smcFunc['db_free_result']($request);

	return $count;
}

function EmailTemplates()
{
	global $smcFunc, $context;
	$request = $smcFunc['db_query']('', '
		SELECT id_template, subject, body
		FROM {db_prefix}email_templates'
	);
	$context['email_templates']['id_template'] = array();
	while ($row = $smcFunc['db_fetch_assoc']($request))
	{
		$context['email_templates']['id_template'][$row['id_template']] = array(
			'id_template' => $row['id_template'],
			'subject' => $row['subject'],
			'body' => $row['body'],
			'display_name' => ucwords(str_replace('_', ' ', $row['id_template']))
		);
	}
	$smcFunc['db_free_result']($request);
}

function addCustomEmailTemplate()
{
	global $context, $smcFunc;
	checkSession('post', '', true);
	$smcFunc['db_insert']('insert',
		   '{db_prefix}email_templates',
			array(
				'subject' => 'string',
				'body' => 'text',
				'id_template' => 'string'
			),
			array(
				!empty($_POST['subject']) ? $smcFunc['htmlspecialchars']($_POST['subject'], ENT_QUOTES) : $txt['emails'][$_POST['id_template']]['subject'],
				!empty($_POST['body']) ? $smcFunc['htmlspecialchars']($_POST['body'], ENT_QUOTES) : $txt['emails'][$_POST['id_template']]['body'],
				$_POST['id_template']
			),
			array('id_template')
	);
}

function modify_custom_template($id)
{
	global $txt, $smcFunc;
	checkSession('post', '', true);
	$smcFunc['db_query']('', '
		UPDATE {db_prefix}email_templates
		SET subject={string:subject}, body={string:body}
		WHERE id_template={string:id}',
		array(
			'subject' => !empty($_POST['subject']) ? $smcFunc['htmlspecialchars']($_POST['subject']) : $txt['emails'][$_POST['id_template']]['subject'],
			'body' => !empty($_POST['body']) ? $smcFunc['htmlspecialchars']($_POST['body']) : $txt['emails'][$_POST['id_template']]['body'],
			'id' => $_POST['id_template']
		)
	);
}

function delete_custom_template($id)
{
	global $smcFunc;
	checkSession('get', '', true);
	$smcFunc['db_query']('', '
		DELETE FROM {db_prefix}email_templates
		WHERE id_template={string:id}',
		array(
			'id' => $id,
		)
	);
}

?>