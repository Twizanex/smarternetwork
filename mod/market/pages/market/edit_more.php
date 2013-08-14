<?php
/**
 * Elgg Market Plugin
 * @package market
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine
 * @copyright 2008-2013 Arck Interactive, LLC
 * @link http://arckinteractive.com
 * @version 1.8
 *
 * Adds information to a newly created item
 */

elgg_load_js('lightbox');
elgg_load_css('lightbox');

$guid = $page[1];
//$hierarchy = array('category','family','parent','individual','element');
//$struct = '';
$h = '';
for($i=2;$i<=6;$i++) {
  if (isset($page[$i])) {
    //$struct .= $hierarchy[$i-2];
    $h .= "/".$page[$i];
  } else {
    break;
  }
}

elgg_push_breadcrumb(elgg_echo('market:title'), "market/category");
elgg_push_breadcrumb(elgg_echo('market:add_more'));

if (elgg_get_plugin_setting('market_adminonly', 'market') == 'yes') {
	admin_gatekeeper();
}

//count_user_objects() was deprecated in favor of elgg_get_entities()
//$marketactive = count_user_objects(elgg_get_logged_in_user_guid(), 'market');
$marketactive = elgg_get_entities(elgg_get_logged_in_user_guid(), 'market');

$title = elgg_echo('market:add_more');

// use multipart/form-data in case any of the forms provide file fields
// and always use the market/edit_more action regardless of the form
$form_vars = array('name' => 'marketForm', 'enctype' => 'multipart/form-data', 'action'=>'action/market/edit_more');
$body_vars = array('guid' => $guid, 'h'=>$h);
$content = elgg_view_form("market/edit".$h, $form_vars, $body_vars);

// Show market sidebar
$sidebar = elgg_view("market/sidebar");

$params = array(
		'content' => $content,
		'title' => $title,
		'sidebar' => $sidebar,
		);

$body = elgg_view_layout('one_sidebar', $params);

echo elgg_view_page($title, $body);
