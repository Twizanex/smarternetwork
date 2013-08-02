<?php

if (isloggedin ()) {
    $origin_entity = $vars['entity'];
    if (isset($vars['connection_type'])) {
        $connection_type = $vars['connection_type'];
    } else {
        $connection_type = 'u2u';
    }

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
                $section = array();
                $section['header'] = sprintf(elgg_echo('hypeConnections:connectionssubsection'), $connection->reverse_name) . ': ';

                foreach ($relationships as $id => $relationship) {
                    if ($relationship->relationship == $connection->title) {
                        $target_entity = get_entity($relationship->guid_two);
                        $section['items'][] = $target_entity;
                    }
                }
                if (!empty($section['items'])) {
                    echo '<div class="profile_connection_summary">';
                    echo '<div class="summary_section_header left">' . $section['header'] . '</div>';
                    foreach ($section['items'] as $item) {
                        if ($item->title) {
                            $item_name = $item->title;
                        } else {
                            $item_name = $item->name;
                        }
                        echo '<div class="summary_section_item left"><a href="' . $item->getURL() . '">' . $item_name . '</a></div>';
                    }
                    echo '<div class="clearfloat"></div></div>';
                }
            }
        }
    }
}
?>