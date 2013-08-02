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

$section_header = '<div id="subnavigation_items_container">';
$section_header .= '<ul id="subnavigation_items" class="subnavigation_items">';

if (is_array($connections) && sizeof($connections) > 0) {
    if (is_array($relationships) && sizeof($relationships) > 0) {
        foreach ($connections as $connection) {

            $section_header .= '<li ref="' . $connection->guid . '" class="subnavigation_item"><a href="#tab_' . $connection->guid . '" >' . sprintf(elgg_echo('hypeConnections:connectionssubsection'), $connection->reverse_name) . '</a></li>';

            $section .= '<div id="tab_' . $connection->guid . '" ref="' . $connection->guid . '" class="subnavigation_content">';
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

                    $section .= elgg_view_entity($target_entity);
                }
            }
            $section .= elgg_view('hypeConnections/page/elements/adminlinks', $vars);
            $section .= '</div>';
        }
    }
}
$section_header .= '</ul>';
echo $section_header . $section;
echo '</div>';
?>
