<?php
$origin_guid = $vars['origin_guid'];
$origin_entity = get_entity($origin_guid);
$target_guid = $vars['target_guid'];
$target_entity = get_entity($target_guid);

if ($origin_entity instanceof ElggUser && $target_entity instanceof ElggUser) {
    $connection_type = 'u2u';
    $origin_entity_subtype = 'user';
    $target_entity_subtype = 'user';
} elseif ($origin_entity instanceof ElggUser && $target_entity instanceof ElggObject) {
    $connection_type = 'u2o';
    $origin_entity_subtype = 'user';
    $target_entity_subtype = $target_entity->getSubtype();
} elseif ($origin_entity instanceof ElggObject && $target_entity instanceof ElggUser) {
    $connection_type = 'o2u';
    $origin_entity_subtype = $origin_entity->getSubtype();
    $target_entity_subtype = 'user';
} elseif ($origin_entity instanceof ElggObject && $target_entity instanceof ElggObject) {
    $connection_type = 'o2o';
    $origin_entity_subtype = $origin_entity->getSubtype();
    $target_entity_subtype = $target_entity->getSubtype();
}
$options = array(
    'types' => 'object',
    'subtypes' => 'connection',
    'metadata_names' => 'connection_type',
    'metadata_values' => $connection_type,
    'limit' => 9999
);

$connections = elgg_get_entities_from_metadata($options);
$connections_dropdown = array('0' => elgg_echo('hypeConnections:selectconnection'));
if (is_array($connections) && sizeof($connections) > 0) {
    foreach ($connections as $connection) {
        if ($connection->entity_origin == $origin_entity_subtype && $connection->entity_target == $target_entity_subtype) {
            $connections_dropdown[$connection->guid] = $connection->title;
        }
    }

    echo elgg_view('hypeConnections/js/add');
?>
    <div id="populateConnection">
        <form action="<?php echo $vars['url']; ?>action/connection/connect" method="post">
        <?php
        echo '<label>' . elgg_echo('hypeConnections:selectconnection') . '</label>';
        echo elgg_view('input/pulldown', array(
            'internalname' => 'direct_connection_guid',
            'options_values' => $connections_dropdown,
            'js' => "onchange=populateConnection($(this));"
        ));
        ?>
        <div class="connection_origin left">
            <div class="top-layer">
            </div>
            <div class="middle-layer">
                <?php
                $icon = elgg_view('profile/icon', array(
                            'entity' => $origin_entity,
                            'size' => 'medium',
                            'override' => true
                        ));

                if ($icon == '') {
                    $icon = '<img src="' . $vars['url'] . '_graphics/icons/default/medium.png" />';
                }

                echo $icon;
                ?>
                <div class="clearfloat"></div>
            </div>
            <div class="bottom-layer">
                <?php
                if ($origin_entity->title) {
                    echo $origin_entity->title;
                } else {
                    echo $origin_entity->name;
                    if ($origin_entity->name == get_loggedin_user()->name)
                        echo ' (' . elgg_echo('hypeConnections:you') . ')';
                }
                ?>
                <br>
                <div id="direct_connection_name">
                </div>
                <div id="direct_connection_values">
                    <?php
                    echo elgg_view('input/hidden', array(
                        'internalname' => 'origin_guid',
                        'value' => $origin_guid
                    ));
                    ?>
                </div>

            </div>
        </div>
        <div class="connection_connect left">
            <div class="top-layer connection_title">
            </div>
            <div class="middle-layer connection-icon">
            </div>
            <div class="bottom-layer"></div>
        </div>
        <div class="connection_target left">
            <div class="top-layer">
            </div>
            <div class="middle-layer">
                <?php
                    $icon = elgg_view('profile/icon', array(
                                'entity' => $target_entity,
                                'size' => 'medium',
                                'override' => true
                            ));

                    if ($icon == '') {
                        $icon = '<img src="' . $vars['url'] . '_graphics/icons/default/medium.png" />';
                    }

                    echo $icon;
                ?>
                    <div class="clearfloat"></div>
                </div>

                <div class="bottom-layer">
                <?php
                    if ($target_entity->title) {
                        echo $target_entity->title;
                    } else {
                        echo $target_entity->name;
                        if ($target_entity->name == get_loggedin_user()->name)
                            echo ' (' . elgg_echo('hypeConnections:you') . ')';
                    }
                ?>
                    <br>
                    <div id="reverse_connection_name">
                    </div>
                    <div id="reverse_connection_values">
                    <?php
                    echo elgg_view('input/hidden', array(
                        'internalname' => 'target_guid',
                        'value' => $target_guid
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div class="clearfloat"></div>
        <div class="margined">
            <?php
                    echo elgg_view('input/securitytoken');
                    echo elgg_view('input/submit', array('value' => 'Connect'));
            ?>
                </div>

            </form>
            <div class="clearfloat"></div>
        </div>

<?php } ?>
