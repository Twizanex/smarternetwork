<?php

$performed_by_object = get_entity($vars['item']->subject_guid); // $statement->getSubject();
$performed_by = get_entity($performed_by_object->owner_guid);
$performed_on_object = get_entity($vars['item']->object_guid);
$performed_on = get_entity($performed_on_object->owner_guid);
$url = $performed_on->getURL();

$url_name1 = "<a href=\"{$performed_by->getURL()}\">" . $performed_by->name .'</a>';
$url_name2 = "<a href=\"{$performed_on->getURL()}\">" . $performed_on->name . '</a>';

$url_object1 = "<a href=\"{$performed_by_object->getURL()}\">" . $performed_by_object->title .'</a>';
$url_object2 = "<a href=\"{$performed_on_object->getURL()}\">" . $performed_on_object->title .'</a>';

$string = sprintf(elgg_echo('hypeConnections:river:o2o:add'), $url_name1, $url_object1, $url_name2, $url_object2) . ' ';
$string .= '<div class="river_content_display">';
$string .= elgg_get_excerpt($performed_on_object->description, 250);
$string .= '</div>';
?>

<?php
echo $string;
?>