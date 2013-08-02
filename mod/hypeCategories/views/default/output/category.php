<?php
if (get_context() !== 'category') {
    $category_guid = get_item_categories($vars['entity']->guid);
    if ($category_guid) {
        $category = get_entity($category_guid);
        $check = true;
        while ($check) {
            if ((int) $category->level !== 1) {
                $category = get_parent($category->guid);
            } else {
                $check = false;
            }
        }
        $url = $category->getURL();
        echo '<a href="' . $url . '">' . elgg_echo($category->title) . '</a>';
    }
}
?>
