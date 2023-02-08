<h3>Overview of what had been changed:</h3>

<li>There were couple of typos in the code which are fixed</li>
<li>The $showfeedback variable in groups_delete_group_memebers() function was not being used and amended the code accordingly to consider that for the output</li>
<li>The database queries where repeating for deleting members. We don't need to check and grab the member ids first and then delete them. Instead I changed the code to just request deleting members from table regardless of existing or not. If $userid is not 0 then that single member will be deleted from the group and if 0 all members will be deleted from group.</li>
<li>Added feedback to $OUTPUT</li>
