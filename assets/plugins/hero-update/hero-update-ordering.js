jQuery(document).ready(function($) {
    $('#the-list').sortable({
        items: 'tr',
        cursor: 'move',
        axis: 'y',
        containment: 'parent',
        update: function(event, ui) {
            var order = $(this).sortable('toArray', { attribute: 'id' });
            var data = {
                action: 'hero_update_reorder',
                order: order,
                nonce: heroUpdateAjax.nonce
            };
            $.post(heroUpdateAjax.ajaxurl, data, function(response) {
                if (response.success) {
                    $('#message').remove();
                    $('.wrap h1').after('<div id="message" class="updated notice is-dismissible"><p>Order updated successfully.</p></div>');
                } else {
                    alert('There was an error updating the order.');
                }
            });
        }
    });
});
