<?php
admin_gatekeeper();

$connection = $vars['entity'];
if ($connection->entity_origin !== 'user') {
    $origin_icon_class = 'object-icon';
} else {
    $origin_icon_class = 'user-icon';
}
if ($connection->entity_target !== 'user') {
    $target_icon_class = 'object-icon';
} else {
    $target_icon_class = 'user-icon';
}
?>

<div class="search_listing">
    <div class="connection_origin left">
        <div class="top-layer">

        </div>
        <div class="middle-layer <?php echo $origin_icon_class ?> bg-right">

        </div>
        <div class="bottom-layer">
            <?php echo $connection->entity_origin ?><br>
            <b><?php echo $connection->direct_name ?></b><br>
            <?php
            if ($connection->limitation == 0) {
                $limitation = 'Unlimited';
            } else {
                $limitation = $connection->limitation;
            }

            echo sprintf(elgg_echo('hypeConnections:limitation'), $limitation, $connection->reverse_name, $connection->direct_name) ?>
        </div>
    </div>
    <div class="connection_connect left">
        <div class="top-layer connection_title">
            <?php echo $connection->title ?>
        </div>
        <div class="middle-layer connection-icon">
        </div>
        <div class="bottom-layer"></div>

    </div>
    <div class="connection_target left">
        <div class="top-layer">
        </div>
        <div class="middle-layer <?php echo $target_icon_class ?>"></div>
        <div class="bottom-layer">
            <?php echo $connection->entity_target ?><br>
            <b><?php echo $connection->reverse_name ?></b>
        </div>
    </div>
    <div class="clearfloat"></div>
    <div class="margined right">
        <div id="editButton" class="right margined button" guid="<?php echo $connection->guid ?>">
            <a href="javascript:void(0)"><?php echo elgg_echo('hypeConnections:admin:editbutton') ?></a>
        </div>
        <div id="deleteButton" class="button">
            <?php
            $url = $vars['url'] . 'action/connection/delete?guid=' . $connection->guid;
            $url = elgg_add_action_tokens_to_url($url);
            echo elgg_view('output/confirmlink', array(
                'text' => elgg_echo('hypeConnections:admin:deletebutton'),
                'confirm' => elgg_echo('hypeConnections:admin:deleteareyousure'),
                'href' => $url
            ));
            ?>
        </div>


        <div class="clearfloat"></div>
    </div>
    <div class="clearfloat"></div>
</div>