jQuery(document).on(
    'click',
    '#add-ingredient',
    function() {
        const post_id = document.getElementById('add-ingredient').dataset.postId;
        const name = document.getElementById('new-ingredient-name').value;
        
        jQuery.ajax({
            url: ajaxurl, 
            type: "POST", 
            data : {
                'action' : 'add_ingredient',
                'post_id' : post_id,
                'name' : name
            }
        }).done(
            function(response) {
                var inputIngredient = document.getElementById('add-ingredient');

                if( typeof response.term_id === 'undefined' ) {
                    inputIngredient.style.backgroundColor = 'red';
                } else {
                    inputIngredient.style.backgroundColor = 'green';
                    //console.log("insertion nouveau ingredient dans liste deroulante");

                    var insertion = document.getElementById('dose-ingredient-list');
                    var option = document.createElement("option");
                    option.text = name;
                    option.value = response.term_id;
                    insertion.add(option,null);
                }
            }
        );
    }
);