<?php

/**
* Remove all users (or one user) from all groups in course
* @param int $courseid
* @param int $suerid 0 means all users
* @param bool $hidefeedback
* @return bool success
*/
function groups_delete_group_memebers($courseid, $userid=0, $showfeedback=false) {
	global $DB, $OUTPUT;
	$allusers = false;

	$groups = $DB->get_recordset('groups', array('courseid' => $courseid));
	foreach ($groups as $group) {
    	    if ($userid) {
        	$userids = array($userid);
    	    } else {
        	$params = array('groupid' => $group->id);
        	$userid = $DB->get_fieldset_select('groups_members',
                	'userid',
                	'groupid = :groupid',
                	$params);
    	    }
    	    foreach ($userids as $id) {
        	groups_remove_member($group, $id);
    	    }
	}
	return true;
}

/**
 * Deletes the link between the specified user and group.
 *
 * @param  	mixed $groupid  The groupid
 * @param  	mixed $userid   The userid
 * @return bool True if deletion was successful, false otherwise
 */
function groups_remove_member($groupid, $userid) {
	global $DB;

	$params = array('groupid' => $groupid, 'userid' => $userid);
	if (!$DB->record_exists('group_members', $params)) {
    	    return true;
	}

	$DB->delete_records('groups_members', $params);
	return true;
}
