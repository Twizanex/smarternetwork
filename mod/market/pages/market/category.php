<?php
/**
 * Elgg Market Plugin
 * @package market
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author slyhne
 * @copyright slyhne 2010-2011
 * @link www.zurf.dk/elgg
 * @version 1.8
 */

// Get input
$selected_category = get_input('cat');

if ($selected_category == 'all') {
	$category = '';
} elseif ($selected_category == '') {
	$category = '';
	$selected_category = 'all';
} else {
	$category = $selected_category;
}
elgg_set_context('market');

elgg_pop_breadcrumb();

//quebx_register_title_button(null, $selected_category);

$name = $selected_category;
$button_action = 'add';

//Experimental - begin
		$item_guid = get_input('guid');
		$item = get_entity($item_guid);
		
		//elgg_set_page_owner_guid($item->getContainerGUID());
		
		$container = elgg_get_page_owner_entity();
		if (!$container) {
		}
		
		$title = $item->title;
		
			$url = "market/$button_action/$item->guid";
			elgg_register_menu_item('title', array(
					'name' => 'subpage',
					'href' => $url,
					'text' => elgg_echo('pages:newchild'),
					'link_class' => 'elgg-button elgg-button-action',
			));
//Experimental - end

if ($selected_category != 'auto') // list categories having custom forms
{elgg_register_title_button();}
else {
	if (elgg_is_logged_in()) {

		if (!$handler) {
			$handler = elgg_get_context();
		}

		$owner = elgg_get_page_owner_entity();
		if (!$owner) {
			// no owns the page so this is probably an all site list page
			$owner = elgg_get_logged_in_user_entity();
		}
		if ($owner && $owner->canWriteToContainer()) {
			$guid = $owner->getGUID();
			elgg_register_menu_item('title', array(
				'name' => $name,
				'href' => "$handler/$name/$guid",
				'text' => elgg_echo("$handler:$button_action:$name"),
				'link_class' => 'elgg-button elgg-button-action',
			));
		}
	}
}
$tabs = elgg_view('market/menu', array('category' => $selected_category));


//set market title
$title = sprintf(elgg_echo('market:category:title'), elgg_echo("market:{$selected_category}"));

$num_items = 16;  // 0 = Unlimited

$options = array(
	'types' => 'object',
	'subtypes' => 'market',
	'limit' => $num_items,
	'full_view' => false,
	'pagination' => true,
//	'view_type_toggle' => true, //depricated in 1.8
	'list_type' => 'list',
	'list_type_toggle' => true,
);

// Get a list of market posts in a specific category
if (!empty($category)) {
	elgg_push_breadcrumb(elgg_echo('market:title'), "market/category");
	elgg_push_breadcrumb(elgg_echo("market:{$category}"));
	$options['metadata_name'] = "marketcategory";
	$options['metadata_value'] = $selected_category;
	$content = elgg_list_entities_from_metadata($options);
} else {
	elgg_push_breadcrumb(elgg_echo('market:title'));
	$content = elgg_list_entities($options);
}

if (!$content) {
	$content = elgg_echo('market:none:found');
}

// Show market sidebar
$sidebar = elgg_view("market/sidebar");

$params = array(
		'filter' => $tabs,
		'content' => $content,
		'title' => $title,
		'sidebar' => $sidebar,
		);

$body = elgg_view_layout('content', $params);
	
echo elgg_view_page($title, $body);

