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

// Make sure we're logged in (send us to the front page if not)
if (!isloggedin()) forward();

// Get input data
$guid = (int) get_input('marketpost');
$title = get_input('markettitle');
$price = get_input('marketprice');
$custom = get_input('marketcustom');
$category = get_input('marketcategory');
$body = get_input('marketbody');
$tags = get_input('markettags');
$access = get_input('access_id');
// Added 04/02/2013
	$title = get_input('markettitle');
	$category = get_input('marketcategory');
	$manufacturer = get_input('marketmanufacturer');
	$brand = get_input('marketbrand');
	$model = get_input('marketmodel');
	$part = get_input('marketpart');
	$description = get_input('marketdescription');
	$collection = get_input('marketcollection');
	$warranty = get_input('marketwarranty');
	$warrantor = get_input('marketwarrantor');
	$owner = get_input('marketowner');
	$lifecycle = get_input('marketlifecycle');
	$quantity = get_input('marketquantity');
	$length = get_input('marketlength');
	$width = get_input('marketwidth');
	$height = get_input('marketheight');
	$weight = get_input('marketweight');
	$features = get_input('marketfeatures');
	$drive = get_input('marketdrive');
	$displacement = get_input('marketdisplacement');
	$cylinders = get_input('marketcylinders');
	$horsepower = get_input('markethorsepower');
	$transmission = get_input('markettransmission');
	$torque = get_input('markettorque');
	$tires = get_input('markettires');
	$mpg = get_input('marketmpg');
	$fuel = get_input('marketfuel');
	$bore = get_input('marketbore');
	$stroke = get_input('marketstroke');
	$wheelbase = get_input('marketwheelbase');
	$legroom = get_input('marketlegroom');
	$headroom = get_input('marketheadroom');
	$cargocapacity = get_input('marketcargocapacity');
	$towingcapacity = get_input('markettowingcapacity');
	$payloadcapacity = get_input('marketpayloadcapacity');
	$location = get_input('marketlocation');
	$serial01 = get_input('marketserial01');
	$serial02 = get_input('marketserial02');
	$colorexterior = get_input('marketcolorexterior');
	$colorinterior = get_input('marketcolorinterior');
// Added 04/07/2013
	$vin = get_input('marketvin');
	$sku = get_input('marketsku');
		
// Make sure we actually have permission to edit
$market = get_entity($guid);
if ($market->getSubtype() == "market" && $market->canEdit()) {
	
	// Cache to the session
	$_SESSION['markettitle'] = $title;
	$_SESSION['marketbody'] = $body;
	$_SESSION['marketprice'] = $price;
	$_SESSION['marketcustom'] = $custom;
	$_SESSION['markettags'] = $tags;
	$_SESSION['marketcategory'] = $category;
// Added 04/02/2013
	$_SESSION['markettitle'] = $title;
	$_SESSION['marketcategory'] = $category;
	$_SESSION['marketmanufacturer'] = $manufacturer;
	$_SESSION['marketbrand'] = $brand;
	$_SESSION['marketmodel'] = $model;
	$_SESSION['marketpart'] = $part;
	$_SESSION['marketdescription'] = $description;
	$_SESSION['marketcollection'] = $collection;
	$_SESSION['marketwarranty'] = $warranty;
	$_SESSION['marketwarrantor'] = $warrantor;
	$_SESSION['marketowner'] = $owner;
	$_SESSION['marketlifecycle'] = $lifecycle;
	$_SESSION['marketquantity'] = $quantity;
	$_SESSION['marketlength'] = $length;
	$_SESSION['marketwidth'] = $width;
	$_SESSION['marketheight'] = $height;
	$_SESSION['marketweight'] = $weight;
	$_SESSION['marketfeatures'] = $features;
	$_SESSION['marketdrive'] = $drive;
	$_SESSION['marketdisplacement'] = $displacement;
	$_SESSION['marketcylinders'] = $cylinders;
	$_SESSION['markethorsepower'] = $horsepower;
	$_SESSION['markettransmission'] = $transmission;
	$_SESSION['markettorque'] = $torque;
	$_SESSION['markettires'] = $tires;
	$_SESSION['marketmpg'] = $mpg;
	$_SESSION['marketfuel'] = $fuel;
	$_SESSION['marketbore'] = $bore;
	$_SESSION['marketstroke'] = $stroke;
	$_SESSION['marketwheelbase'] = $wheelbase;
	$_SESSION['marketlegroom'] = $legroom;
	$_SESSION['marketheadroom'] = $headroom;
	$_SESSION['marketcargocapacity'] = $cargocapacity;
	$_SESSION['markettowingcapacity'] = $towingcapacity;
	$_SESSION['marketpayloadcapacity'] = $payloadcapacity;
	$_SESSION['marketlocation'] = $location;
	$_SESSION['marketserial01'] = $serial01;
	$_SESSION['marketserial02'] = $serial02;
	$_SESSION['marketcolorexterior'] = $colorexterior;
	$_SESSION['marketcolorinterior'] = $colorinterior;
// Added 04/07/2013
	$_SESSION['marketvin'] = $vin;
	$_SESSION['marketsku'] = $sku;
	
	// Convert string of tags into a preformatted array
	$tagarray = string_to_tag_array($tags);
			
	// Make sure the title / description aren't blank
	if (empty($title) || empty($body)) {
		register_error(elgg_echo("market:blank"));
		forward("mod/market/add/auto.php");
				
	// Otherwise, save the market post 
	} else {
				
		// Get owning user
		$owner = get_entity($market->getOwner());
		// For now, set its access to public (we'll add an access dropdown shortly)
		$market->access_id = $access;
		// Set its title and description appropriately
		$market->title = $title;
		$market->description = $body;
		$market->price = $price;
		$market->custom = $custom;
		$market->marketcategory = $category;
	// Added 04/02/2013
		$market->title = $title;
		$market->category = $category;
		$market->manufacturer = $manufacturer;
		$market->brand = $brand;
		$market->model = $model;
		$market->part = $part;
		$market->description = $description;
		$market->collection = $collection;
		$market->warranty = $warranty;
		$market->warrantor = $warrantor;
		$market->owner = $owner;
		$market->lifecycle = $lifecycle;
		$market->quantity = $quantity;
		$market->length = $length;
		$market->width = $width;
		$market->height = $height;
		$market->weight = $weight;
		$market->features = $features;
		$market->drive = $drive;
		$market->displacement = $displacement;
		$market->cylinders = $cylinders;
		$market->horsepower = $horsepower;
		$market->transmission = $transmission;
		$market->torque = $torque;
		$market->tires = $tires;
		$market->mpg = $mpg;
		$market->fuel = $fuel;
		$market->bore = $bore;
		$market->stroke = $stroke;
		$market->wheelbase = $wheelbase;
		$market->legroom = $legroom;
		$market->headroom = $headroom;
		$market->cargocapacity = $cargocapacity;
		$market->towingcapacity = $towingcapacity;
		$market->payloadcapacity = $payloadcapacity;
		$market->location = $location;
		$market->serial01 = $serial01;
		$market->serial02 = $serial02;
		$market->colorexterior = $colorexterior;
		$market->colorinterior = $colorinterior;
// Added 04/07/2013
		$market->vin = $vin;
		$market->sku = $sku;
		
		// Before we can set metadata, we need to save the market post
		if (!$market->save()) {
			register_error(elgg_echo("market:error"));
			forward("mod/market/edit/auto.php?marketpost=" . $guid);
		}
		// Now let's add tags. We can pass an array directly to the object property! Easy.
		$market->clearMetadata('tags');
		if (is_array($tagarray)) {
			$market->tags = $tagarray;
		}

		// Now see if we have a file icon
		if ((isset($_FILES['upload'])) && (substr_count($_FILES['upload']['type'],'image/'))) {

			$prefix = "market/".$market->guid;
			$filehandler = new ElggFile();
			$filehandler->owner_guid = $market->owner_guid;
			$filehandler->setFilename($prefix . ".jpg");
			$filehandler->open("write");
			$filehandler->write(get_uploaded_file('upload'));
			$filehandler->close();
		
			$thumbtiny = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),25,25, true);
			$thumbsmall = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),40,40, true);
			$thumbmedium = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),153,153, true);
			$thumblarge = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),200,200, false);
			if ($thumbtiny) {
			
				$thumb = new ElggFile();
				$thumb->owner_guid = $market->owner_guid;
				$thumb->setMimeType('image/jpeg');
				$thumb->setFilename($prefix."tiny.jpg");
				$thumb->open("write");
				$thumb->write($thumbtiny);
				$thumb->close();
				$thumb->setFilename($prefix."small.jpg");
				$thumb->open("write");
				$thumb->write($thumbsmall);
				$thumb->close();
				$thumb->setFilename($prefix."medium.jpg");
				$thumb->open("write");
				$thumb->write($thumbmedium);
				$thumb->close();
				$thumb->setFilename($prefix."large.jpg");
				$thumb->open("write");
				$thumb->write($thumblarge);
				$thumb->close();
			}
		}				

		// Success message
		system_message(elgg_echo("market:posted"));

		// regenerate cache
		elgg_regenerate_simplecache();
		// add to river - doesn't work well with the new river!
		//add_to_river('river/object/market/update','update',$_SESSION['user']->guid,$market->guid);
		// Remove the market post cache
		unset($_SESSION['markettitle']); unset($_SESSION['marketbody']); unset($_SESSION['marketprice']); unset($_SESSION['markettags']);
		remove_metadata($_SESSION['user']->guid,'markettitle');
		remove_metadata($_SESSION['user']->guid,'marketbody');
		remove_metadata($_SESSION['user']->guid,'markettags');
		remove_metadata($_SESSION['user']->guid,'marketprice');
		remove_metadata($_SESSION['user']->guid,'markettype');
    // Added 04/02/2013
		remove_metadata($_SESSION['user']->guid,'markettitle');
		remove_metadata($_SESSION['user']->guid,'marketcategory');
		remove_metadata($_SESSION['user']->guid,'marketmanufacturer');
		remove_metadata($_SESSION['user']->guid,'marketbrand');
		remove_metadata($_SESSION['user']->guid,'marketmodel');
		remove_metadata($_SESSION['user']->guid,'marketpart');
		remove_metadata($_SESSION['user']->guid,'marketdescription');
		remove_metadata($_SESSION['user']->guid,'marketcollection');
		remove_metadata($_SESSION['user']->guid,'marketwarranty');
		remove_metadata($_SESSION['user']->guid,'marketwarrantor');
		remove_metadata($_SESSION['user']->guid,'marketowner');
		remove_metadata($_SESSION['user']->guid,'marketlifecycle');
		remove_metadata($_SESSION['user']->guid,'marketquantity');
		remove_metadata($_SESSION['user']->guid,'marketlength');
		remove_metadata($_SESSION['user']->guid,'marketwidth');
		remove_metadata($_SESSION['user']->guid,'marketheight');
		remove_metadata($_SESSION['user']->guid,'marketweight');
		remove_metadata($_SESSION['user']->guid,'marketfeatures');
		remove_metadata($_SESSION['user']->guid,'marketdrive');
		remove_metadata($_SESSION['user']->guid,'marketdisplacement');
		remove_metadata($_SESSION['user']->guid,'marketcylinders');
		remove_metadata($_SESSION['user']->guid,'markethorsepower');
		remove_metadata($_SESSION['user']->guid,'markettransmission');
		remove_metadata($_SESSION['user']->guid,'markettorque');
		remove_metadata($_SESSION['user']->guid,'markettires');
		remove_metadata($_SESSION['user']->guid,'marketmpg');
		remove_metadata($_SESSION['user']->guid,'marketfuel');
		remove_metadata($_SESSION['user']->guid,'marketbore');
		remove_metadata($_SESSION['user']->guid,'marketstroke');
		remove_metadata($_SESSION['user']->guid,'marketwheelbase');
		remove_metadata($_SESSION['user']->guid,'marketlegroom');
		remove_metadata($_SESSION['user']->guid,'marketheadroom');
		remove_metadata($_SESSION['user']->guid,'marketcargocapacity');
		remove_metadata($_SESSION['user']->guid,'markettowingcapacity');
		remove_metadata($_SESSION['user']->guid,'marketpayloadcapacity');
		remove_metadata($_SESSION['user']->guid,'marketlocation');
		remove_metadata($_SESSION['user']->guid,'marketserial01');
		remove_metadata($_SESSION['user']->guid,'marketserial02');
		remove_metadata($_SESSION['user']->guid,'marketcolorexterior');
		remove_metadata($_SESSION['user']->guid,'marketcolorinterior');
// Added 04/07/2013
		remove_metadata($_SESSION['user']->guid,'marketvin');
	    remove_metadata($_SESSION['user']->guid,'marketsku');
				

		// Forward to the main market page
		forward(elgg_get_site_url() . "market");
	}
		
}

