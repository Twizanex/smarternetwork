<?php
/**
 * Adapted from Pages function library
 */

/**
 * Prepare the add/edit form variables
 * Experimental - Altered pages_prepare_form_vars() for QuebX
 *
 * @param ElggObject $page
 * @return array
 */
function quebx_prepare_form_vars($item = null, $parent_guid = 0) {

	// input names => defaults
	$values = array(
		'title' => '',
		'description' => '',
		'access_id' => ACCESS_DEFAULT,
		'write_access_id' => ACCESS_DEFAULT,
		'tags' => '',
		'container_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
		'entity' => $item,
		'parent_guid' => $parent_guid,
	);

	if ($item) {
		foreach (array_keys($values) as $field) {
			if (isset($item->$field)) {
				$values[$field] = $item->$field;
			}
		}
	}

	if (elgg_is_sticky_form('market')) {
		$sticky_values = elgg_get_sticky_values('market');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('market');

	return $values;
}