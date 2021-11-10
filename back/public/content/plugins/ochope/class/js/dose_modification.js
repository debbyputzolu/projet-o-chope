jQuery(document).on(
    'click',
    '.dose-modify-button',
    function(event) {
        var no = event.target.id + '';
        no = no.split('-').at(-1);

        const post_id = document.getElementById('dose-modify-button-'+no).dataset.postId;
        const ingredient_id = document.getElementById('dose-ingredient-'+no).value;
        const quantity = document.getElementById('dose-quantity-'+no).value;
        const unit = document.getElementById('dose-unit-select-'+no).value;
        
        jQuery.ajax({
            url: ajaxurl, 
            type: "POST", 
            data : {
                'action' : 'dose_modification',
                'post_id' : post_id,
                'ingredient_id' : ingredient_id,
                'quantity' : quantity,
                'unit' : unit
            }
        }).done(
            function(response) {
                button = document.getElementById('dose-modify-button-'+no);

                if( response === 'failure' ) {
                    button.style.backgroundColor = 'red';
                } else {
                    button.style.backgroundColor = 'green';
                }
            })

    }
);