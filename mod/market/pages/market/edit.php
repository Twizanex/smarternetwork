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

if (elgg_get_plugin_setting('market_adminonly', 'market') == 'yes') {
	admin_gatekeeper();
}

$guid = (int) get_input('guid');
$marketpost = get_entity($guid);
$title = elgg_echo('market:edit');

if(elgg_instanceof($marketpost,'object','market') && $marketpost->canEdit()) {

  elgg_push_breadcrumb(elgg_echo('market:title'), "market/category");
  //elgg_push_breadcrumb(elgg_echo("market:{$category}"), "market/category/{$category}");
  elgg_push_breadcrumb(elgg_echo('market:edit'));
  elgg_push_breadcrumb($marketpost->title);

  $form_vars = array('name' => 'marketForm', 'enctype' => 'multipart/form-data');
  // set up sticky form

  $body_vars = array(
      'entity' => $marketpost,
      'markettitle' => $marketpost->title,
      'marketbody' => $marketpost->description,
      'markettags' => $marketpost->tags,
      'access_id' => $marketpost->access_id,
      'marketcategory' => $marketpost->marketcategory,
  );
  if (elgg_is_sticky_form('market')) {
  		$sticky_values = elgg_get_sticky_values('market');
  		foreach ($sticky_values as $key => $value) {
  			$body_vars[$key] = $value;
  		}
  }

  elgg_clear_sticky_form('market');

  $content = elgg_view_form("market/edit", $form_vars, $body_vars);

} else {
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
