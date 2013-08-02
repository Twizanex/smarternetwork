<script type="text/javascript">

    // defining necessary functions
    function getNewForm(modalContent) {
        $.ajax ({
            url: '<?php echo elgg_add_action_tokens_to_url($vars['url'] . 'action/connection/actions') ?>',
            type: 'POST',
            dataType: 'html',
            data: {
                action_type: 'new'
            },
            success: function(data) {
                modalContent.html(data);
            }
        });
    };

    function getEditForm(modalContent, guid) {
        $.ajax ({
            url: '<?php echo elgg_add_action_tokens_to_url($vars['url'] . 'action/connection/actions') ?>',
            type: 'POST',
            dataType: 'html',
            data: {
                guid: guid,
                action_type: 'edit'
            },
            success: function(data) {
                modalContent.html(data);
            }
        });
    };
    function deleteConnection(modalContent, guid) {
        $.ajax ({
            url: '<?php echo elgg_add_action_tokens_to_url($vars['url'] . 'action/connection/actions') ?>',
            type: 'POST',
            dataType: 'html',
            data: {
                guid: guid,
                action_type: 'delete'
            },
            success: function(data) {
                modalContent.html(data);
            }
        });
    };

    function getConnectionTypeObjects(pulldown) {
        // get the correct set of pulldown values for connection type pulldown
        var connection_target = $('#connection_target'),
            connection_origin = $('#connection_origin'),
            u_origin = $('#u_origin').html(),
            u_target = $('#u_target').html(),
            o_origin = $('#o_origin').html(),
            o_target = $('#o_target').html();


        if (pulldown.val() == 'u2u') {
            connection_origin.html(u_origin);
            connection_target.html(u_target);
        } else if (pulldown.val() == 'u2o') {
            connection_origin.html(u_origin);
            connection_target.html(o_target);
        } else if (pulldown.val() == 'o2u') {
            connection_origin.html(o_origin);
            connection_target.html(u_target);
        } else if (pulldown.val() == 'o2o') {
            connection_origin.html(o_origin);
            connection_target.html(o_target);
        }
    }

    $(document).ready(function(){

        // global variables
        var content = $('#connectionsWrapper');
        var canvas = $('#jsWrapper');
        var modalWrapper = $('#modalWrapper');
        var modalContent = $('#modalContent');
        var ajax_loader = '<div class="ajax_loader"></div>';

        // new form button
        var add_button = $('#addButton', canvas);
        add_button.click(function() {
            modalWrapper.dialog({modal:true});
            modalContent.html(ajax_loader);
            getNewForm(modalWrapper);
        });

        var edit_button = $('#editButton', content);
        edit_button.each(function() {
            $(this).click(function(){
                modalWrapper.dialog({modal:true});
                modalContent.html(ajax_loader);
                getEditForm(modalWrapper, $(this).attr('guid'));
            });
        });
    });

</script>
