<?php

function hypeConnections_init() {
    global $CONFIG;

    if (!is_plugin_enabled('hypeFramework')) {
        register_error('hypeFramework is not enabled. hypeConnections will not work properly. Visit www.hypeJunction.com for details');
    }

    register_action('connection/save', false, $CONFIG->pluginspath . 'hypeConnections/actions/save.php', true);
    register_action('connection/delete', false, $CONFIG->pluginspath . 'hypeConnections/actions/delete.php', true);
    register_action('connection/connect', false, $CONFIG->pluginspath . 'hypeConnections/actions/connect.php', false);
    register_action('connection/disconnect', false, $CONFIG->pluginspath . 'hypeConnections/actions/disconnect.php', false);
    register_action('connection/actions', false, $CONFIG->pluginspath . 'hypeConnections/actions/actions.php', false);

    elgg_extend_view('css', 'hypeConnections/css/css');
    elgg_extend_view('profile/menu/actions', 'hypeConnections/profile/menu');
    //elgg_extend_view('profile/status', 'hypeConnections/page/showsummary');
    elgg_extend_view('categories/view', 'hypeConnections/page/showsummary');
    elgg_extend_view('page/default', 'hypeConnections/profile/modal');
    elgg_extend_view('hypePortfolio/navigation_extras', 'hypeConnections/profile/hypePortfolio');
    //elgg_extend_view('hypePortfolio/portfolioextras', 'hypeConnections/page/elements/adminlinks');
    //extend_view('hypePortfolio/userdetails', 'hypeConnections/profile/menu');
    elgg_extend_view('hypePortfolio/portfolioextras', 'hypeConnections/profile/buttons/connect');
    register_plugin_hook('hypeCompanies:companytabs:hypeconnections', 'all', 'hypeConnections_tabs');
    register_plugin_hook('hype:tabs:ajaxsuccess', 'all', 'hypeConnections_ajax');
    register_plugin_hook('hype:portfolio:ajaxsuccess:getdetails', 'all', 'hypeConnections_ajax');
    register_page_handler('connections', 'hypeConnections_page_handler');

    elgg_extend_view('hypeConnections/page/showfeed', 'hypeComments/js/canvas');
}

function hypeConnections_pagesetup() {
    global $CONFIG;

//add submenu options
    if (elgg_get_context() == "admin") {
        elgg_register_menu_item(elgg_echo('hypeConnections:adminlink'), $CONFIG->wwwroot . "pg/connections/admin", 'hype');
    }
}

function hypeConnections_page_handler($page) {
    global $CONFIG;

    if (isset($page[0])) {

        switch ($page[0]) {
            case 'admin' :
                include($CONFIG->pluginspath . 'hypeConnections/admin/manage.php');
                break;

            case 'view' :
                set_input('origin_guid', $page[1]);
                include($CONFIG->pluginspath . 'hypeConnections/views/default/hypeConnections/page/view.php');
                break;

            case 'add' :
                if (isset($page[1])) {
                    if ($page[1] == 'user') {
                        set_input('target_guid', $page[2]);
                        include($CONFIG->pluginspath . 'hypeConnections/views/default/hypeConnections/pages/user/add.php');
                    } elseif ($page[1] == 'object') {
                        set_input('target_guid', $page[2]);
                        include($CONFIG->pluginspath . 'hypeConnections/views/default/hypeConnections/pages/object/add.php');
                    }
                } else {
                    register_error(elgg_echo('hypeConnections:generalerror'));
                    forward($_SERVER['HTTP_REFERER']);
                }
        }
    } else {
        register_error(elgg_echo('hypeConnections:generalerror'));
        forward($_SERVER['HTTP_REFERER']);
    }
}

function hypeConnections_tabs($hook, $entity_type, $returnvalue, $params) {
    global $CONFIG;
    $TabsArray = $params['current'];
    $company = get_entity(get_input('company_guid'));

    $connection_type = 'o2u';
    $options = array(
        'type' => 'object',
        'subtype' => 'connection',
        'metadata_name_value_pairs' => array(array('name' => 'connection_type', 'value' => $connection_type),
            array('name' => 'entity_origin', 'value' => 'company')),
    );

    $connections = elgg_get_entities_from_metadata($options);
    if ($connections) {
        $TabsArray['network'] = array('id' => 'company_network', 'name' => elgg_echo('hypeConnections:tab:network'), 'view' => 'hypeConnections/page/showconnections', 'vars' => array('entity' => $company, 'connection_type' => 'o2u'));
        $TabsArray['newsfeed'] = array('id' => 'company_newsfeed', 'name' => elgg_echo('hypeConnections:tab:newsfeed'), 'view' => 'hypeConnections/page/showfeed', 'vars' => array('entity' => $company));
    }
    $connection_type = 'o2o';
    $options = array(
        'type' => 'object',
        'subtype' => 'connection',
        'metadata_name_value_pairs' => array(array('name' => 'connection_type', 'value' => $connection_type),
            array('name' => 'entity_origin', 'value' => 'company')),
    );

    $connections = elgg_get_entities_from_metadata($options);
    if ($connections) {
        $TabsArray['briefcase'] = array('id' => 'company_briefcase', 'name' => elgg_echo('hypeConnections:tab:briefcase'), 'view' => 'hypeConnections/page/showconnections', 'vars' => array('entity' => $company, 'connection_type' => 'o2o'));
    }
    return $TabsArray;
}

function hypeConnections_ajax($hook, $entity_type, $returnvalue, $params) {
    return 'bindConnectButton();';
}

register_elgg_event_handler('init', 'system', 'hypeConnections_init');
register_elgg_event_handler('pagesetup', 'system', 'hypeConnections_pagesetup');

include_once(dirname(__FILE__) . '/models/model.php');
?>