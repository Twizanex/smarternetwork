<?php

admin_gatekeeper();

set_context('admin');

$title = elgg_echo('hypeConnections:admintitle');
$header = elgg_view_title($title);

$body = elgg_view('hypeConnections/js/canvas');
$body .= elgg_view('hypeConnections/admin/canvas');
$body = elgg_view('page_elements/contentwrapper', array('body' => $body));

$body = elgg_view_layout('two_column_left_sidebar', '', $header . $body, '');

page_draw($title, $body);

?>
