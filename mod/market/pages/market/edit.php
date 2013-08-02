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

elgg_load_js('lightbox');
elgg_load_css('lightbox');

elgg_push_breadcrumb(elgg_echo('market:title'), "market/category");
//elgg_push_breadcrumb(elgg_echo("market:{$category}"), "market/category/{$category}");
elgg_push_breadcrumb(elgg_echo('market:edit'));
	elgg_push_breadcrumb($marketpost->title);
	
// Get the post, if it exists
$selected_category = get_input('cat'); //edit-4/14/2013

$market_guid = (int) get_input('guid');

//Experimental - begin
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

		$container_guid = (int) get_input('guid');
		$container = get_entity($container_guid);
		if (!$container) {
		
		}
		
		$parent_guid = 0;
		$item_owner = $container;
		if (elgg_instanceof($container, 'object')) {
			$parent_guid = $container->getGUID();
			$item_owner = $container->getContainerEntity();
		}
		
		elgg_set_page_owner_guid($item_owner->getGUID());
		
		//$title = elgg_echo('pages:add');
		elgg_push_breadcrumb($title);
		
		$vars = quebx_prepare_form_vars(null, $parent_guid);
		
// Experimental - end

//if ($post = get_entity($market_guid)) {
if ($post = get_entity($container_guid)) {
			
	if ($post->canEdit()) {
		if ($post->marketcategory == 'auction') {
			$title = elgg_echo('market:edit:auction');
			$form_vars = array('name' => 'auctionForm', 'js' => 'onsubmit="acceptTerms();return false;"', 'enctype' => 'multipart/form-data');
			$content = elgg_view_form("market/editauction", $form_vars, array('entity' => $post));
		} else {
			$title = elgg_echo('market:edit');
			$form_vars = array('name' => 'marketForm', 'js' => 'onsubmit="acceptTerms();return false;"', 'enctype' => 'multipart/form-data');
			$content = elgg_view_form("market/edit", $form_vars, array('entity' => $post));
		}			
	}
			
} else {

	$title = elgg_echo('market:none:found');
	$content = elgg_view("market/error");
}

// Show market sidebar
$sidebar = elgg_view("market/sidebar");
		
$params = array(
		'content' => $content,
		'title' => $title,
		'sidebar' => $sidebar,
		);

$body = elgg_view_layout('one_sidebar', $params);

echo elgg_view_page($title, $body);

