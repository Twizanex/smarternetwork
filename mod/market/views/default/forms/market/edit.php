<?php
/**
 * Elgg Market Plugin
 * @package market
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author slyhne
 * @copyright slyhne 2010-2011
 * @link www.zurf.dk/elgg
 * @version 1.8
 *
 * Modified by Kevin Jardine for arckinteractive.com
 */

// Get plugin settings
$allowhtml = elgg_get_plugin_setting('market_allowhtml', 'market');
$numchars = elgg_get_plugin_setting('market_numchars', 'market');
if($numchars == ''){
	$numchars = '250';
}

$title = $vars['markettitle'];
$body = $vars['marketbody'];
$tags = $vars['markettags'];
$category = $vars['marketcategory'];
$access_id = $vars['access_id'];

?>
<script type="text/javascript">
function textCounter(field,cntfield,maxlimit) {
	// if too long...trim it!
	if (field.value.length > maxlimit) {
		field.value = field.value.substring(0, maxlimit);
	} else {
		// otherwise, update 'characters left' counter
		$("#"+cntfield).html(maxlimit - field.value.length);
	}
}
function acceptTerms() {
	error = 0;
	if(!(document.marketForm.accept_terms.checked) && (error==0)) {
		alert('<?php echo elgg_echo('market:accept:terms:error'); ?>');
		document.marketForm.accept_terms.focus();
		error = 1;
	}
	if(error == 0) {
		document.marketForm.submit();
	}
}
</script>
<?php
echo "<label>";
echo elgg_echo("title");
echo "&nbsp;<small><small>" . elgg_echo("market:title:help") . "</small></small><br />";
echo elgg_view("input/text", array(
				"name" => "markettitle",
				"value" => $title,
				));
echo "</label></p>";

$marketcategories = elgg_view('market/marketcategories',$vars);
if (!empty($marketcategories)) {
	echo "<p>{$marketcategories}</p>";
}

echo "<p><label>" . elgg_echo("market:text") . "<br>";
if ($allowhtml != 'yes') {
	echo "<small><small>" . sprintf(elgg_echo("market:text:help"), $numchars) . "</small></small><br />";
	echo <<<HTML
<textarea name='marketbody' class='mceNoEditor' rows='8' cols='40'
  onKeyDown='textCounter(document.marketForm.marketbody,"market-remLen1",{$numchars}'
  onKeyUp='textCounter(document.marketForm.marketbody,"market-remLen1",{$numchars})'>{$body}</textarea><br />
HTML;
	echo "<div class='market_characters_remaining'><span id='market-remLen1' class='market_charleft'>{$numchars}</span> " . elgg_echo("market:charleft") . "</div>";
} else {
	echo elgg_view("input/longtext", array("name" => "marketbody", "value" => $body));
}
echo "</label></p>";

echo "<p><label>" . elgg_echo("market:image") . "<br />";
echo elgg_view('market/thumbnail', array('marketguid' => $vars['entity']->guid, 'size' => 'large', 'tu' => $vars['entity']->time_updated));
echo "<br /></label></p>";

echo "<p><label>" . elgg_echo("market:uploadimages") . "<br /><small><small>" . elgg_echo("market:imagelimitation") . "</small></small><br />";
echo elgg_view("input/file",array('name' => 'upload'));
echo "</label></p>";

echo "<p><label>" . elgg_echo("market:tags") . "&nbsp;<small><small>" . elgg_echo("market:tags:help") . "</small></small><br />";
echo elgg_view("input/tags", array(
				"name" => "markettags",
				"value" => $tags,
				));
echo "</label></p>";

echo "<p><label>" . elgg_echo('access') . "&nbsp;<small><small>" . elgg_echo("market:access:help") . "</small></small><br />";
echo elgg_view('input/access', array('name' => 'access_id','value' => $access_id));
echo "</label></p>";

echo "<p>";
// Terms checkbox and link
/* 07/06/2012 - Removed terms from form
 * $termslink = elgg_view('output/url', array(
			'href' => "mod/market/terms.php",
			'text' => elgg_echo('market:terms:titl	e'),
			'class' => "elgg-lightbox",
			));
$termsaccept = sprintf(elgg_echo("market:accept:terms"),$termslink);
echo "</p>";
echo "<input type='checkbox' name='accept_terms'><label>{$termsaccept}</label></p>";
*/
if ($vars['entity']) {
  echo elgg_view('input/hidden',array('name'=>'guid','value'=>$vars['entity']->guid));
}
echo elgg_view('input/submit', array('name' => 'submit', 'text' => elgg_echo('market:save'), 'value' => elgg_echo('market:save')));


