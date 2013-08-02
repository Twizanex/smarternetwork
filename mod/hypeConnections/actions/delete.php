<?php

admin_gatekeeper();
action_gatekeeper();

$guid = get_input('guid');
$connection = get_entity($guid);

if ($connection->canEdit()) {
    if ($connection instanceof ElggObject) {
        $result = $connection->delete();
    }
    if ($result)
        system_message(elgg_echo('hypeConnections:deletesuccess'));
} else {
    register_error(elgg_echo('hypeApprove:noprivileges'));
}

forward($_SERVER['HTTP_REFERER']);
?>
