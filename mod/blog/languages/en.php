<?php
/**
 * Blog English language file.
 *
 */

$english = array(
	'blog' => 'Journals',
	'blog:blogs' => 'Journals',
	'blog:revisions' => 'Revisions',
	'blog:archives' => 'Archives',
	'blog:blog' => 'Journal',
	'item:object:blog' => 'Journals',

	'blog:title:user_blogs' => '%s\'s journal entries',
	'blog:title:all_blogs' => 'All journals',
	'blog:title:friends' => 'Friends\' journals',


	'blog:group' => 'Group journal',
	'blog:enableblog' => 'Enable group journal',
	'blog:write' => 'Write a journal post',

	// Editing
	'blog:add' => 'New journal entry',
	'blog:edit' => 'Edit journal entry',
	'blog:excerpt' => 'Excerpt',
	'blog:body' => 'Body',
	'blog:save_status' => 'Last saved: ',
	'blog:never' => 'Never',

	// Statuses
	'blog:status' => 'Status',
	'blog:status:draft' => 'Draft',
	'blog:status:published' => 'Published',
	'blog:status:unsaved_draft' => 'Unsaved Draft',

	'blog:revision' => 'Revision',
	'blog:auto_saved_revision' => 'Auto Saved Revision',

	// messages
	'blog:message:saved' => 'journal entry saved.',
	'blog:error:cannot_save' => 'Cannot save journal entry.',
	'blog:error:cannot_write_to_container' => 'Insufficient access to save journal to group.',
	'blog:error:post_not_found' => 'This post has been removed, is invalid, or you do not have permission to view it.',
	'blog:messages:warning:draft' => 'There is an unsaved draft of this post!',
	'blog:edit_revision_notice' => '(Old version)',
	'blog:message:deleted_post' => 'journal entry deleted.',
	'blog:error:cannot_delete_post' => 'Cannot delete journal entry.',
	'blog:none' => 'No journal entries',
	'blog:error:missing:title' => 'Please enter a journal title!',
	'blog:error:missing:description' => 'Please enter the body of your journal!',
	'blog:error:cannot_edit_post' => 'This post may not exist or you may not have permissions to edit it.',
	'blog:error:revision_not_found' => 'Cannot find this revision.',

	// river
	'river:create:object:blog' => '%s published a journal entry %s',
	'river:comment:object:blog' => '%s commented on the journal %s',

	// notifications
	'blog:newpost' => 'A new journal entry',
	'blog:notification' =>
'
%s made a new journal entry.

%s
%s

View and comment on the new journal entry:
%s
',

	// widget
	'blog:widget:description' => 'Display your latest journal entries',
	'blog:moreblogs' => 'More journal entries',
	'blog:numbertodisplay' => 'Number of journal entries to display',
	'blog:noblogs' => 'No journal entries'
);

add_translation('en', $english);
