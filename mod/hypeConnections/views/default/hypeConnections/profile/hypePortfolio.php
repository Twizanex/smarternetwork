<?php
if (isloggedin()) {
    $connection_type = 'u2u';
    $options = array(
        'type' => 'object',
        'subtype' => 'connection',
        'metadata_name_value_pairs' => array(array('name' => 'connection_type', 'value' => $connection_type),
            array('name' => 'entity_origin', 'value' => 'user')),
    );

    $connections = elgg_get_entities_from_metadata($options);

    if ($connections) :
        ?>
        <li id="hypeConnections_hypePortfolio_connections" view="hypeConnections/page/showconnections_hypePortfolio" title="Connections" class="portfolio_nav_extras left">
        </li>
        <?php
    endif;
    $connection_type = 'u2o';
    $options = array(
        'type' => 'object',
        'subtype' => 'connection',
        'metadata_name_value_pairs' => array(array('name' => 'connection_type', 'value' => $connection_type),
            array('name' => 'entity_origin', 'value' => 'user')),
    );

    $connections = elgg_get_entities_from_metadata($options);

    if ($connections) :
        ?>
        <li id="hypeConnections_hypePortfolio_links" view="hypeConnections/page/showconnections_hypePortfolio" title="Links" class="portfolio_nav_extras left">
        </li>
        <?php
    endif;

    $_SESSION['hypePortfolio']['hypeConnections_hypePortfolio_connections'] = array('entity' => $vars['entity'], 'connection_type' => 'u2u');
    $_SESSION['hypePortfolio']['hypeConnections_hypePortfolio_links'] = array('entity' => $vars['entity'], 'connection_type' => 'u2o');
    ?>
<?php } ?>