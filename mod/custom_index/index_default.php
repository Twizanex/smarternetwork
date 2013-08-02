<?php
/**
 * Elgg custom index page
 * 
 */

elgg_push_context('front');

elgg_push_context('widgets');

$list_params = array(
	'type' => 'object',
	'limit' => 4,
	'full_view' => false,
	'view_type_toggle' => false,
	'pagination' => false,
);

if (elgg_is_logged_in()) {
	forward('market');
}


$content = elgg_view_title(elgg_echo('content:latest'));
$content .= elgg_list_river();

$login_box = elgg_view('core/account/login_box');

$params = array(
		'content' => $content,
		'sidebar' => $login_box
);
$body = elgg_view_layout('one_sidebar', $params);

echo elgg_view_page(null, $body);
