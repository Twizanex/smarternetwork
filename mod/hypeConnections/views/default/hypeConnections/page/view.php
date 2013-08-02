<?php

global $CONFIG;

$origin_guid = get_input('origin_guid');
$origin_entity = get_entity($origin_guid);

if ($origin_entity instanceof ElggUser)
    set_page_owner($origin_guid);

if ($origin_entity->title) {
    $origin_title = $origin_entity->title;
} else {
    $origin_title = $origin_entity->name;
}
if ($origin_entity instanceof ElggUser) {
    $title = sprintf(elgg_echo('hypeConnections:userconnections'), $origin_title);
    $header = elgg_view_title($title);

    $body = elgg_view('hypeConnections/page/showconnections', array('entity' => $origin_entity, 'connection_type' => 'u2u'));
    $body = elgg_view('page_elements/contentwrapper', array('body' => $body));

    $title1 = sprintf(elgg_echo('hypeConnections:userlinks'), $origin_title);
    $header1 = elgg_view_title($title1);

    $body1 = elgg_view('hypeConnections/page/showconnections', array('entity' => $origin_entity, 'connection_type' => 'u2o'));
    $body1 = elgg_view('page_elements/contentwrapper', array('body' => $body1));
} else {
    $title = sprintf(elgg_echo('hypeConnections:objectconnections'), $origin_title);
    $header = elgg_view_title($title);

    $body = elgg_view('hypeConnections/page/showconnections', array('entity' => $origin_entity, 'connection_type' => 'o2u'));
    $body = elgg_view('page_elements/contentwrapper', array('body' => $body));

    $title1 = sprintf(elgg_echo('hypeConnections:objectlinks'), $origin_title);
    $header1 = elgg_view_title($title1);

    $body1 = elgg_view('hypeConnections/page/showconnections', array('entity' => $origin_entity, 'connection_type' => 'o2o'));
    $body1 = elgg_view('page_elements/contentwrapper', array('body' => $body1));
}

$body = elgg_view_layout('two_column_left_sidebar', $area1, $header . $body . $header1 . $body1, '');

page_draw($title . $title1, $body);
?>
