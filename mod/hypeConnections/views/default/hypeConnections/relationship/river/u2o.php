<?php

$performed_by = get_entity($vars['item']->subject_guid); // $statement->getSubject();
$performed_on = get_entity($vars['item']->object_guid);
$url = $performed_on->getURL();

$url = "<a href=\"{$performed_by->getURL()}\">" . $performed_by->name .'</a>';
$string = sprintf(elgg_echo('hypeConnections:river:u2o:add'), $url) . ' ';
$string .= "<a href=\"{$performed_on->getURL()}\">" . $performed_on->title . '</a>';
$string .= '<div class="river_content_display">';
$string .= elgg_get_excerpt($performed_on->description, 250);
$string .= '</div>';
?>

<?php
echo $string;
?>