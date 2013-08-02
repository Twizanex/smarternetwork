<?php
$options = array(
    'types' => 'object',
    'subtypes' => 'connection',
    'metadata_names' => 'connection_type',
    'metadata_values' => 'u2u',
    'count' => true
);

$connections = elgg_get_entities_from_metadata($options);

if ($connections > 0 && get_loggedin_userid() !== $vars['entity']->guid) {
?>
<div class="user_menu_connect right" origin_guid="<?php echo get_loggedin_userid() ?>" target_guid="<?php echo $vars['entity']->guid ?>">
        <div class="button" >
            <a href="javascript:void(0)"><?php echo elgg_echo('hypeConnections:usermenu:connect'); ?></a>
        </div>
    </div>
<?php } ?>