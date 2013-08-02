<script type="text/javascript">
    function getConnectForm(modalContent, origin_guid, target_guid) {
        $.ajax ({
            url: '<?php echo elgg_add_action_tokens_to_url($vars['url'] . 'action/connection/actions') ?>',
            type: 'POST',
            dataType: 'html',
            data: {
                origin_guid: origin_guid,
                target_guid: target_guid,
                action_type: 'connect_form'
            },
            success: function(data) {
                modalContent.html(data);
            }
        });
    };

    function getObjectConnectForm(modalContent, origin_guid) {
        $.ajax ({
            url: '<?php echo elgg_add_action_tokens_to_url($vars['url'] . 'action/connection/actions') ?>',
            type: 'POST',
            dataType: 'html',
            data: {
                origin_guid: origin_guid,
                action_type: 'object_connect_form'
            },
            success: function(data) {
                modalContent.html(data);
            }
        });
    };

    function getObjectsDropdown(group) {
        var formWrapper = $('#populateObjectConnections');
        var selection = $(group, formWrapper).val();
        var objectsDropdown = $('#objectsDropdown', formWrapper);
        var populationExtras = $('#populationExtras');

        if (selection !== '0') {
            objectsDropdown.html($('#'+selection+'_options', populationExtras).html());
            $('select[name=objectDropdown]', objectsDropdown).selectmenu({style:'popup'});
        } else {
            alert('Your selection is invalid');
        }
    }

    function passTargetGuid(target) {
        var formWrapper = $('#populateObjectConnections');
        var target_guid = target.val();
        var origin_guid = formWrapper.attr('origin_guid');
        var modalWrapper = formWrapper.parent('div');
        var ajax_loader = '<div class="ajax_loader"></div>';

        if (target_guid !== '0') {
            modalWrapper.html(ajax_loader);
            getConnectForm(modalWrapper, origin_guid, target_guid);
        } else {
            alert('Your selection is invalid');
        };
    }
    function populateConnection(source) {

        var connection = $('option:selected', source).text();

        var names = new Array();
        names = connection.split("-");

        var direct_name = names[0];
        var reverse_name = names[1];

        var target = $('#populateConnection');
        var target_direct_container = $('#direct_connection_name', target);
        var target_reverse_container = $('#reverse_connection_name', target);

        target_direct_container.html(direct_name);
        target_reverse_container.html(reverse_name);

        return true;
    }

    function bindConnectButton() {
        // new form button
        var modalWrapper = $('#modalWrapper');
        var modalContent = $('#modalContent');
        var ajax_loader = '<div class="ajax_loader"></div>';
        var connect_button = $('div.user_menu_connect');
        connect_button.each(function(){
            $(this).click(function() {
                modalWrapper.dialog({modal:true});
                modalContent.html(ajax_loader);
                if ($(this).attr('target_guid') !== '') {
                    getConnectForm(modalWrapper, $(this).attr('origin_guid'), $(this).attr('target_guid'));
                } else {
                    getObjectConnectForm(modalWrapper, $(this).attr('origin_guid'));
                }
            });
        });
    }

    $(document).ready(function(){     
        bindConnectButton();
    });
</script>