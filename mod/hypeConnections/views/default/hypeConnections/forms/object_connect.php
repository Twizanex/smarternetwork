<?php
$origin_guid = $vars['origin_guid'];
$origin_entity = get_entity($origin_guid);

if ($origin_entity instanceof ElggObject) {
    $connection_type = 'o2o';
    $origin_entity_subtype = $origin_entity->getSubtype();
}

$options = array(
    'types' => 'object',
    'subtypes' => 'connection',
    'metadata_name_value_pairs' => array(array('name' => 'connection_type', 'value' => $connection_type),
            array('name' => 'entity_origin', 'value' => $origin_entity_subtype)),
    'limit' => 9999
);

$connections = elgg_get_entities_from_metadata($options);
$subtypes = array();
if (is_array($connections) && sizeof($connections) > 0) {
    foreach ($connections as $connection) {
        if (!in_array($connection->entity_target, $subtypes)) {
            $subtypes[] = $connection->entity_target;
        }
        $relationships = get_entity_relationships($origin_entity);
        if (is_array($relationships) && sizeof($relationships) > 0) {
            foreach ($relationships as $id => $relationship) {
                if (get_entity($relationship->guid_two) instanceof ElggUser) {
                    $relationship_users[] = $relationship->guid_two;
                }
            }
        }
    }
}

$collection = check_collection($origin_entity->owner_guid, elgg_echo('hypeConnections:allconnections'));
$collection_users = get_members_of_access_collection($collection, true);

$user_objects = elgg_get_entities(array(
            'types' => 'object',
            'subtypes' => $subtypes,
            'owner_guids' => array($origin_entity->owner_guid),
            'limit' => 9999));

$user_connections_objects = elgg_get_entities(array(
            'types' => 'object',
            'subtypes' => $subtypes,
            'owner_guids' => $collection_users,
            'limit' => 9999));

$object_connections_objects = elgg_get_entities(array(
            'types' => 'object',
            'subtypes' => $subtypes,
            'owner_guids' => $relationship_users,
            'limit' => 9999
        ));

$user_objects_dropdown = array('0' => 'Select...');
if (is_array($user_objects)) {
    foreach ($user_objects as $object) {
        $user_objects_dropdown[$object->guid] = $object->getSubtype() . ': ' . $object->title;
    }
}

$user_connections_objects_dropdown = array('0' => 'Select...');
if (is_array($user_connections_objects)) {
    foreach ($user_connections_objects as $object) {
        $user_connections_objects_dropdown[$object->guid] = $object->getSubtype() . ': ' . $object->title;
    }
}

$object_connections_objects_dropdown = array('0' => 'Select...');
if (is_array($object_connections_objects)) {
    foreach ($object_connections_objects as $object) {
        $object_connections_objects_dropdown[$object->guid] = $object->getSubtype() . ': ' . $object->title;
    }
}
?>

<div id="populateObjectConnections" origin_guid="<?php echo $origin_entity->guid ?>">
    <div id="sectionDropdown">
        <?php
        echo '<label>' . elgg_echo('hypeConnections:selectsectiondropdown') . '</label>';
        echo elgg_view('input/pulldown', array(
            'internalname' => 'sectionDropdown',
            'options_values' => array(
                '0' => 'Select...',
                'you' => elgg_echo('hypeConnections:youritems'),
                'collection' => elgg_echo('hypeConnections:itemscollection'),
                'object' => sprintf(elgg_echo('hypeConnections:itemsobjectconnections'), $origin_entity->title)
            ),
            'js' => 'onchange=getObjectsDropdown($(this))'
        ));
        echo '<label>' . elgg_echo('hypeConnections:selectobjectdropdown') . '</label>';
        ?>

    </div>

    <div id="objectsDropdown">
        <?php
        //echo elgg_view('input/pulldown', array(
        //    'internalname' => 'objectDropdown',
        //    'options' => array(
        //        '0' => 'Select the group first...',
        //    'js' => 'selectmenu=false'
        //    )
        //));
        ?>
    </div>
</div>
<div id="populationExtras">
    <div id="you_options" style="display:none">
        <?php
        echo elgg_view('input/pulldown', array(
            'internalname' => 'objectDropdown',
            'options_values' => $user_objects_dropdown,
            'js' => 'onchange=passTargetGuid($(this)) selectmenu=false'
        ));
        ?>
    </div>
    <div id="collection_options" style="display:none">
        <?php
        echo elgg_view('input/pulldown', array(
            'internalname' => 'objectDropdown',
            'options_values' => $user_connections_objects_dropdown,
            'js' => 'onchange=passTargetGuid($(this)) selectmenu=false'
        ));
        ?>
    </div>
    <div id="object_options" style="display:none">
        <?php
        echo elgg_view('input/pulldown', array(
            'internalname' => 'objectDropdown',
            'options_values' => $object_connections_objects_dropdown,
            'js' => 'onchange=passTargetGuid($(this)) selectmenu=false'
        ));
        ?>
    </div>
</div>