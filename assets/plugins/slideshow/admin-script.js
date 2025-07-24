jQuery(document).ready(function ($) {
    var $tableBody = $('#the-list');
    var $messageContainer = $('<div id="save-order-message" class="updated notice is-dismissible" style="display: none;"></div>').insertAfter('.wrap h1');

    $tableBody.sortable({
        update: function (event, ui) {
            var order = $tableBody.sortable('toArray', { attribute: 'id' });
            var data = {
                action: 'slideshow_update_reorder',
                order: order,
                nonce: spAjax.ordering_nonce
            };

            $.post(spAjax.ajaxurl, data, function (response) {
                if (response.success) {
                    // Display success message
                    $messageContainer.text('Order saved successfully').show();
                    setTimeout(function () {
                        $messageContainer.fadeOut();
                    }, 3000);
                } else {
                    // Display error message
                    $messageContainer.text('An error occurred while saving the order').show().addClass('notice-error');
                }
            });
        }
    }).disableSelection();
});

jQuery(document).ready(function ($) {
    $('.sp-active-toggle').on('change', function () {
        var postId = $(this).data('post-id');
        var active = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: spAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'slideshow_toggle_active',
                post_id: postId,
                active: active,
                nonce: spAjax.status_nonce
            },
            success: function (response) {
                if (response.success) {
                    // Display success message
                    var $messageContainer = $('<div class="updated notice is-dismissible"><p>Active status updated successfully.</p></div>');
                    $('.wrap h1').after($messageContainer);
                    $messageContainer.delay(1000000).fadeOut(300, function () {
                        $(this).remove();
                    });
                } else {
                    // Display error message
                    var $messageContainer = $('<div class="error notice is-dismissible"><p>An error occurred while updating the active status.</p></div>');
                    $('.wrap h1').after($messageContainer);
                    $messageContainer.delay(1000000).fadeOut(300, function () {
                        $(this).remove();
                    });
                }
            }
        });
    });
});
