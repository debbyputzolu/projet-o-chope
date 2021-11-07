
/*jQuery(
    function($) {
        var $button = $('#add-row'), $row = $('.ingredient-rows').clone();

        $button.click(
            function() {
                $row.clone().insertBefore( $button );
            }
        );
    }
);

document.addEventListener("DOMContentLoaded", jQuery);*/

jQuery(document).on(
    'click',
    '#dose-add-button',
    function() {
        const post_id = document.getElementById('dose-add-button').dataset.postId;
        const ingredient_id = document.getElementById('dose-ingredient-list').value;
        const quantity = document.getElementById('dose-quantity').value;
        const unit = document.getElementById('dose-unit-select').value;
        
        jQuery.ajax({
            url: ajaxurl, 
            type: "POST", 
            data : {
                'action' : 'meta_menu',
                'post_id' : post_id,
                'ingredient_id' : ingredient_id,
                'quantity' : quantity,
                'unit' : unit
            }
        }).done(
            function(response) {
                var doseAddButton = document.getElementById('dose-add-button');

                console.log(response);

                if( response === 'failure' ) {
                    doseAddButton.style.backgroundColor = 'red';
                } else {
                    doseAddButton.style.backgroundColor = 'green';
                }
            }
        );
    }
);