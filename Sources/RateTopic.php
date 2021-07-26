<?php

//rateTopic Source File
//RateTopic.php

function RateTopic()
{
	global $db_prefix, $modSettings, $user_info, $txt, $settings, $context;
	global $sourcedir, $func, $ID_MEMBER;

	loadTemplate('RateTopic');
	loadLanguage('RateTopic');
	
	if((!$user_info['is_guest']) && isset($_REQUEST['rateId']) && isset($_REQUEST['postId']))
	{
		checkSession('get');
		
		$_REQUEST['rateId'] = (int) $_REQUEST['rateId'];
		$_REQUEST['postId'] = (int) $_REQUEST['postId'];
		
		$result = db_query("
			SELECT ID_MEMBER, icon
			FROM {$db_prefix}messages
			WHERE ID_MSG = '{$_REQUEST['postId']}'
			LIMIT 1
			", __FILE__, __LINE__);
		
		if(mysql_num_rows($result) == 0){
			mysql_free_result($result);
		}else{
			$temp = mysql_fetch_assoc($result);
			mysql_free_result($result);
			
			if($ID_MEMBER == $temp['ID_MEMBER'])
				$context['Rate_Topic']['confirmMsg'] = $txt['rateTopic']['self_rate'];
			else{
				$result = db_query("
				SELECT *
				FROM {$db_prefix}rate_topic
				WHERE id_msg = '{$_REQUEST['postId']}' AND id_from = '{$ID_MEMBER}'
				LIMIT 1
				", __FILE__, __LINE__);
	
				if(mysql_num_rows($result) == 0){
					mysql_free_result($result);
			
					db_query("INSERT INTO {$db_prefix}rate_topic
							SET id_msg='{$_REQUEST['postId']}', id_to='{$temp['ID_MEMBER']}', id_from='{$ID_MEMBER}', id_image='{$_REQUEST['rateId']}'" , __FILE__, __LINE__);		
				}else{
					mysql_free_result($result);	
					
					db_query("UPDATE {$db_prefix}rate_topic
					SET id_image='{$_REQUEST['rateId']}'
					WHERE id_msg = '{$_REQUEST['postId']}' AND id_from = '{$ID_MEMBER}'
					LIMIT 1", __FILE__, __LINE__);	
				}
				
				$request = db_query("
					SELECT COUNT(rt.id_image) as totals, mi.filename
						FROM {$db_prefix}rate_topic as rt
						LEFT JOIN {$db_prefix}message_icons as mi ON (rt.id_image = mi.ID_ICON)
						WHERE rt.id_msg = '{$_REQUEST['postId']}'
						GROUP BY rt.id_image
						ORDER BY totals DESC
						LIMIT 1", __FILE__, __LINE__);
				
				
				//New Icon?
				$newIcon = mysql_fetch_assoc($request);
				mysql_free_result($request);
				if($temp['icon'] != $newIcon['filename']){
					db_query("UPDATE {$db_prefix}messages
						SET icon='{$newIcon['filename']}'
						WHERE ID_MSG = '{$_REQUEST['postId']}'
						LIMIT 1", __FILE__, __LINE__);
				}
				
				$context['Rate_Topic']['confirmMsg'] = $txt['rateTopic']['post_rated'];
				
				//Recompile New Text Line date
				$request = db_query("
					SELECT ID_ICON, title, filename
					FROM {$db_prefix}message_icons", __FILE__, __LINE__);
				$context['topic_rate'] = array();
				while ($row = mysql_fetch_assoc($request))
					$context['topic_rate'][$row['ID_ICON']] = array(
						'title' => $row['title'],
						'image' => $row['filename']);
				mysql_free_result($request);
				$rateResult = db_query("
							SELECT *, COUNT(id_image) as totals
							FROM {$db_prefix}rate_topic
							WHERE id_msg = '{$_REQUEST['postId']}'
							GROUP BY id_image
							ORDER BY totals DESC
							", __FILE__, __LINE__);
				
				$context['Rate_nlt'] = array();
				while ($row = mysql_fetch_assoc($rateResult)){
					$context['Rate_nlt'][] = $row;
				}
				mysql_free_result($rateResult);
			}	
		}
		
		$context['sub_template'] = 'RateTopicSave';
		
	}elseif(isset($_REQUEST['userId'])){
		
		$_REQUEST['userId'] = (int) $_REQUEST['userId'];
		//Was Rated
		$rateResult = db_query("
				SELECT rt.*, COUNT(rt.id_image) as totals
				FROM {$db_prefix}rate_topic as rt
				JOIN {$db_prefix}message_icons as mi ON (rt.id_image = mi.ID_ICON)
				WHERE rt.id_to = '{$_REQUEST['userId']}'
				GROUP BY rt.id_image
				ORDER BY totals DESC
				", __FILE__, __LINE__);
	
		$context['Rate_Topic']['was_rated'] = array();
		while ($row = mysql_fetch_assoc($rateResult)){
			$context['Rate_Topic']['was_rated'][] = $row;
		}
		mysql_free_result($rateResult);
		
		//Gave Rated
		$rateResult = db_query("
				SELECT rt.*, COUNT(rt.id_image) as totals
				FROM {$db_prefix}rate_topic as rt
				JOIN {$db_prefix}message_icons as mi ON (rt.id_image = mi.ID_ICON)
				WHERE rt.id_from = '{$_REQUEST['userId']}'
				GROUP BY rt.id_image
				ORDER BY totals DESC
				", __FILE__, __LINE__);
	
		$context['Rate_Topic']['gave_rated'] = array();
		while ($row = mysql_fetch_assoc($rateResult)){
			$context['Rate_Topic']['gave_rated'][] = $row;
		}
		mysql_free_result($rateResult);
		
		//Rated From
		$rateResult = db_query("
				SELECT COUNT(rt.id_from) as totals, mem.realName
				FROM {$db_prefix}rate_topic as rt
				JOIN {$db_prefix}message_icons as mi ON (rt.id_image = mi.ID_ICON)
				JOIN {$db_prefix}members as mem ON (rt.id_from = mem.ID_MEMBER)
				WHERE rt.id_to = '{$_REQUEST['userId']}'
				GROUP BY rt.id_from
				ORDER BY totals DESC
				LIMIT 6
				", __FILE__, __LINE__);
	
		$context['Rate_Topic']['rated_from'] = array();
		while ($row = mysql_fetch_assoc($rateResult)){
			$context['Rate_Topic']['rated_from'][] = $row;
		}
		mysql_free_result($rateResult);
		
		//Rated To
		$rateResult = db_query("
				SELECT COUNT(rt.id_to) as totals, mem.realName
				FROM {$db_prefix}rate_topic as rt
				JOIN {$db_prefix}message_icons as mi ON (rt.id_image = mi.ID_ICON)
				JOIN {$db_prefix}members as mem ON (rt.id_to = mem.ID_MEMBER)
				WHERE rt.id_from = '{$_REQUEST['userId']}'
				GROUP BY rt.id_to
				ORDER BY totals DESC
				LIMIT 6
				", __FILE__, __LINE__);
	
		$context['Rate_Topic']['rated_to'] = array();
		while ($row = mysql_fetch_assoc($rateResult)){
			$context['Rate_Topic']['rated_to'][] = $row;
		}
		mysql_free_result($rateResult);
		
		$request = db_query("
		SELECT ID_ICON, title, filename
		FROM {$db_prefix}message_icons", __FILE__, __LINE__);
		
	$context['topic_rate'] = array();
	while ($row = mysql_fetch_assoc($request))
		$context['topic_rate'][$row['ID_ICON']] = array(
			'title' => $row['title'],
			'image' => preg_replace('/ /', '%20', $row['filename'])
			);
	mysql_free_result($request);
		
		$context['sub_template'] = 'RateTopicGet';
	
	}else{
		$context['Rate_Topic']['confirmMsg'] = $txt['rateTopic']['rate_failed'];
		$context['sub_template'] = 'RateTopicSave';
	}
}
?>