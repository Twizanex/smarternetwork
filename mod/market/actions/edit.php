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
gatekeeper();

// Get input data
$guid = (int) get_input('guid');
$title = get_input('markettitle');
$category = get_input('marketcategory');
$body = get_input('marketbody');
$access = get_input('access_id');
$tags = get_input('markettags');

elgg_make_sticky_form('market');

// Convert string of tags into a preformatted array
$tagarray = string_to_tag_array($tags);
$error = FALSE;

// Make sure the title / description aren't blank
if (empty($title) || empty($body)) {
	register_error(elgg_echo("market:blank"));
	$error =  TRUE;
} else {

  if ($guid) {
    // editing an existing market item
    // Make sure we actually have permission to edit
    $marketpost = get_entity($guid);
    if (!elgg_instanceof($marketpost, 'object','market') && $marketpost->canEdit()) {
      register_error(elgg_echo('market:notfound'));
      $error = TRUE;
    }
  } else {
    // creating a new market item
    $user_guid = elgg_get_logged_in_user_guid();
    $marketpost = new ElggObject();
    $marketpost->subtype = 'market';
    $marketpost->owner_guid = $user_guid;
    $marketpost->container_guid = $user_guid;
  }

  if (!$error) {
	  $marketpost->access_id = $access;
	  $marketpost->title = $title;
	  $marketpost->description = $body;
	  $marketpost->marketcategory = $category; // until I understand how these parts relate, leave as original "marketcategory"
	  $marketpost->tags = $tagarray;

	  if (!$marketpost->save()) {
	    register_error(elgg_echo('market:save:failure'));
	    $error = TRUE;
	  }
  }

  if ($error) {
    if ($guid) {
      forward("mod/market/edit/" . $guid);
    } else {
      forward("mod/market/add");
    }
  }

  // no errors, so clear the sticky form and save any file attachment

	elgg_clear_sticky_form('market');

	// Now see if we have a file icon
	if ((isset($_FILES['upload'])) && (substr_count($_FILES['upload']['type'],'image/'))) {

		$prefix = "market/".$marketpost->guid;
		$filehandler = new ElggFile();
		$filehandler->owner_guid = $marketpost->owner_guid;
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
			$thumb->owner_guid = $marketpost->owner_guid;
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

	if (elgg_view_exists("forms/market/edit/$category")) {
	  forward("market/edit_more/{$marketpost->guid}/$category");
	} else {
	  // Forward to the main market page
	  forward("market");
	}
}
