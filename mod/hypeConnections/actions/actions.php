<?php

$action = get_input('action_type');
$return = elgg_view('hypeFramework/ajax/metatags');

switch ($action) {

    case 'new':
        $return .= elgg_view('hypeConnections/forms/edit');
        break;

    case 'edit':
        $return .= elgg_view('hypeConnections/forms/edit', array('guid' => get_input('guid')));
        break;

    case 'connect_form':
        $return .= elgg_view('hypeConnections/forms/connect', array('origin_guid' => get_input('origin_guid'), 'target_guid' => get_input('target_guid')));
        break;

    case 'object_connect_form':
        $return .= elgg_view('hypeConnections/forms/object_connect', array('origin_guid' => get_input('origin_guid')));
        //echo elgg_view('hypeConnections/forms/connect', array('origin_guid' => get_input('origin_guid'), 'target_guid' => get_input('target_guid')));
        break;
}

echo $return;
die();
?>
