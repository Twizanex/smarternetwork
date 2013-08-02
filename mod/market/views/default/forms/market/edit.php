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

$object = $vars['entity'];
// Get plugin settings
$allowhtml = elgg_get_plugin_setting('market_allowhtml', 'market');
$currency = elgg_get_plugin_setting('market_currency', 'market');
$numchars = elgg_get_plugin_setting('market_numchars', 'market');
if($numchars == ''){
	$numchars = '250';
}

// Set title, form destination
if (isset($vars['entity'])) {
	$title = sprintf(elgg_echo("market:editpost"),$object->title);
	$action = "market/edit";
	$tu = $marketpost->time_updated;
	$title = $vars['entity']->title;
	if ($allowhtml != 'yes') {
		$body = strip_tags($vars['entity']->description);
	} else {
		$body = $vars['entity']->description;
	}
	$price = $vars['entity']->price;
	$custom = $vars['entity']->custom;
	$tags = $vars['entity']->tags;
	$access_id = $vars['entity']->access_id;
	// Added 04/14/2013
		$title = $vars['entity']->title;
		$category = $vars['entity']->category;
		$manufacturer = $vars['entity']->manufacturer;
		$brand = $vars['entity']->brand;
		$model = $vars['entity']->model;
		$part = $vars['entity']->part;	
		$collection = $vars['entity']->collection;
		$warranty = $vars['entity']->warranty;
		$warrantor = $vars['entity']->warrantor;
		$owner = $vars['entity']->owner;
		$lifecycle = $vars['entity']->lifecycle;
		$quantity = $vars['entity']->quantity;
		$length = $vars['entity']->length;
		$width = $vars['entity']->width;
		$height = $vars['entity']->height;
		$weight = $vars['entity']->weight;
		$features = $vars['entity']->features;
		$modelyear = $vars['entity']->modelyear;
		$drive = $vars['entity']->drive;
		$displacement = $vars['entity']->displacement;
		$cylinders = $vars['entity']->cylinders;
		$horsepower = $vars['entity']->horsepower;
		$transmission = $vars['entity']->transmission;
		$torque = $vars['entity']->torque;
		$tires = $vars['entity']->tires;
		$mpg = $vars['entity']->mpg;
		$fuel = $vars['entity']->fuel;
		$bore = $vars['entity']->bore;
		$stroke = $vars['entity']->stroke;
		$wheelbase = $vars['entity']->wheelbase;
		$legroom = $vars['entity']->legroom;
		$headroom = $vars['entity']->headroom;
		$cargocapacity = $vars['entity']->cargocapacity;
		$towingcapacity = $vars['entity']->towingcapacity;
		$payloadcapacity = $vars['entity']->payloadcapacity;
		$location = $vars['entity']->location;
		$serial01 = $vars['entity']->serial01;
		$serial02 = $vars['entity']->serial02;
		$colorexterior = $vars['entity']->colorexterior;
		$colorinterior = $vars['entity']->colorinterior;
		$vin = $vars['entity']->vin;
		$sku = $vars['entity']->sku;
		
}

// Just in case we have some cached details
if (isset($vars['markettitle'])) {
	$title = $vars['markettitle'];
	$body = $vars['marketbody'];
	$price = $vars['marketprice'];
	$custom = $vars['marketcustom'];
	$tags = $vars['markettags'];
	// Added 04/14/2013
		$title= $vars['markettitle'];
		$category= $vars['marketcategory'];
		$manufacturer= $vars['marketmanufacturer'];
		$brand= $vars['marketbrand'];
		$model= $vars['marketmodel'];
		$part= $vars['marketpart'];
//		$description= $vars['marketdescription'];
		$collection= $vars['marketcollection'];
		$warranty= $vars['marketwarranty'];
		$warrantor= $vars['marketwarrantor'];
		$owner= $vars['marketowner'];
		$lifecycle= $vars['marketlifecycle'];
		$quantity= $vars['marketquantity'];
		$length= $vars['marketlength'];
		$width= $vars['marketwidth'];
		$height= $vars['marketheight'];
		$weight= $vars['marketweight'];
		$features= $vars['marketfeatures'];
		$modelyear = get_input('marketmodelyear');
		$drive= $vars['marketdrive'];
		$displacement= $vars['marketdisplacement'];
		$cylinders= $vars['marketcylinders'];
		$horsepower= $vars['markethorsepower'];
		$transmission= $vars['markettransmission'];
		$torque= $vars['markettorque'];
		$tires= $vars['markettires'];
		$mpg= $vars['marketmpg'];
		$fuel= $vars['marketfuel'];
		$bore= $vars['marketbore'];
		$stroke= $vars['marketstroke'];
		$wheelbase= $vars['marketwheelbase'];
		$legroom= $vars['marketlegroom'];
		$headroom= $vars['marketheadroom'];
		$cargocapacity= $vars['marketcargocapacity'];
		$towingcapacity= $vars['markettowingcapacity'];
		$payloadcapacity= $vars['marketpayloadcapacity'];
		$location= $vars['marketlocation'];
		$serial01= $vars['marketserial01'];
		$serial02= $vars['marketserial02'];
		$colorexterior= $vars['marketcolorexterior'];
		$colorinterior= $vars['marketcolorinterior'];
// Added 04/07/2013
		$vin= $vars['marketvin'];
		$sku = get_input('marketsku');
}

?>
<script type="text/javascript">
function textCounter(field,cntfield,maxlimit) {
	// if too long...trim it!
	if (field.value.length > maxlimit) {
		field.value = field.value.substring(0, maxlimit);
	} else {
		// otherwise, update 'characters left' counter
		cntfield.value = maxlimit - field.value.length;
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

if($category=='auto'){
	/*echo elgg_view("input/hidden", array(
					"name" => "marketcategory",
					"value" => 'auto',
					));*/
	echo $category."<label>".elgg_echo("quebx:asset_title")."</label><br>";
	echo elgg_view("input/text", array(
					"name" => "markettitle",
					"value" => $title,
					));


			//Experimental - begin
			$url = "../../market/add/$category/$guid";
			elgg_register_menu_item('title', array(
					'name' => 'subpage',
					'href' => $url,
					'text' => elgg_echo('pages:newchild'),
					'link_class' => 'elgg-button elgg-button-action',
					));
    echo "<a href='".$url."'>".elgg_echo('pages:newchild')."</a>";	

			//Experimental - end
	echo "<p>";
	echo "<DIV><table width = 100%>";
	echo "<tr><td name = 1>";
	echo elgg_echo("quebx:asset_manufacturer");
	echo "</td><td name = 2>";
	echo elgg_echo("quebx:asset_brand");
	echo "</td><td name = 3>";
	echo elgg_echo("quebx:asset_model");
	echo "</td><td name = 4>";
	echo elgg_echo("quebx:asset_modelyear");
	echo "</td></tr>";
	
	echo "<tr><td name = 1>";
	echo elgg_view("input/text", array(
					"name" => "marketmanufacturer",
					"value" => $manufacturer,
					));
	echo "</td><td name = 2>";
	echo elgg_view("input/text", array(
					"name" => "marketbrand",
					"value" => $brand,
					));
	echo "</td><td name = 3>";
	echo elgg_view("input/text", array(
					"name" => "marketmodel",
					"value" => $model,
					));
	echo "</td><td name = 4>";
	echo elgg_view("input/text", array(
					"name" => "marketmodelyear",
					"value" => $modelyear,
					));
	echo "</td></tr>";
	
	echo "<tr><td name = 1>";
	echo "</td><td name = 2>";
	echo "</td><td name = 3>";
	echo "</td><td name = 4>";
	echo "</td></tr>";
	echo "<tr><td colspan=4><br>".elgg_echo("quebx:asset_description")."</td>";
	echo "</tr><tr>";
	echo "<td colspan=4>";
	if ($allowhtml != 'yes') {
		echo "<small><small>" . sprintf(elgg_echo("market:text:help"), $numchars) . "</small></small><br />";
		echo "<textarea name='marketbody' class='mceNoEditor' rows='8' cols='40' onKeyDown='textCounter(document.marketForm.marketbody,document.marketForm.remLen1,{$numchars}' onKeyUp='textCounter(document.marketForm.marketbody,document.marketForm.remLen1,{$numchars})'>{$body}</textarea><br />";
		echo "<div class='market_characters_remaining'><input readonly type='text' name='remLen1' size='3' maxlength='3' value='{$numchars}' class='market_charleft'>" . elgg_echo("market:charleft") . "</div>";
	} else {
		echo elgg_view("input/longtext", array("name" => "marketbody", "value" => $body));
	}
	echo "</td></tr>";
	echo "</table></div>";
	
	echo "<td width='220px'>";
	echo "<p><label>" . elgg_echo("market:image") . "<br /><center>";
	echo elgg_view('market/thumbnail', array('marketguid' => $object->guid, 'size' => 'large', 'tu' => $tu));
	echo "</center><br /></label></p>";
	echo "</td><tr></table>";
	
	echo "<div><label>Family Characteristics</label></div>";
	echo "<div><table WIDTH=100%>";
	echo "<tr><td WIDTH=20%>";
	echo elgg_echo("quebx:auto_drive");
	echo "</td><td WIDTH=80%>";
	echo elgg_view("input/text", array(
					"name" => "marketdrive",
					"value" => $drive,
					));
	echo "</td></tr>";
	echo "<tr><td>".elgg_echo("quebx:auto_displacement")."</td>";
	echo "<td>";
	echo elgg_view("input/text", array(
					"name" => "marketdisplacement",
					"value" => $displacement,
					));
	echo "</td></tr>";
	echo "</table></div>";
	
	echo "<div><label>Individual Characteristics</label><br>This section will (eventually) allow users to enter multiple individual items in the same family.</div>";
	echo "<div><table WIDTH=100%>";
	echo "<tr><td WIDTH=10% name = 1>";
	echo elgg_echo("quebx:asset_sku");
	echo "</td><td WIDTH=20% name = 2>";
	echo elgg_echo("quebx:asset_location");
	echo "</td><td WIDTH=35% name = 3>";
	echo elgg_echo("quebx:auto_vin");
	echo "</td><td width=35% name = 4>";
	echo elgg_echo("quebx:asset_serial02");
	echo "</td></tr>";
	echo "<tr><td name = 1>";
	echo elgg_view("input/text", array(
					"name" => "marketsku",
					"value" => $sku,
					));
	echo "</td><td name = 2>";
	echo elgg_view("input/text", array(
					"name" => "marketlocation",
					"value" => $location,
					));
	echo "</td><td name = 3>";
	echo elgg_view("input/text", array(
					"name" => "marketvin",
					"value" => $vin,
					));
	echo "</td><td name = 4>";
	echo elgg_view("input/text", array(
					"name" => "marketserial02",
					"value" => $serial02,
					));
	echo "</td></tr>";
	echo "<tr><td name = 1>";
	echo "</td><td name = 2>";
	echo elgg_echo("market:price");
	echo "</td><td name = 3>";
	echo elgg_echo("market:tags");
	echo "</td><td name = 4>";
	echo elgg_echo("quebx:asset_collection");
	echo "</td></tr>";
	echo "<tr><td name = 1>";
	echo "</td><td name = 2>";
	echo elgg_view("input/text", array(
					"name" => "marketprice",
					"value" => $price,
					));
	echo "</td><td name = 3>";
	echo elgg_view("input/tags", array(
					"name" => "markettags",
					"value" => $tags,
					));
	echo "</td><td name = 4>";
	echo elgg_view("input/text", array(
					"name" => "marketcollection",
					"value" => $collection,
					));
	echo "</td></tr>";
	
	echo "<tr><td name = 1>";
	echo "</td><td name = 2>";
	echo "</td><td name = 3>";
	echo "</td><td name = 4>";
	echo "</td></tr>";
	echo "</table></div>";
	
	echo "<p></p><p><label>" . elgg_echo("market:uploadimages") . "<br /><small><small>" . elgg_echo("market:imagelimitation") . "</small></small><br />";
	echo elgg_view("input/file",array('name' => 'upload'));
	echo "</label></p>";
	
	echo "<p><label>" . elgg_echo('access') . "&nbsp;<small><small>" . elgg_echo("market:access:help") . "</small></small><br />";
	echo elgg_view('input/access', array('name' => 'access_id','value' => $access_id));
	echo "</label></p>";
	
	echo "<p>";

	if (isset($vars['entity'])) {
		echo "<input type=\"hidden\" name=\"marketpost\" value=\"".$object->guid."\" />";
	}
		
	echo elgg_view('input/submit', array('name' => 'submit', 'text' => elgg_echo('market:save')));

} else {
	echo "<p>edit.php - not auto</p><label>" . elgg_echo("title") . " <small><small>" . elgg_echo("market:title:help") . "</small></small><br />";
	echo elgg_view("input/text", array(
					"name" => "markettitle",
					"value" => $title,
					));
	echo "</label></p>";
	$marketcategories = elgg_view('market/marketcategories',$vars);
	if (!empty($marketcategories)) {
		echo "<p>{$marketcategories}</p>";
	}
	
	if(elgg_get_plugin_setting('market_custom', 'market') == 'yes'){
		$marketcustom = elgg_view('market/custom',$vars);
		if (!empty($marketcustom)) {
			echo "<p>{$marketcustom}</p>";
		}
	}
	echo "<table border='0' cellpadding='40' width='100%'><tr>";
	echo "<td><p><label>" . elgg_echo("market:text") . "</label><br>";
	if ($allowhtml != 'yes') {
	
		echo "<small><small>" . sprintf(elgg_echo("market:text:help"), $numchars) . "</small></small><br />";
		echo "<textarea name='marketbody' class='mceNoEditor' rows='8' cols='40' onKeyDown='textCounter(document.marketForm.marketbody,document.marketForm.remLen1,{$numchars})' onKeyUp='textCounter(document.marketForm.marketbody,document.marketForm.remLen1,{$numchars})'>{$body}</textarea>";
		echo "<span><input readonly type='text' name='remLen1' size='3' maxlength='3' value='{$numchars}' class='market_charleft'>" . elgg_echo("market:charleft") . "</span>";
	
	} else {
		echo elgg_view("input/longtext", array("name" => "marketbody", "value" => $body));
		echo "</label>";
	}
	
	echo "</p></td>";
	
	echo "<td width='220px'>";
	echo "<p><label>" . elgg_echo("market:image") . "<br /><center>";
	echo elgg_view('market/thumbnail', array('marketguid' => $object->guid, 'size' => 'large', 'tu' => $tu));
	echo "</center><br /></label></p>";
	echo "</td><tr></table>";
			
	echo "<table border=2, width=100%><tr>";
	echo "<td width=100>"; 
	echo "<label>" . elgg_echo("market:price") . "&nbsp;<small><small>" . elgg_echo("market:price:help", array($currency)) . "</small></small><br />";
	echo elgg_view("input/text", array(
					"name" => "marketprice",
					"value" => $price,
					));
				
	echo "</label>";
	echo "</td><td width = 20></td>";
	echo "<td>";
	echo "<p><label>" . elgg_echo("market:tags") . "&nbsp;<small><small>" . elgg_echo("market:tags:help") . "</small></small><br />";
	echo elgg_view("input/tags", array(
					"name" => "markettags",
					"value" => $tags,
					));
	echo "</label></p>";
	echo "</tr><tr><td colspan=3>"; 
	echo "</td></tr></table>";
	
	echo "<p><label>" . elgg_echo("market:uploadimages") . "<br /><small><small>" . elgg_echo("market:imagelimitation") . "</small></small><br />";
	echo elgg_view("input/file",array('name' => 'upload'));
	echo "</label></p>";
	
	echo "<p><label>" . elgg_echo('access') . " <small><small>" . elgg_echo("market:access:help") . "</small></small><br />";
	echo elgg_view('input/access', array('name' => 'access_id','value' => $access_id));
	echo "</label></p>";
	
	echo "<p>";
	if (isset($vars['entity'])) {
		echo "<input type=\"hidden\" name=\"marketpost\" value=\"".$object->guid."\" />";
	}
	
	// Terms checkbox and link
	$termslink = elgg_view('output/url', array(
				'href' => "mod/market/terms.php",
				'text' => elgg_echo('market:terms:title'),
				'class' => "elgg-lightbox",
				));
	
	$termsaccept = sprintf(elgg_echo("market:accept:terms"),$termslink);
	echo "<input type='checkbox' name='accept_terms'><label>{$termsaccept}</label></p>";
	
	echo "<p>";
	echo elgg_view('input/submit', array('name' => 'submit', 'text' => elgg_echo('save')));
	echo "</p>";
}
