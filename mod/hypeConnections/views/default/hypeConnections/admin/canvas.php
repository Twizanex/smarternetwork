<div id="connectionsWrapper">
    <?php
    echo elgg_list_entities(array(
        'type' => 'object',
        'subtype' => 'connection'
    ));
    ?>
</div>
<div id="jsWrapper">
    <div id="addButton" class="right">
        <?php echo elgg_view('input/button', array('value' => elgg_echo('hypeConnections:admin:addbutton'))); ?>
    </div>
</div>
<div id="modalWrapper">
    <div id="modalContent">

    </div>
</div>