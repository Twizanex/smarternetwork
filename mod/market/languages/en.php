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

$english = array(
    // Site terms -- Replace default terms from languages/en.php
	'profile:field:tags' => 'Labels',
	'tagcloud' => "Labels",
	'tagcloud:allsitetags' => "Cloud",
	'tags' => "Labels",
	'tag_names:tags' => 'Labels',
	'tags:site_cloud' => 'Label Cloud',
	'tag:search:startblurb' => "Items labeled as '%s':",


    // Site terms -- Replace default terms from search/languages/en.php
	'search:results' => 'Results for %s',

    // Site terms -- Replace default terms from mod/tagcloud/languages/en.php
	'tagcloud:widget:title' => 'Label Array',
	'tagcloud:widget:description' => 'Label array',
	'tagcloud:widget:numtags' => 'Number of labels to show',

    // Site terms -- Replace default terms from pages/languages/en.php
	'pages:tags' => 'Quebs',


	// Menu items and titles
	'market' => "QuebX item",
	'market:posts' => "Items",
	'market:title' => "Stuff",
	'market:user:title' => "%s's stuff",
	'market:user' => "%s's Stuff",
	'market:user:friends' => "%s's friends stuff",
	'market:user:friends:title' => "%s's friends stuff",
	'market:mine' => "My Stuff",
	'market:mine:title' => "My items",
	'market:posttitle' => "%s's item: %s",
	'market:friends' => "Friends Stuff",
	'market:friends:title' => "My friends stuff",
	'market:everyone:title' => "Everything on QuebX",
	'market:everyone' => "Everything",
	'market:read' => "View post",
	'market:add' => "Add Item",
	'market:add:title' => "Add a new item",
	'market:auto:title' => "Add an automobile",
	'market:add:antiques' => "Add an antique",
	'market:add:appliances' => "Add an appliance",
	'market:add:art' => "Add art",
	'market:add:auto' => "Add an automobile",
	'market:add:baby' => "Add baby and kids stuff",
	'market:add:luggage' => 'Add luggage',
	'market:add:media' => 'Add media',
	'market:add:clothes' => 'Add clothes',
	'market:add:collectibles' => 'Add a collectible',
	'market:add:computers' => 'Add computer stuff',
	'market:add:electronics' => 'Add electronics',
	'market:add:furniture' => 'Add furniture',
	'market:add:home' => 'Add home & garden',
	'market:add:jewelry' => 'Add jewelry',
	'market:add:instruments' => 'Add an instrument',
	'market:add:office' => 'Add office equipment',
	'market:add:sports' => 'Add sports equipment',
	'market:add:tools' => "Add tools",
	'market:add:video' => 'Add video equipment',
	'market:add:all' => 'Add an item',
	'market:quick' => "QuicAdd",
	'market:quick:title' => "New item",
	'market:edit' => "Edit item",
	'market:imagelimitation' => "Must be JPG, GIF or PNG.",
	'market:text' => "Brief description of your item",
	'market:uploadimages' => "Add photo for your item",
	'market:image' => "Item image",
	'market:custom1' => "Custom Characteristic",
	'market:custom2' => "Another Custom Characteristic",
	'market:imagelater' => "",
	'market:strapline' => "Added",
	'item:object:market' => 'QuebX items',
	'market:save' => 'Save item',
	'market:none:found' => 'No items found',
	'market:pmbuttontext' => "Send Private Message",
	'market:price' => "Monetary value",
	'market:price:help' => "(in %s)",
	'market:text:help' => "(No HTML and max. 250 characters)",
	'market:title:help' => "(1-3 words)",
	// 'market:tags' => "Tags",
	'market:tags' => "Labels",
	'market:tags:help' => "(Separate labels with commas)",
	'market:access:help' => "(Who can see this item)",
	'market:replies' => "Replies",
	'market:created:gallery' => "Created by %s <br>at %s",
	'market:created:listing' => "Created by %s at %s",
	'market:showbig' => "Show larger picture",
	'market:type' => "Type",
	'market:charleft' => "characters left",
	'market:accept:terms' => "I have read and accepted the %s of use.",
	'market:terms' => "terms",
	'market:terms:title' => "Terms of use",
	'market:terms' => "<li class='elgg-divide-bottom'>QuebX is for maintaining or exchanging items among members.</li>
			<li class='elgg-divide-bottom'>No more than %s Market posts are allowed pr. user at the same time.</li>

			<li class='elgg-divide-bottom'>A QuebX post may only contain one item, unless it's part of a matching set.</li>
			<li class='elgg-divide-bottom'>Commercial advertising is limited to those who have signed a promotional agreement with QuebX.</li>
   			<li class='elgg-divide-bottom'>We reserve the right to delete any items violating our terms of use.</li>
			<li class='elgg-divide-bottom'>Terms are subject to change over time.</li>
			",

	// market widget
	'market:widget' => "My Stuff",
	'market:widget:description' => "Showcase your items on QuebX",
	'market:widget:viewall' => "View all my items",
	'market:num_display' => "Number of items to display",
	'market:icon_size' => "Icon size",
	'market:small' => "small",
	'market:tiny' => "tiny",

	// market river
	'river:create:object:market' => '%s posted a new item %s',
	'river:update:object:market' => '%s updated the item %s',
	'river:comment:object:market' => '%s commented on the item %s',

	// Status messages
	'market:posted' => "Your item was successfully added to QuebX.",
	'market:deleted' => "Your item was successfully deleted from QuebX.",
	'market:uploaded' => "Your image was succesfully added.",

	// Error messages
	'market:save:failure' => "Your item could not be saved. Please try again.",
	'market:blank' => "Sorry; you need to fill in both the title and body before you can add an item.",
	'market:tobig' => "Sorry; your file is bigger then 1MB, please upload a smaller file.",
	'market:notjpg' => "Please make sure the picture inculed is a .jpg, .png or .gif file.",
	'market:notuploaded' => "Sorry; your file doesn't apear to have uploaded.",
	'market:notfound' => "Sorry; we could not find the specified item.",
	'market:notdeleted' => "Sorry; we could not delete this item.",
	'market:tomany' => "Error: Too many items",
	'market:tomany:text' => "You have reached the maximum number of items per user. Please delete some first!",
	'market:accept:terms:error' => "You must accept the terms of use!",

	// Settings
	'market:settings:status' => "Status",
	'market:settings:desc' => "Description",
	'market:max:posts' => "Max. number of items per user",
	'market:unlimited' => "Unlimited",
	'market:currency' => "Currency ($, €, DKK or something)",
	'market:allowhtml' => "Allow HTML in QuebX posts",
	'market:numchars' => "Max. number of characters in item description (only valid without HTML)",
	'market:pmbutton' => "Enable private message button",
	'market:adminonly' => "Only admin can create items",
	'market:comments' => "Allow comments",
	'market:custom' => "Custom field",

	// market categories
	'market:categories' => 'Categories',
	'market:categories:choose' => 'Choose category',
	'market:categories:settings' => 'Categories:',
	'market:categories:explanation' => 'Set some predefined categories for posting to QuebX.<br>Categories could be "clothes, footwear or buy,sell etc...", seperate each category with commas - remember not to use special characters in categories and put them in your language files as market:<i>categoryname</i>',
	'market:categories:save:success' => 'Aspects were successfully saved.',
	'market:categories:settings:categories' => 'Categories',
	'market:all' => "Everything",
	'market:category' => "Category",
	'market:category:title' => "%s",
//	'market:category:title' => "Category: %s",
//	'market:category:title' => "%s Items",

	// Categories
	'market:buy' => "Buying",
	'market:sell' => "Selling",
	'market:swap' => "Swap",
	'market:free' => "Free",
		//Products
		'market:category:antiques' => 'Antiques',
		'market:category:appliances' => 'Appliances',
		'market:category:art' => 'Arts & Crafts',
		'market:category:auto' => 'Automobiles',
		'market:category:baby' => 'Baby & Kid Stuff',
		'market:category:luggage' => 'Bags & Luggage',
		'market:category:media' => 'CDs & DVDs',
		'market:category:clothes' => 'Clothes & Accessories',
		'market:category:collectibles' => 'Collectibles',
		'market:category:computers' => 'Computers & Acc.',
		'market:category:electronics' => 'Electronics',
		'market:category:furniture' => 'Furniture',
		'market:category:home' => 'Home & Garden',
		'market:category:jewelry' => 'Jewelry',
		'market:category:instruments' => 'Musical Instruments',
		'market:category:office' => 'Office & Biz',
		'market:category:sports' => 'Sports & Bicycles',
		'market:category:tools' => 'Tools',
		'market:category:video' => 'Video Games and Consoles',

	// Custom select
	'market:custom:select' => "Item condition",
	'market:custom:text' => "Condition",
	'market:custom:activate' => "Enable Custom Select:",
	'market:custom:settings' => "Custom Select Choices",
	'market:custom:choices' => "Set some predefined choices for the custom select dropdown box.<br>Choices could be \"market:new,market:used...etc\", seperate each choice with commas - remember to put them in your language files",

	// Custom choices
	 'market:na' => "No information",
	 'market:new' => "New",
	 'market:unused' => "Unused",
	 'market:used' => "Used",
	 'market:good' => "Good",
	 'market:fair' => "Fair",
	 'market:poor' => "Poor",

	 'market:add_more' => "Add more to item",
	 'market:edit_more:invalid_guid' => "This is not a valid market item.",
	 'market:edit_more:response' => "The information was added to your item.",
	 'market:category:all' => "Everything",

	 // shoe example

   'market:category:bicycles' => "Bicycles",
   'market:category:shoes' => "Shoes",
   'market:category:clothing' => "Clothing",
	 'market:edit_more:shoes:family:label' => "Type of shoe",
	 'market:edit_more:shoes:color:label' => "Color",
	 'market:edit_more:shoes:size:label' => "Shoe size",

	 'market:family:shoes:dress' => "Dress shoes",
	 'market:family:shoes:running' => "Running shoes",

	 'market:edit_more:shoes:running:brand:label' => "Brand",
	 'market:edit_more:shoes:running:price:label' => "Price",

	 'market:edit_more:shoes:dress:brand:label' => "Brand",
	 'market:edit_more:shoes:dress:price:label' => "Price",


    //Quebx Labels
		'quebx:asset_title' => "Title*",
		'quebx:asset_category' => "Category",
		'quebx:asset_manufacturer' => "Manufacturer",
		'quebx:asset_brand' => "Brand",
		'quebx:asset_model' => "Model #",
		'quebx:asset_part' => "Part #",
		'quebx:asset_description' => "Description*",
		'quebx:asset_collection' => "Collection",
		'quebx:asset_warranty' => "Warranty",
		'quebx:asset_warrantor' => "Warrantor",
		'quebx:asset_owner' => "Owner",
		'quebx:asset_lifecycle' => "Lifecycle",
		'quebx:asset_quantity' => "Quantity",
		'quebx:asset_length' => "Length",
		'quebx:asset_width' => "Width",
		'quebx:asset_height' => "Height",
		'quebx:asset_weight' => "Weight",
		'quebx:asset_features' => "Features",
		'quebx:asset_modelyear' => "Model Year",
		'quebx:auto_drive' => "Drive",
		'quebx:auto_displacement' => "Engine Size",
		'quebx:auto_cylinders' => "Cylinders",
		'quebx:auto_horsepower' => "Horsepower",
		'quebx:auto_transmission' => "Transmission",
		'quebx:auto_torque' => "Torque",
		'quebx:auto_tires' => "Tires",
		'quebx:auto_mpg' => "MPG",
		'quebx:auto_fuel' => "Fuel",
		'quebx:auto_bore' => "Bore",
		'quebx:auto_stroke' => "Stroke",
		'quebx:auto_wheelbase' => "Wheelbase",
		'quebx:auto_legroom' => "Leg Room",
		'quebx:auto_headroom' => "Head Room",
		'quebx:auto_cargocapacity' => "Cargo Capacity for Cars",
		'quebx:auto_towingcapacity' => "Towing Capacity for Trucks",
		'quebx:auto_payloadcapacity' => "Payload Capacity for Trucks",
		'quebx:asset_location' => "Location",
		'quebx:asset_serial01' => "Manufacturer’s Serial #",
		'quebx:asset_serial02' => "Owner’s Serial #",
		'quebx:asset_colorexterior' => "Exterior Color",
		'quebx:asset_colorinterior' => "Interior Color",
		'quebx:auto_vin' => "VIN",
		'quebx:asset_sku' => "SKU",
);

add_translation("en",$english);

?>
