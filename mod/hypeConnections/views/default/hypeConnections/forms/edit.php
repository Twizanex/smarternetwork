<?php

if (get_input('guid')) {
    $guid = get_input('guid');
    $connection = get_entity($guid);
}
$body = '';

$body .= '<label>' . elgg_echo('hypeConnections:label:connection_type') . '</label>';
$body .= elgg_view('input/pulldown', array(
            'internalname' => 'connection_type',
            'options_values' => array(
                'u2u' => 'User to User',
                'u2o' => 'User to Object',
                'o2u' => 'User to Object (reverse)',
                'o2o' => 'Object to Object'
            ),
            'value' => $connection->connection_type,
            'js' => 'onChange=getConnectionTypeObjects($(this))'
        ));

$u_origin = '<div id="connection_origin">' . elgg_view('input/pulldown', array(
            'internalname' => 'connection_origin',
            'options_values' => array(
                'user' => 'User',
            ),
            'value' => $connection->entity_origin
        )) . '</div>';

$u_target = '<div id="connection_target">' . elgg_view('input/pulldown', array(
            'internalname' => 'connection_target',
            'options_values' => array(
                'user' => 'User',
            ),
            'value' => $connection->entity_target
        )) . '</div>';

$subtypes = get_registered_entity_types('object');
foreach ($subtypes as $subtype) {
    $target_values[$subtype] = $subtype;
}
$o_origin = '<div id="connection_origin">' . elgg_view('input/pulldown', array(
            'internalname' => 'connection_origin',
            'options_values' => $target_values,
            'value' => $connection->entity_origin
        )) . '</div>';

$o_target = '<div id="connection_target">' . elgg_view('input/pulldown', array(
            'internalname' => 'connection_target',
            'options_values' => $target_values,
            'value' => $connection->entity_target
        )) . '</div>';

//$body .= '<label>' . elgg_echo('hypeConnections:label:connection_id') . '</label>';
//$body .= elgg_view('input/text', array(
//            'internalname' => 'connection_id',
//            'value' => $connection->title
//        ));

$body .= '<label>' . elgg_echo('hypeConnections:label:connection_name') . '</label>';
$body .= elgg_view('input/text', array(
            'internalname' => 'connection_name',
            'value' => $connection->direct_name
        ));

$body .= '<label>' . elgg_echo('hypeConnections:label:connection_reverse_name') . '</label>';
$body .= elgg_view('input/text', array(
            'internalname' => 'connection_reverse_name',
            'value' => $connection->reverse_name
        ));

$body .= '<label>' . elgg_echo('hypeConnections:label:connection_origin') . '</label>';
if ($connection->connection_type == 'o2u' || $connection->connection_type == 'o2o') {
    $body .= $o_origin;
} elseif ($connection->connection_type == 'u2u' || $connection->connection_type == 'u2o' || !$connection) {
    $body .= $u_origin;
}

$body .= '<label>' . elgg_echo('hypeConnections:label:connection_target') . '</label>';
if ($connection->connection_type == 'o2u' || $connection->connection_type == 'u2u' || !$connection) {
    $body .= $u_target;
} elseif  ($connection->connection_type == 'u2o' || $connection->connection_type == 'o2o') {
    $body .= $o_target;
}

$body .= '<label>' . elgg_echo('hypeConnections:label:connectlimitations') . '</label><br>';
if (!$connection->limitation) {
    $limitation = 0;
} else {
    $limitation = $connection->limitation;
}
$body .= elgg_view('input/text', array(
            'internalname' => 'connectlimitation',
            'value' => $limitation,
        ));

//$body .= '<label>' . elgg_echo('hypeConnections:label:createreverse') . '</label><br>';
//$body .= elgg_view('input/radio', array(
//            'internalname' => 'reverse_relationship',
//            'options' => array(
//                'yes' => 'Yes',
//                'no' => 'No'
//            )
//        ));

$body .= '<label>' . elgg_echo('hypeConnections:label:accesslevel') . '</label>';
$body .= elgg_view('input/access', array('internalname' => 'access_id', 'value' => $connection->access_id));
$body .= elgg_view('input/securitytoken');
$body .= elgg_view('input/hidden', array('value' => $guid, 'internalname' => 'guid'));

$body .= elgg_view('input/submit', array('value' => 'Save'));

$extras = '';
$extras .= '<div id="u_origin">' . $u_origin . '</div>';
$extras .= '<div id="u_target">' . $u_target . '</div>';
$extras .= '<div id="o_origin">' . $o_origin . '</div>';
$extras .= '<div id="o_target">' . $o_target . '</div>';
$extras = '<div style="display:none">' . $extras . '</div>';

$body = elgg_view('input/form', array(
            'body' => $body,
            'action' => $vars['url'] . 'action/connection/save'
        ));

echo $body;
echo $extras;
?>
