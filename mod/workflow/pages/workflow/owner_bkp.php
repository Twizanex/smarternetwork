<?php
/**
 *	Elgg-workflow plugin
 *	@package elgg-workflow
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-workflow
 *
 *	Elgg-workflow owner board view
 *
 */


$user = elgg_get_logged_in_user_entity();
elgg_set_page_owner_guid($user->getGUID());

if (!$user || $user->type != 'user') {
	forward('workflow/owner/' . $user->guid);
}

// access check for closed user boards
gatekeeper();

elgg_push_breadcrumb($user->name);

elgg_register_menu_item('title', array(
	'name' => 'add_list',
	'href' => '#add-list',
	'rel' => 'popup',
	'text' => elgg_echo('workflow:add_list'),
	'link_class' => 'elgg-button elgg-button-action',
));

$title = elgg_echo('workflow:owner', array($user->name));

$lists = elgg_get_entities(array(
	'type' => 'object',
	'subtypes' => 'workflow_list',
	'container_guid' => $user->guid,
	'limit' => 0
));

$sorted_lists = array();
foreach ($lists as $list) {
	$sorted_lists[$list->order] = $list;
}
ksort($sorted_lists);

$num_lists = count($lists);

// add the card popup and add-list popup
$addlist = '<div id="add-list" class="elgg-module elgg-module-popup hidden">' . elgg_view_form('workflow/list/add_list_popup') . '</div>';
$content .= $addlist . "<div id='workflow-card-popup' class='elgg-module elgg-module-popup hidden mbl'></div>";

$content .= "<div class='workflow-lists-container'><div class='workflow-lists'>";
foreach ($sorted_lists as $sorted_list) {
	$content .= elgg_view_entity($sorted_list, array('view_type' => 'group'));
}
$content .= "</div></div>";

if (!$lists) {
	$content = $addlist . '<div class="workflow-lists-container"><p>' . elgg_echo('workflow:list:none') . '</p></div>';
}

$params = array(
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
);
/*
if (elgg_instanceof($owner, 'group')) {
	$params['filter'] = '';
}
*/
$body = elgg_view_layout('workflow', $params);

echo elgg_view_page($title, $body);
