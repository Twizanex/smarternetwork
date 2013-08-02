<?php

gatekeeper();
action_gatekeeper();

$origin_guid = get_input('origin');
$origin_entity = get_entity($origin_guid);

$target_guid = get_input('target');
$target_entity = get_entity($target_guid);

$relationship_id = get_input('id');
$relationship = get_relationship($relationship_id);

$connections = elgg_get_entities(array(
            'types' => 'object',
            'subtypes' => 'connection',
        ));

foreach ($connections as $test_con) {
    if ($test_con->title == $relationship->relationship) {
        $direct_connection = $test_con;
    }
}

$reverse_connection_guid = $direct_connection->reverse_guid;
$reverse_connection = get_entity($reverse_connection_guid);

$reverse_relationships = get_entity_relationships($target_guid);

foreach ($reverse_relationships as $id => $test_rel) {
    if ($test_rel->relationship == $reverse_connection->title && $test_rel->guid_two == $origin_entity->guid) {
        $reverse_relaitonship_id = $test_rel->id;
    }
}
$collection_global_name = elgg_echo('hypeConnections:allconnections');
$collection_direct_name = sprintf(elgg_echo('hypeConnections:connection'), $direct_connection->reverse_name);
$collection_reverse_name = sprintf(elgg_echo('hypeConnections:connection'), $direct_connection->direct_name);

$collection_global_direct = check_collection($origin_entity->guid, $collection_global_name);
$collection_global_reverse = check_collection($target_entity->guid, $collection_global_name);
$collection_direct = check_collection($origin_entity->guid, $connection_direct_name);
$collection_reverse = check_collection($target_entity->guid, $collection_reverse_name);

if ($result = delete_relationship($reverse_relaitonship_id)) {
    remove_user_from_access_collection($target_entity->guid, $collection_global_direct);
    remove_user_from_access_collection($target_entity->guid, $collection_direct);
    system_message(elgg_echo('hypeConnections:reversedisconnectsuccess'));
}

if ($result = delete_relationship($relationship_id)) {
    remove_user_from_access_collection($origin_entity->guid, $collection_global_reverse);
    remove_user_from_access_collection($origin_entity->guid, $collection_reverse);
    system_message(elgg_echo('hypeConnections:disconnectsuccess'));
}

forward($_SERVER['HTTP_REFERER']);
?>
