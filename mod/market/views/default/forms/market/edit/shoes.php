<?php
// example family level form
$family = array(
    'dress' => elgg_echo('market:family:shoes:dress'),
    'running'=>elgg_echo('market:family:shoes:running'),
);
$color = array('brown','black','white','blue','red');
$size = array(4,5,6,7,8,9,10,12,13,14,15);

$guid = $vars['guid'];
$entity = get_entity($guid);
if (elgg_instanceof($entity, 'object','market')) {
  // must always supply $guid $h (current hierarchy) and current $level (in this case family)
  echo elgg_view('input/hidden', array('name'=>'guid','value'=>$guid));
  echo elgg_view('input/hidden', array('name'=>'h','value'=>$vars['h']));
  echo elgg_view('input/hidden', array('name'=>'level','value'=>'family'));
  $items = array();

  // fields for this level
  // notice that the field names are wrapped by item (eg. item[size])
  // to make it easier for the edit_more action to process them

  // family
  $label= elgg_echo('market:edit_more:shoes:family:label');
  $field = elgg_view('input/dropdown',array('name'=>'item[family]','value'=>$entity->family,'options_values' => $family));
  $items[] = array('label'=>$label,'field' => $field);

  // color
  $label = elgg_echo('market:edit_more:shoes:color:label');
  $field = elgg_view('input/dropdown',array('name'=>'item[color]','value'=>$entity->color,'options' => $color));
  $items[] = array('label'=>$label,'field' => $field);

  // size
  $label = elgg_echo('market:edit_more:shoes:size:label');
  $field = elgg_view('input/dropdown',array('name'=>'item[size]','value'=>$entity->size,'options' => $size));
  $items[] = array('label'=>$label,'field' => $field);

  // now that we have defined the fields, we can spit them out in a loop

  foreach ($items as $item) {
    echo '<p><label>'.$item['label'] . ' ' . $item['field'] . '</label></p>';
  }

  // TODO: we might consider having more than one button here - cancel, save, save and add more
  echo '<div class="elgg-foot">'.elgg_view('input/submit',array('value'=>elgg_echo('submit'))).'</div>';

} else {
  echo elgg_echo('market:edit_more:invalid_guid');
}
