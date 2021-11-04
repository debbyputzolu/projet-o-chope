jQuery(
    function($) {
        var $button = $('#add-ingredient');

        $button.click(
            function() {
                console.log("test 147");
                //var ingredientName = $(this).attr('ingredient').value;
                var ingredientName = document.getElementById('ingredient').value
                console.log(ingredientName);
                wp_insert_term( ingredientName, 'ingredient' );
                //var date_created = $("#addCommCreated_input_"+commitAddID).val();
            }
        );
    }
);

document.addEventListener("DOMContentLoaded", jQuery);
