<?php

/**
 * hypeCategories Plugin for Elgg
 *
 * @package hypeCategories
 * @author Ismayil Khayredinov
 */
// Initialize
function hypeCategories_init() {
    global $CONFIG;

    if (!is_plugin_enabled('hypeFramework')) {
        register_error('hypeFramework is not enabled. hypeCategories will not work properly. Visit www.hypeJunction.com for details');
    }

// Register actions for manipulation of categories
    register_action('category/actions', false, $CONFIG->pluginspath . 'hypeCategories/actions/actions.php', false);
    register_action('category/save', false, $CONFIG->pluginspath . 'hypeCategories/actions/save.php', false);

// Register page handlers for better navigation
    register_page_handler('category', 'category_url_handler');
    register_entity_url_handler('hypeCategories_category_url', 'object', 'category');

// Extend existing views, create new views
    elgg_extend_view('css', 'hypeCategories/css');

    elgg_extend_view('elgg_topbar/extend', 'hypeCategories/elements/menulist');
    elgg_extend_view('hypeStyler/elements/styler_topbar_tools', 'hypeCategories/elements/styler_menulist');

    elgg_extend_view('profile/icon', 'hypeCategories/elements/icon');

    elgg_extend_view('page_elements/header_contents', 'hypeCategories/meta/metatags');

    elgg_extend_view('page_elements', 'hypeCategories/elements/list');

// Register a plugin hook for icon display
    register_plugin_hook('entity:icon:url', 'object', 'category_icon_hook');

// Register categories for search
// Categories search view overloaded in search/object/category/entity.php
    register_entity_type('object', 'category');
}

// ADMIN SUBMENU
function hypeCategories_pagesetup() {

    global $CONFIG;

    if (elgg_get_context() == 'admin' && elgg_is_admin_logged_in()) {
        elgg_register_menu_item(elgg_echo('hypeCategories:admin:submenu'), $CONFIG->wwwroot . 'mod/hypeCategories/manage.php', 'hype');
    }

    if (elgg_get_plugin_setting('show_sidebar', 'hypeCategories') == 'yes') {
        if (!in_array(elgg_get_context(), string_to_tag_array(elgg_get_plugin_setting('sidebar_display', 'hypeCategories')))
                && elgg_get_context() !== 'groups' && elgg_get_context() !== 'category') {
            elgg_extend_view('page_elements/owner_block', 'hypeCategories/elements/list');
        } elseif (elgg_get_plugin_setting('allow_groups', 'hypeCategories') == 'yes'
                && elgg_get_plugin_setting('allow_in_groups', 'hypeCategories') == 'yes') {
            if (elgg_get_page_owner_entity() instanceof ElggGroup) {
                elgg_extend_view('owner_block/extend', 'hypeCategories/elements/group_list');
            } else {
                elgg_extend_view('page_elements/owner_block', 'hypeCategories/elements/list');
            }
            add_group_tool_option('categories', elgg_echo('hypeCategories:groups:enable'), true);
        }
    }
}

//URL AND PAGE HANDLERS
function hypeCategories_category_url($entity) {

    global $CONFIG;

    $title = elgg_get_friendly_title($entity->title);
    $context = elgg_get_context();
    if ($context !== 'groups')
        $context = 'site';
    return $CONFIG->url . "pg/category/view/{$context}/{$entity->guid}/$title/";
}

function category_url_handler($page) {

    global $CONFIG;

    switch ($page[0]) {
        case 'group' :
            if (isset($page[1])) {
                set_input('group_guid', $page[1]);
                include($CONFIG->pluginspath . "hypeCategories/views/default/hypeCategories/extensions/groups/manage_group.php");
            }
            break;

        case 'icon':
            if (isset($page[1])) {
                set_input('category_guid', $page[1]);
            }
            if (isset($page[2])) {
                set_input('size', $page[2]);
            }
            include($CONFIG->pluginspath . "hypeCategories/graphics/hypeCategories/icon.php");
            break;

        case 'view':
            if (isset($page[1])) {
                set_input('context', $page[1]);
            }
            if (isset($page[2])) {
                set_input('category_guid', $page[2]);
            }

            include($CONFIG->pluginspath . "hypeCategories/views/default/hypeCategories/view.php");
            break;
    }
}

// HANDLING CATEGORY ICONS
function category_icon_hook($hook, $entity_type, $returnvalue, $params) {

    global $CONFIG;
    if ((!$returnvalue) && ($hook == 'entity:icon:url') && ($params['entity'] instanceof ElggObject) && ($params['entity']->getSubtype() == 'category')) {

        $entity = $params['entity'];
        $size = $params['size'];
        $filehandler = new ElggFile();
        $filehandler->owner_guid = $entity->owner_guid;
        $filehandler->setFilename("category/" . $entity->guid . $size . ".jpg");

        $url = $CONFIG->url . "pg/category/icon/{$entity->guid}/{$size}/category.jpg";
        return $url;
    }
}

// ADDING CATEGORY TO A CONTENT ITEM ON SAVE
function hypeCategories_establish_relationship($event, $object_type, $object) {

    if ($object instanceof ElggObject && in_array($object->getSubtype(), string_to_tag_array(elgg_get_plugin_setting('allowed_object_types', 'hypeCategories')))) {

//Get edit/create form input
        $category_guid = get_input('relationship');

        if ($category_guid) {
//Remove existing relationships
            $relationships = get_entity_relationships($object->getGUID(), false);
            foreach ($relationships as $id => $relationship) {
                $relationship_reverse = get_entity($relationship['guid_two']);
                if ($relationship_reverse instanceof ElggObject && $relationship_reverse->getSubtype() == 'category') {
                    delete_relationship($relationship['id']);
                }
            }

//Establish new relationships
            $category = get_entity($category_guid);
            $check = true;
            while ($check == true) {
                add_entity_relationship($object->getGUID(), 'filed_in', $category->guid);
                $category = get_parent($category->guid);
                if (!$category) {
                    $check = false;
                }
            }
            $category_guid = '';
        }
    }

    return true;
}

// GROUP SUPPORT
function hypeCategories_establish_group_relationship($event, $object_type, $object) {

    if ($object instanceof ElggEntity && elgg_get_plugin_setting('allow_groups', 'hypeCategories') == 'yes') {
//Get edit/create form input
        $category_guid = get_input('relationship');

        if ($category_guid) {
            if (get_entity($category_guid)->container_guid == 1) {
//Remove existing relationships
//                $relationships = get_entity_relationships($object->getGUID(), false);
//                foreach ($relationships as $id => $relationship) {
//                    $relationship_reverse = get_entity($relationship['guid_two']);
//                    if ($relationship_reverse instanceof ElggEntity && $relationship_reverse->getSubtype() == 'category') {
//                        delete_relationship($relationship['id']);
//                    }
//                }
//Re-establish category hierarchy on group move
//                $children = get_children(get_item_categories($object->guid));
//                foreach ($children as $child) {
//                    if ($child->container_guid == $object->guid) {
//                        $relationships = get_entity_relationships($child->guid, false);
//                        foreach ($relationships as $relationship) {
//                            $relationship_type = $relationship->relationship;
//                            if ($relationship_type == 'child') {
//                                delete_relationship($relationship->id);
//                                add_entity_relationship($child->guid, 'child', $category_guid);
//
//                            }
//                        }
//                    }
//                }
//Establish new relationships
                $category = get_entity($category_guid);
                $check = true;
                while ($check == true) {
                    add_entity_relationship($object->getGUID(), 'filed_in', $category->guid);
                    $category = get_parent($category->guid);
                    if (!$category) {
                        $check = false;
                    }
                }
                $category_guid = '';
            } else {
                system_message(elgg_echo('hypeCategories:save:error:notsiteowned'));
            }
        }
    }

    return true;
}

register_elgg_event_handler('init', 'system', 'hypeCategories_init');
register_elgg_event_handler('pagesetup', 'system', 'hypeCategories_pagesetup');

register_elgg_event_handler('update', 'object', 'hypeCategories_establish_relationship');
register_elgg_event_handler('create', 'object', 'hypeCategories_establish_relationship');

register_elgg_event_handler('update', 'group', 'hypeCategories_establish_group_relationship');
register_elgg_event_handler('create', 'group', 'hypeCategories_establish_group_relationship');

include(dirname(__FILE__) . '/models/models.php');

if (!elgg_get_plugin_setting('migrated', 'hypeCategories'))
    migrate_categories();
?>