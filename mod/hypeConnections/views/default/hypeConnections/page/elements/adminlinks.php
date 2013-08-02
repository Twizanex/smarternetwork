<?php
if (isloggedin ()) {
    $origin_entity = $vars['entity'];

    if ($origin_entity instanceof ElggObject) {
        $connection_type = 'o2u';
        $options = array(
            'type' => 'object',
            'subtype' => 'connection',
            'metadata_name_value_pairs' => array(array('name' => 'connection_type', 'value' => $connection_type),
                array('name' => 'entity_origin', 'value' => $origin_entity->getSubtype())),
        );

        $connections = elgg_get_entities_from_metadata($options);
        if ($connections && get_context() !== 'connections') {
            $show_manager = true;
?>
            <div class="user_menu_connect left margined" origin_guid="<?php echo $origin_entity->guid ?>" target_guid="<?php echo get_loggedin_userid() ?>">
                <p class="user_menu_connections">
                    <a class="button" href="javascript:void(0)"><?php echo elgg_echo('hypeConnections:objectmenu:connect') ?></a>
                </p>
            </div>
<?php
        }

        $connection_type = 'o2o';
        $options = array(
            'types' => 'object',
            'subtypes' => 'connection',
            'metadata_name_value_pairs' => array(array('name' => 'connection_type', 'value' => $connection_type),
                array('name' => 'entity_origin', 'value' => $origin_entity->getSubtype())),
        );

        $connections = elgg_get_entities_from_metadata($options);
        if ($connections && $origin_entity->canEdit() && get_context() !== 'connections') {
            $show_manage = true;
?>
            <div class="user_menu_connect left  margined" origin_guid="<?php echo $origin_entity->guid ?>" target_guid="">
                <p class="user_menu_connections">
                    <a class="button" href="javascript:void(0)"><?php echo elgg_echo('hypeConnections:objectmenu:linkobject') ?></a>
                </p>
            </div>
<?php
        }
        if ($show_manage && $origin_entity->canEdit() && get_context() !== 'connections') {
?>
            <div class="left margined">
                <a class="button" href="<?php echo $vars['url'] ?>pg/connections/view/<?php echo $origin_entity->guid ?>"><?php echo elgg_echo('hypeConnections:objectmenu:manage') ?></a>
            </div>

<?php
        }
    }

    if ($origin_entity instanceof ElggUser) {
        if ($vars['connection_type'] !== 'u2o') {
            $options = array(
                'types' => 'object',
                'subtypes' => 'connection',
                'metadata_names' => 'connection_type',
                'metadata_values' => 'u2u'
            );

            $connections = elgg_get_entities_from_metadata($options);

            if ($connections && get_loggedin_userid() !== $vars['entity']->guid && get_context() !== 'connections') {
?>
                <div class="user_menu_connect left margined" origin_guid="<?php echo get_loggedin_userid() ?>" target_guid="<?php echo $vars['entity']->guid ?>">
                    <p >
                        <a class="button" href="javascript:void(0)"><?php echo elgg_echo('hypeConnections:usermenu:connect'); ?></a>
                    </p>
                </div>
<?php
            }
        }
    }
?>
    <div class="clearfloat"></div>
<?php
}
?>