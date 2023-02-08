<?php

/**
 * Remove all users (or one user) from all groups in course
 * @param int $courseid
 * @param int $suerid 0 means all users
 * @param bool $showfeedback
 * @return bool success
 */
function groups_delete_group_memebers(int $courseid, int $userid = 0, bool $showfeedback = false)
{
    global $DB, $OUTPUT;

    $results = [];

    $groups = $DB->get_recordset('groups', array('courseid' => $courseid));
    foreach ($groups as $group) {
        $results[] = groups_remove_member($group->id, $userid);
    }


    // checking to see if we had failure in removing members from any groups in the course
    $failure = in_array(false, $results);

    if($showfeedback) {
        $OUTPUT = [
          'status' => $failure ? 'failed' : 'successful',
          'message' => $failure ? 'Some members failed to be removed from course' : 'Members successfully removed from course',
        ];
    }

    // if we had any failure then it would return false
    return !$failure;
}

/**
 * Deletes the link between the specified user and group.
 *
 * @param int $groupid The groupid
 * @param int $userid 0 means all users
 * @return bool True if deletion was successful, false otherwise
 */
function groups_remove_member(int $groupid, int $userid = 0)
{
    global $DB;

    $params = ['groupid' => $groupid];
    if($userid != 0) {
        $params = array_merge($params, ['userid' => $userid]);
    }
    try {
        $DB->delete_records('groups_members', $params);
    } catch (Exception $e) {
        return false;
    }

    return true;
}
