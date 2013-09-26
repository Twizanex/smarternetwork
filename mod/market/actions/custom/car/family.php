<?php

$guid = get_input('guid');
$entity = get_entity($guid);

// create relationships for drivers
$drivers = get_input('drivers');
if (is_string($drivers)) {
    $drivers = explode(',', $drivers);
}

// first clear old relationships
remove_entity_relationships($guid, 'driver', true);

// now add new ones
if (is_array($drivers)) {
	foreach ($drivers as $driver_guid) {
		add_entity_relationship($driver_guid, 'driver', $guid);
	}
}



/** do the same again for shoes **/
$shoes = get_input('shoes');
if (is_string($shoes)) {
    $shoes = explode(',', $drivers);
}

// first clear old relationships
remove_entity_relationships($guid, 'car_shoes', true);

// now add new ones
if (is_array($shoes)) {
	foreach ($shoes as $shoe_guid) {
		add_entity_relationship($shoe_guid, 'car_shoes', $guid);
	}
}








/***
 * 
 *		HANDLE FILE UPLOAD
 * 
 */

if (!empty($_FILES['upload']['name']) && $_FILES['upload']['error'] == 0) {
	$prefix = "marketfile/{$entity->guid}/";
	$time = time();
	$ext = end(explode(".", $_FILES['upload']['name']));
	$name = 'upload';
	if ($ext) {
		$name .= '.' . elgg_strtolower($ext);
	}
	$filestorename = elgg_strtolower($time . $name);
	
	$file = new ElggFile();
	$file->owner_guid = $entity->owner_guid;
	$file->container_guid = $entity->owner_guid;
	$mime_type = $file->detectMimeType($_FILES['upload']['tmp_name'], $_FILES['upload']['type']);
	$file->setFilename($prefix . $filestorename);
	$file->setMimeType($mime_type);
	$file->originalfilename = $_FILES['upload']['name'];
	$file->simpletype = file_get_simple_type($mime_type);

	// Open the file to guarantee the directory exists
	$file->open("write");
	$file->close();
	$result = move_uploaded_file($_FILES['upload']['tmp_name'], $file->getFilenameOnFilestore());
	
	if ($result) {
		// save our file url
		// we can get the original file from this
		// at [url]/market/file/[guid]/[time]/[name]
		// you can create your own file system organization however you want
		// ideally this is added as a new elgg entity, but that's a bigger scope == more time right now
		// see /pages/market/file.php
		$entity->upload = $entity->guid . '/' . $time . '/' . $name;
	}
}