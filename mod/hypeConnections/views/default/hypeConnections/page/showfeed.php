<?php

$company = $vars['entity'];
$relationships = get_entity_relationships($company->guid);
$subject_guids = array($company->owner_guid);

if (is_array($relationships) && sizeof($relationships) > 0) {
    foreach($relationships as $id => $relationship) {
        $subject_guids[] = $relationship->guid_two;
    }
}

echo elgg_view_river_items($subject_guids);


?>
