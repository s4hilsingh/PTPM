<?php
/*****************************************************
* EmailTemplateEditor.english.php                    *
*----------------------------------------------------*
* Project Name: Email Template Editor                *
* Version: 1.0                                       *
* Written by: Labradoodle-360                        *
*----------------------------------------------------*
* Copyright 2011 Matthew Kerle                       *
*****************************************************/

global $scripturl;
$txt['email_template_editor'] = 'Email Template Editor';
$txt['email_template_editor_acp_desc'] = 'Email Template Editor allows you to modify the default emails that are sent out by your server for different occasions.';
$txt['email_template_select'] = 'Select a Template';
$txt['email_template_editor_noid'] = 'No id, or an invalid ID was selected. Try again.';

/* New Template? */
$txt['email_template_custom_from'] = 'Create Custom Email Template From';
$txt['email_template_custom_create'] = 'Create';

/* List Items */
$txt['email_template_name'] = 'Name';
$txt['email_template_subject'] = 'Subject';
$txt['email_template_body'] = 'Body';
$txt['email_template_actions'] = 'Actions';
$txt['email_template_empty_list'] = 'Sorry. No custom email templates.';
$txt['email_template_list_header'] = 'Custom Email Templates';
$txt['email_template_save'] = 'Save';

/* Test Email */
$txt['email_template_test_email'] = 'Send Test Email';
$txt['email_template_select'] = 'Select Template';
$txt['email_template_recipient'] = 'Recipient\'s Email';
$txt['email_template_send'] = 'Send Email';
$txt['email_template_test_help'] = 'Note that only <strong>Global Preset Variables</strong> (<a href="'. $scripturl. '?action=helpadmin;help=email_template_help_global_presets" onclick="return reqWin(this.href);">?</a>) will be parsed in Test Emails.';

/* Add and Modify */
$txt['email_template_global_presets'] = 'Global Pre-Set Variables';

/* Sub-Actions */
$txt['email_template_add'] = 'Add';
$txt['email_template_modify'] = 'Modify';
$txt['email_template_delete'] = 'Delete';

/* Notification Messages */
$txt['email_template_noti_true'] = 'Custom Email Template Successfully';
$txt['email_template_noti_false'] = 'Custom Email Template could not be';
$txt['email_template_noti_added'] = 'Added.';
$txt['email_template_noti_deleted'] = 'Deleted.';
$txt['email_template_noti_modified'] = 'Modified.';
$txt['email_template_noti_true_emailsent'] = 'Your Test Email Was Successfully Sent.';
$txt['email_template_noti_false_emailsent'] = 'Your test email could not be sent. Make sure the field "Recipient\'s Email" is filled out.';

$txt['email_template_success'] = 'Success';
$txt['email_template_error'] = 'Error';

/* Copyright; DO NOT MODIFY OR REMOVE */
$txt['email_template_copyright'] = '<a href="http://www.simplemachines.org/community/index.php?action=profile;u=182638" target="_blank">Email Template Editor 1.0 - Matthew Kerle &copy; 2011</a>';

?>