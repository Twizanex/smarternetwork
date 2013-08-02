<?php

gatekeeper();
action_gatekeeper();

if (get_input('direct_connection_guid') !== '0') {
    $direct_connection_guid = get_input('direct_connection_guid');
    $direct_connection = get_entity($direct_connection_guid);
    $reverse_connection_guid = $direct_connection->reverse_guid;
    $reverse_connection = get_entity($reverse_connection_guid);

    $origin_guid = get_input('origin_guid');
    $origin_entity = get_entity($origin_guid);

    $target_guid = get_input('target_guid');
    $target_entity = get_entity($target_guid);

    $direct_limit_check = 0;
    $reverse_limit_check = 0;

    $direct_relationships = get_entity_relationships($origin_guid);
    $reverse_relationships = get_entity_relationships($target_guid);

    if (is_array($direct_relationships) && sizeof($direct_relationships)) {
        foreach ($direct_relationships as $id => $relationship) {
            if ($relationship->relationship == $direct_connection->title) {
                $direct_limit_check++;
            }
        }
    }
    if (is_array($reverse_relationships) && sizeof($reverse_relationships)) {
        foreach ($reverse_relationships as $id => $relationship) {
            if ($relationship->relationship == $reverse_connection->title) {
                $reverse_limit_check++;
            }
        }
    }

    if (($direct_limit_check < (int) $direct_connection->limitation
            && $reverse_limit_check < (int) $reverse_connection->limitation)
            || ((int) $direct_connection->limitation == 0
            && (int) $reverse_connection->limitation == 0)) {
        add_entity_relationship($origin_guid, $direct_connection->title, $target_guid);
        if ($origin_entity instanceof ElggUser && $target_entity instanceof ElggUser) {
            $subject = sprintf(elgg_echo('hypeConnections:newrel:notification:subject'));
            $message = sprintf(elgg_echo('hypeConnections:newrel:notification:message'), $origin_entity->name, $direct_connection->reverse_name);
            notify_user($target_entity->guid, $origin_entity->guid, $subject, $message);
            add_to_river('hypeConnections/relationship/river/u2u', 'create', $origin_entity->guid, $target_entity->guid);


            // add global user collection
            $collection_global_name = elgg_echo('hypeConnections:allconnections');
            $collection_global_direct = check_collection($origin_entity->guid, $collection_global_name);
            if (!$collection_global_direct) {
                $collection_global_direct = create_access_collection($collection_global_name, $origin_entity->guid);
            }
            add_user_to_access_collection($target_entity->guid, $collection_global_direct);

            $collection_global_reverse = check_collection($target_entity->guid, $collection_global_name);
            if (!$collection_global_reverse) {
                $collection_global_reverse = create_access_collection($collection_global_name, $target_entity->guid);
            }
            add_user_to_access_collection($origin_entity->guid, $collection_global_reverse);

            //Individual collections
            $collection_direct_name = sprintf(elgg_echo('hypeConnections:connection'), $direct_connection->reverse_name);
            $collection_direct = check_collection($origin_entity->guid, $collection_direct_name);
            if (!$collection_direct) {
                $collection_direct = create_access_collection($collection_direct_name, $origin_entity->guid);
            }
            add_user_to_access_collection($target_entity->guid, $collection_direct);

            $collection_reverse_name = sprintf(elgg_echo('hypeConnections:connection'), $direct_connection->direct_name);
            $collection_reverse = check_collection($target_entity->guid, $collection_reverse_name);
            if (!$collection_reverse) {
                $collection_reverse = create_access_collection($collection_reverse_name, $target_entity->guid);
            }
            add_user_to_access_collection($origin_entity->guid, $collection_reverse);

        } elseif ($origin_entity instanceof ElggUser && $target_entity instanceof ElggObject) {
            $subject = sprintf(elgg_echo('hypeConnections:newobjrel:notification:subject'));
            $message = sprintf(elgg_echo('hypeConnections:newobjrel:notification:message'), $origin_entity->name, $direct_connection->direct_name, $target_entity->title);
            notify_user($target_entity->owner_guid, $origin_entity->guid, $subject, $message);
            add_to_river('hypeConnections/relationship/river/u2o', 'create', $origin_entity->guid, $target_entity->guid);
        } elseif ($origin_entity instanceof ElggObject && $target_entity instanceof ElggUser) {
            $subject = sprintf(elgg_echo('hypeConnections:newobjrel:notification:subject'));
            $message = sprintf(elgg_echo('hypeConnections:newobjrel:notification:message'), $target_entity->name, $direct_connection->reverse_name, $origin_entity->title);
            notify_user($origin_entity->owner_guid, $target_entity->guid, $subject, $message);
            add_to_river('hypeConnections/relationship/river/o2u', 'create', $target_entity->guid, $origin_entity->guid);
        } elseif ($origin_entity instanceof ElggObject && $target_entity instanceof ElggObject) {
            add_to_river('hypeConnections/relationship/river/o2o', 'create', $origin_entity->guid, $target_entity->guid);
        }
        add_entity_relationship($target_guid, $reverse_connection->title, $origin_guid);
        system_message(elgg_echo('hypeConnections:savesuccess'));
    } else {
        register_error(sprintf(elgg_echo('hypeConnections:limitexceeded'), $direct_connection->title));
    }
} else {
    register_error(elgg_echo('hypeConnections:mustselect'));
}
forward($_SERVER['HTTP_REFERER']);
?>
