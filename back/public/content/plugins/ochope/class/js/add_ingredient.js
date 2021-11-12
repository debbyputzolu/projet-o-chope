jQuery(document).on(
    'click',
    '#add-ingredient',
    function() {
        const name = document.getElementById('new-ingredient-name').value;
        
        jQuery.ajax({
            url: ajaxurl, 
            type: "POST", 
            data : {
                'action' : 'add_ingredient',
                'name' : name
            }
        }).done(
            function(response) {
                var inputIngredient = document.getElementById('add-ingredient');

                if( typeof response.term_id === 'undefined' ) {
                    inputIngredient.style.backgroundColor = 'red';

                    return false;
                } else {
                    inputIngredient.style.backgroundColor = 'green';

                    var insertion = document.getElementById('dose-ingredient-list');
                    var option = document.createElement("option");
                    option.text = name;
                    option.value = response.term_id;
                    insertion.add(option,null);
                }
            }
        );

        return true;
    }
);