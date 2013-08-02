<?php

$origin_entity = $vars['entity'];
$connection_type = $vars['connection_type'];

$options = array(
    'types' => 'object',
    'subtypes' => 'connection',
    'metadata_names' => 'connection_type',
    'metadata_values' => $connection_type,
    'limit' => 9999
);

$relationships = get_entity_relationships($origin_entity->guid);
$connections = elgg_get_entities_from_metadata($options);

if (is_array($connections) && sizeof($connections) > 0) {
    if (is_array($relationships) && sizeof($relationships) > 0) {
        foreach ($connections as $connection) {
            $section_header = elgg_view_title(sprintf(elgg_echo('hypeConnections:connectionssubsection'), $connection->reverse_name));
            $section = '';
            foreach ($relationships as $id => $relationship) {
                if ($relationship->relationship == $connection->title) {
                    $target_entity = get_entity($relationship->guid_two);
                    if ($origin_entity->canEdit()) {
                        $url = $vars['url'] . 'action/connection/disconnect?origin=' . $origin_entity->guid . '&target=' . $target_entity->guid . '&id=' . $relationship->id;
                        $url = elgg_add_action_tokens_to_url($url);
                        $section .= '<div class="disconnectButton right">' . elgg_view('output/confirmlink', array(
                                    'text' => elgg_echo('hypeConnections:disconnectbutton'),
                                    'confirm' => elgg_echo('hypeConnections:disconnectconfirm'),
                                    'href' => $url
                                )) . '</div>';
                    }
                    $context = get_context();
                    set_context('search');
                    $section .= elgg_view_entity($target_entity, false);
                    $section .= '<div class="clearfloat"></div>';
                    set_context($context);
                }
            }
            if (!empty($section)) {
                echo $section_header . $section;
            }
        }
    }
}
?>
<?php echo elgg_view('hypeConnections/page/elements/adminlinks', $vars);?>
