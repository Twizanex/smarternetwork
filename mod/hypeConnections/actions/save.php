<?php

admin_gatekeeper();
action_gatekeeper();

if (!get_input('guid')) {
    $connection_guid = NULL;
    $reverse_connection_guid = NULL;
} else {
    $connection_guid = get_input('guid');
    $reverse_connection_guid = get_entity($connection_guid)->reverse_guid;
}

// saving direct relationship
$connection_direction = 'direct';
$connection_type = get_input('connection_type');

$connection_origin = get_input('connection_origin');
$connection_target = get_input('connection_target');

$connection_name = get_input('connection_name');
$connection_reverse_name = get_input('connection_reverse_name');

if (!$connection_name)
    $connection_name = $connection_origin;
if (!$connection_reverse_name)
    $connection_reverse_name = $connection_target;

$connection_title = sanitise_string($connection_name . '-' . $connection_reverse_name);
$connection_limitation = get_input('connectlimitation');

$connection_direct = new ElggObject($connection_guid);
$connection_direct->subtype = 'connection';
$connection_direct->direction = $connection_direction;
$connection_direct->owner_guid = get_loggedin_userid();
$connection_direct->description = '';
$connection_direct->connection_type = $connection_type;
$connection_direct->title = $connection_title;
$connection_direct->direct_name = $connection_name;
$connection_direct->reverse_name = $connection_reverse_name;
$connection_direct->entity_origin = $connection_origin;
$connection_direct->entity_target = $connection_target;
$connection_direct->reverse_guid = $reverse_connection_guid;
$connection_direct->limitation = $connection_limitation;
$connection_direct->access_id = get_input('access_id');

$result = $connection_direct->save();

if ($result) {
    system_message(elgg_echo('hypeConnections:connectionsaved'));
} else {
    register_error(elgg_echo('hypeConnections:connectionnotsaved'));
}

//$reverse = get_input('reverse_relationship');
$reverse = 'yes';

if ($reverse == 'yes' && $connection_guid == NULL && $connection_name !== $connection_reverse_name) {

// saving reverse relationship
    $connection_direction = 'reverse';
    $connection_type = get_input('connection_type');
    if ($connection_type == 'u2o') $connection_type = 'o2u';
    $connection_target = get_input('connection_origin');
    $connection_origin = get_input('connection_target');

    $connection_reverse_name = get_input('connection_name');
    $connection_name = get_input('connection_reverse_name');

    if (!$connection_name)
        $connection_name = $connection_origin;
    if (!$connection_reverse_name)
        $connection_reverse_name = $connection_target;

    $connection_title = sanitise_string($connection_name . '-' . $connection_reverse_name);

    $connection_reverse = new ElggObject($reverse_connection_guid);
    $connection_reverse->subtype = 'connection';
    $connection_reverse->direction = $connection_direction;
    $connection_reverse->owner_guid = get_loggedin_userid();
    $connection_reverse->description = '';
    $connection_reverse->connection_type = $connection_type;
    $connection_reverse->title = $connection_title;
    $connection_reverse->direct_name = $connection_name;
    $connection_reverse->reverse_name = $connection_reverse_name;
    $connection_reverse->entity_origin = $connection_origin;
    $connection_reverse->entity_target = $connection_target;
    $connection_reverse->reverse_guid = $connection_direct->guid;
    if ($connection_origin == 'user') {
        $connection_reverse->limitation = $connection_limitation;
    } else {
        $connection_reverse->limitation = 0;
    }
    $connection_reverse->access_id = get_input('access_id');

    $result = $connection_reverse->save();

    if ($result) {
        system_message(elgg_echo('hypeConnections:revershypeConnectionsaved'));
    } else {
        register_error(elgg_echo('hypeConnections:reverseconnectionnotsaved'));
    }

    // saving reverse guid for new reverse relationship
    if ($reverse_connection_guid == NULL && result) {
        $connection_direct->reverse_guid = $connection_reverse->guid;
    }
}

forward($_SERVER['HTTP_REFERER']);
?>
