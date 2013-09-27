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

elgg_register_event_handler('init','system','market_init');

function market_init() {

     // Register libraries of helper functions
     elgg_register_library('elgg:market', elgg_get_plugins_path() . 'market/lib/market.php');
     elgg_register_library('elgg:market:navigation', elgg_get_plugins_path() . 'market/lib/navigation.php');
     elgg_register_library('elgg:market:views', elgg_get_plugins_path() . 'market/lib/views.php');

	// Add a site navigation item
	$item = new ElggMenuItem('market', elgg_echo('market:title'), 'market/category');
	elgg_register_menu_item('site', $item);

	// Extend owner block menu
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'market_owner_block_menu');
	elgg_register_plugin_hook_handler('register', 'menu:page', 'market_page_menu');

	// Extend system CSS with our own styles
	elgg_extend_view('css/elgg','market/css');
	elgg_extend_view('css/admin','market/admincss');

     // Register javascript needed for sidebar menu
     $js_url = 'mod/pages/vendors/jquery-treeview/jquery.treeview.min.js';
     elgg_register_js('jquery-treeview', $js_url);
     $css_url = 'mod/pages/vendors/jquery-treeview/jquery.treeview.css';
     elgg_register_css('jquery-treeview', $css_url);

	// Add a new widget
	elgg_register_widget_type(
			'market',
			elgg_echo('market:widget'),
			elgg_echo('market:widget:description')
			);

	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('market','market_page_handler');

	// Initialize a pagesetup for menus
	elgg_register_event_handler('pagesetup','system','market_pagesetup');

	// Override the default url to view a market post
	elgg_register_entity_url_handler('object', 'market', 'market_url_handler');

	// Register entity type
	elgg_register_entity_type('object','market');

	// Register actions - call actions with a trailing '/' to prevent 301 redirects
	$action_url = elgg_get_plugins_path() . "market/actions/";
	elgg_register_action("market/add/", "{$action_url}add.php");
	elgg_register_action("market/quick/", "{$action_url}quick.php");
	elgg_register_action("market/edit/", "{$action_url}edit.php");
	elgg_register_action("market/edit_more/", "{$action_url}edit_more.php");
	elgg_register_action("market/edit/auto/", "{$action_url}edit/auto.php");
	elgg_register_action("market/delete/", "{$action_url}delete.php");
	elgg_register_action("market/add/auto/", "{$action_url}add/auto.php");
	elgg_register_action("market/clone", "{$action_url}clone.php");
	//	elgg_register_action("market/[action]/[category]/", "{$action_url}/[action]/[category].php");
}

// market page handler; allows the use of fancy URLs
function market_page_handler($page) {

     elgg_load_library('elgg:market');
     elgg_load_library('elgg:market:navigation');
     elgg_load_library('elgg:market:views');

     // add the jquery treeview files for navigation
     elgg_load_js('jquery-treeview');
     elgg_load_css('jquery-treeview');

	$pages = dirname(__FILE__) . '/pages/market';

	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	$page_type = $page[0];
	switch ($page_type) {
		case 'owned':
			set_input('username', $page[1]);
			include "$pages/owned.php";
			break;
		case 'friends':
			set_input('username' , $page[1]);
			include "$pages/friends.php";
			break;
		case 'view':
			set_input('marketpost', $page[1]);
			include "$pages/view.php";
			break;
		case 'add':
			gatekeeper();
			include "$pages/add/add.php";
			break;
		case 'edit_more':
		  gatekeeper();
		  include "$pages/edit_more.php";
		  break;
		case 'auto':
			gatekeeper();
			include "$pages/add/auto.php";
			break;
/*		case '[[category]]':
			gatekeeper();
			include "$pages/[[category]].php";
			break;
*/		case 'quick':
			gatekeeper();
			include "$pages/quick.php";
			break;
		case 'edit':
			gatekeeper();
			set_input('guid', $page[1]);
			include "$pages/edit.php";
			break;
		case 'edit/auto':
			gatekeeper();
			set_input('guid', $page[1]);
			include "$pages/edit/auto.php";
			break;
		case 'category':
			set_input('cat', $page[1]);
			include "$pages/category.php";
			break;
		case 'file':
			set_input('guid', $page[1]);
			set_input('time', $page[2]);
			set_input('name', $page[3]);
			include "$pages/file.php";
			return true;
			break;
		default:
			include "$pages/category.php";
			break;
	}

}

// Populates the ->getURL() method for market objects
function market_url_handler($entity) {

	if (!$entity->getOwnerEntity()) {
		// default to a standard view if no owner.
		return FALSE;
	}

	$friendly_title = elgg_get_friendly_title($entity->title);

	return "market/view/{$entity->guid}/{$friendly_title}";

}

// Add to the user block menu
function market_owner_block_menu($hook, $type, $return, $params) {

	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "market/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('market', elgg_echo('market'), $url);
		$return[] = $item;
	}

	return $return;

}
/**
 * Add a page menu menu.
 *
 * @param string $hook
 * @param string $type
 * @param array  $return
 * @param array  $params
 */
function market_page_menu($hook, $type, $return, $params) {
	if (elgg_is_logged_in()) {
		// only show buttons in market pages
		if (elgg_in_context('market')) {
			$user = elgg_get_logged_in_user_entity();
			$page_owner = elgg_get_page_owner_entity();
			if (!$page_owner) {
				$page_owner = elgg_get_logged_in_user_entity();
			}

			if ($page_owner != $user) {
				$usertitle = elgg_echo('market:user', array($page_owner->name));
				$return[] = new ElggMenuItem('1user', $usertitle, 'market/owned/' . $page_owner->username);
				$friendstitle = elgg_echo('market:user:friends', array($page_owner->name));
				$return[] = new ElggMenuItem('2userfriends', $friendstitle, 'market/friends/' . $page_owner->username);
			}

			$return[] = new ElggMenuItem('1all', elgg_echo('market:everyone'), 'market');
			$return[] = new ElggMenuItem('4friends', elgg_echo('market:friends'), 'market/friends/' . $user->username);
			$return[] = new ElggMenuItem('3mine', elgg_echo('market:mine'), 'market/owned/' . $user->username);

		}
	}

	return $return;
}


function cars_user_picker_callback($query, $options = array()) {
	
	// this is the guid of the market entity
	// we don't actually need it for this
	$id = sanitize_int(get_input('id'));
	
	// replace mysql vars with escaped strings
    $q = str_replace(array('_', '%'), array('\_', '\%'), sanitize_string($query));
	
	$dbprefix = elgg_get_config('dbprefix');
	return elgg_get_entities(array(
		'type' => 'user',
		'joins' => array(
			"JOIN {$dbprefix}users_entity ue ON ue.guid = e.guid",
		),
		'wheres' => array(
			"ue.username LIKE '%{$q}%' OR ue.name LIKE '%{$q}%'",
		),
		'order_by' => 'ue.name ASC'
	));
}



function cars_shoe_picker_callback($query, $options = array()) {
	
	// this is the guid of the market entity
	// we don't actually need it for this
	$id = sanitize_int(get_input('id'));
	
	// replace mysql vars with escaped strings
    $q = str_replace(array('_', '%'), array('\_', '\%'), sanitize_string($query));
	
	$shoes_id = add_metastring('shoes');
	$marketcat_id = add_metastring('marketcategory');
	
	$dbprefix = elgg_get_config('dbprefix');
	return elgg_get_entities(array(
		'type' => 'object',
		'subtypes' => array('market'),
		'joins' => array(
			"JOIN {$dbprefix}objects_entity oe ON oe.guid = e.guid",
			"JOIN {$dbprefix}metadata md ON md.entity_guid = e.guid AND md.name_id = {$marketcat_id} AND md.value_id = {$shoes_id}"
		),
		'wheres' => array(
			"oe.title LIKE '%{$q}%' OR oe.description LIKE '%{$q}%'",
		),
		'order_by' => 'oe.title ASC'
	));
}