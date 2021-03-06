<?php
$entity = $vars['entity'];

$title = $entity->title;
$description = elgg_get_excerpt($vars['entity']->description, 00);

$icon = elgg_view("profile/icon", array('entity' => $entity, 'size' => 'small'));

$types = get_registered_entity_types('object');
$counters = '';

foreach ($types as $type) {
    $objects = get_filed_items_by_type($vars['entity']->guid, 'object', $type);
    if (in_array($type, string_to_tag_array(get_plugin_setting('allowed_object_types', 'hypeCategories')))) {
        $count = 0;
        if (is_array($objects)) $count = count($objects);
        if ($count > 0) {
            $counters .= '<span class="type_counters" style="padding-right:10px">' . elgg_echo('item:object:' . $type) . ': <b>' . $count . '</b></span> ';
    }}
}
?>

<div class="search_listing">
    <div class="search_listing_icon"><?php echo $icon; ?></div>
    <div class="search_listing_info">
        <p class="item_title"><a href="<?php echo $entity->getURL() ?>"><?php echo $title; ?></a></p>
        <p class="item_description"><?php echo $description; ?></p>
        <p class="item_counters"><?php echo $counters ?></p>
    </div>
</div>