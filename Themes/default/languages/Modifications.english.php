<?php
// Version: 2.0; Modifications

// Country Flag mod
$txt['country_flag_label'] = 'Please select your country';
$txt['country_flag_error_required'] = 'You must select the country that you visit us from';
$txt['country_flag_ask'] = 'Ask for country flag on';
$txt['country_flag_disabled'] = 'Don\'t show (Disabled)';
$txt['country_flag_profile'] = 'Profile';
$txt['country_flag_registration'] = 'Registration';
$txt['country_flag_both'] = 'Both';
$txt['country_flag_required'] = 'Require a member to select a location?';
$txt['country_flag_show'] = 'Show flags on Display page (Where posts are shown).';
$txt['country_flag'] = 'Country';

$txt['random_signature'] = 'Use a random signature';
$txt['signature'] = isset($txt['signature']) ? $txt['signature'] : 'Signature';
$txt['signature_numb'] = 'Signature %1$s';
$txt['nosignature'] = 'No signature';
$txt['randomsignature'] = 'Random signature';
$txt['restoresignatures'] = 'Reset to single signature per user';
$txt['choose_signature'] = 'Select the type of signature you want to show';
$txt['normal_signature'] = 'Normal signature';
$txt['signatures_still_missing'] = 'Sorry, there are still [MISSING_SIGNATURES] signatures to be checked.<br />The job has been stopped in order to avoid server overload and timeouts.';
$txt['signature_continue'] = 'Continue';
$txt['signatures_restored'] = 'All the users\' signatures has been restored to single signature';
$txt['default_signature'] = 'Default signature (it will be used when members don\'t have their one signature).<div class="smalltext">See help for details on placeholders. BBCode is supported.</div>';
$txt['max_numberofSignatures'] = 'Maximum allowed signatures per user<div class="smalltext">(not less than 1)<br />Please use the option in <a href="' . $boardurl . '/index.php?action=admin;area=maintain;sa=members">members\' maintenance page</a> to reset to 1 signature per user before uninstall</div>';
$txt['permissionname_hide_topic_signatures'] = 'Hide users\' signatures in topics';
$txt['hide_sign'] = 'Hide signatures';
$txt['unhide_sign'] = 'Show signatures';
$txt['modlog_ac_hide_sign'] = 'Hidden signatures &quot;{topic}&quot;';
$txt['modlog_ac_unhide_sign'] = 'Unhidden signatures &quot;{topic}&quot;';
$txt['disable_log_hide_signature'] = 'Disable logging of hide signature action';
$txt['mboards_disabled_signatures'] = 'Disable signatures';
$txt['mboards_disabled_signatures_desc'] = 'Do not show members\' signatures for this board';

$txt['remove_image_from_post'] = 'Image removed from quote';// Unread PMs strings.
$txt['unreadPMstimeout'] = 'Unread PMs Favicon Counter';
$txt['unreadPMstimeout_post'] = 'seconds between checks (setting this to low may cause performance issues)';$txt['show_additional_groups'] = 'Show additional membergroups on Topic Display and Profile Summary?';
$txt['show_additional_groups_name'] = 'Show the name of the additional membergroups? If not selected, only the stars will be shown.<br /> This is only active if the previous option is selected';
// Labradoodle-360; Email Template Editor
$txt['email_template_editor'] = 'Email Template Editor';
// End Labradoodle-360; Email Template Editor

// MarcusJ's Hide Membergroup Titles Mod.
$txt['enable_membergroup_display'] = 'Display Membergroup Titles on Posts';

$txt['starsByGroup_array'] = 'Arrange the group ID to show the post stars.<div class="smalltext">(Must be separed by coma. ie: 1,3,7)</div>';

//	Pretty URLs mod
$txt['pretty_urls'] = 'Pretty URLs';

$txt['enable_default_avatar'] = 'Enable Default Avatar';
$txt['default_male_avatar_url'] = 'Image url for Default Avatar image for male members';
$txt['default_female_avatar_url'] = 'Image url for Default Avatar image for female members';
$txt['default_avatar_url'] = 'Image url for Default Avatar image';
$txt['default_avatar_path'] = '(If you haven\'t provide any url a default image will be shown)';
$txt['default_avatar_opacity'] = 'Makes default avatars transparent when user logs out';


//Begin InvitationMessageInYourFace Text Strings
$txt['imiyf_enable'] = 'Enable Invitation Message In Your Face';
$txt['imiyf_txt'] = 'Type the text that will be shown in the message';
$txt['imiyf_top_right'] = 'Top Right position';
$txt['imiyf_top_left'] = 'Top Left position';
$txt['imiyf_bottom_right'] = 'Bottom Right position';
$txt['imiyf_bottom_left'] = 'Bottom Left position';
$txt['imiyf_center'] = 'Center position';
$txt['imiyf_life'] = 'Time before autoclose (miliseconds)';
$txt['imiyf_life_sub'] = 'ex. 10000 miliseconds = 10 seconds';
$txt['imiyf_sticky_true'] = 'Do you want sticky ON?';
$txt['imiyf_sticky_false'] = 'Do you want sticky OFF?';
//END InvitationMessageInYourFace Text Strings

$txt['who_is_online_avatar_show'] = 'Who is online avatar show';
$txt['who_is_avatar'] = 'Avatar';
$txt['who_is_online_avatar_height'] = 'Who is_online avatar max-height (px)';
$txt['who_is_online_avatar_30px'] = '30px';
$txt['who_is_online_avatar_40px'] = '40px';
$txt['who_is_online_avatar_50px'] = '50px';
$txt['who_is_online_avatar_60px'] = '60px';
$txt['who_is_online_avatar_70px'] = '70px';
$txt['who_is_online_avatar_80px'] = '80px';
$txt['who_is_online_avatar_90px'] = '90px';
$txt['who_is_online_avatar_100px'] = '100px';

// Spoiler Mod
// BBC Strings
$txt['bbc_spoiler'] = 'Insert Spoiler';

// Post View Text
$txt['spoiler_tag_text'] = 'Spoiler';
$txt['spoiler_tag_click_info'] = '(click to show/hide)';
$txt['spoiler_tag_hover_info'] = '(hover to show)';

// Mod Settings
$txt['defaultSpoilerStyle'] = 'Spoiler Mode';
$txt['spoiler_tag_onhoverovershow'] = 'Show on Hover';
$txt['spoiler_tag_onlinkclickshow'] = 'Show on Link Click';
$txt['spoiler_tag_onbuttonclickshow'] = 'Show on Button Click';


// Extra Settings String for per-theme selection
$txt['spoiler_tag_label'] = 'Spoiler Mode';
$txt['spoiler_tag_desc'] = 'Choose how spoilers will display on the theme.';
$txt['spoiler_tag_default'] = '(use global default spoiler mode)';
//reCAPTCHA for SMF
$txt['recaptcha_configure'] = 'reCAPTCHA Verification System';
$txt['recaptcha_configure_desc'] = 'Use the reCAPTCHA Verification System. Don\'t have a key for reCAPTCHA? <a href="https://www.google.com/recaptcha/admin"> Get your reCAPTCHA key here</a>.';
$txt['recaptcha_enabled'] = 'Use reCAPTCHA Verification System';
$txt['recaptcha_enable_desc'] = '(This replaces the built-in visual verification with reCAPTCHA)';
$txt['recaptcha_theme'] = 'reCAPTCHA Theme';
$txt['recaptcha_theme_light'] = 'Light';
$txt['recaptcha_theme_dark'] = 'Dark';
$txt['recaptcha_public_key'] = 'reCAPTCHA Public Key';
$txt['recaptcha_private_key'] = 'reCAPTCHA Private Key';
$txt['recaptcha_no_key_question'] = 'Don\'t have a key for reCAPTCHA?';
$txt['recaptcha_get_key'] = 'Get your reCAPTCHA key here.';

?>