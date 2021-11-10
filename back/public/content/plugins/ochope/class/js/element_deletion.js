jQuery(document).on(
    'click',
    '.delete-button',
    function(event) {
        //alert("attention, vous allez supprimer un ingredient");

        const post_id = document.getElementById('dose-modify-button-'+no).dataset.postId;
        const ingredient_id = document.getElementById('dose-ingredient-'+no).value;
        const quantity = document.getElementById('dose-quantity-'+no).value;
        const unit = document.getElementById('dose-unit-select-'+no).value;
        
        jQuery.ajax({
            url: ajaxurl, 
            type: "POST", 
            data : {
                'action' : 'element_deletion',
                'post_id' : post_id,
                'ingredient_id' : ingredient_id
            }
        })
    }
);