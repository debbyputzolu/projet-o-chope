
jQuery(
    function($) {
        var $button = $('#add-row'), $row = $('.ingredient-rows').clone();

        $button.click(
            function() {
                $row.clone().insertBefore( $button );
            }
        );
    }
);

document.addEventListener("DOMContentLoaded", jQuery);
