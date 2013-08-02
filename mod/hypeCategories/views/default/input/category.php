<?php
if (!$vars['entity']) {
    $current_category = NULL;
} else {
    $current_category = get_item_categories($vars['entity']->guid);
}

if (in_array('company', string_to_tag_array(get_plugin_setting('allowed_object_types', 'hypeCategories')))) {
    echo elgg_view('hypeCategories/forms/assign', array('current_category' => $current_category)) . '<br>';
}
?>
