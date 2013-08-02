<?php

$origin_entity = $vars['entity'];

if ($origin_entity instanceof ElggUser) {
    echo elgg_view('hypeConnections/page/elements/summary', array('entity' => $origin_entity, 'connection_type' => 'u2u'));
    echo elgg_view('hypeConnections/page/elements/summary', array('entity' => $origin_entity, 'connection_type' => 'u2o'));
} else {
    if (isset($vars['connection_type'])) {
        echo elgg_view('hypeConnections/page/elements/summary', array('entity' => $origin_entity, 'connection_type' => $vars['connection_type']));
        echo elgg_view('hypeConnections/page/elements/adminlinks', array('entity' => $origin_entity, 'connection_type' => $vars['connection_type']));
    } else {
        echo elgg_view('hypeConnections/page/elements/summary', array('entity' => $origin_entity, 'connection_type' => 'o2u'));
        echo elgg_view('hypeConnections/page/elements/summary', array('entity' => $origin_entity, 'connection_type' => 'o2o'));
        echo elgg_view('hypeConnections/page/elements/adminlinks', array('entity' => $origin_entity, 'connection_type' => 'o2u'));
    }
}
?>