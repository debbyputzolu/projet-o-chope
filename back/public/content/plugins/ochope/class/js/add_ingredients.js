jQuery(document).on(
    'click',
    '.addButton',
    function() {
        const post_id = document.getElementById('add-ingredient').dataset.postId;
        const name = document.getElementById('new-ingredient-name').value;
        
        jQuery.ajax({
            url: ajaxurl, 
            type: "POST", 
            data : {
                'action' : 'create_ingredient',
                'post_id' : post_id,
                'name' : name
            }
        }).done(
            function(response) {
                var inputIngredient = document.getElementById('new-ingredient-name');
                if( response.length < 3 ) {
                    inputIngredient.style.backgroundColor = 'green';
                    //console.log("insertion nouveau ingredient dans liste deroulante");
                    var insertion = document.getElementById('ingredient-list');
                    var option = document.createElement("option");

                    option.text = name;
                    option.value = name;
                    insertion.add(option,null);
                } else {
                    console.log(response);
                    inputIngredient.style.backgroundColor = 'red';
                }
            }
        );
    }
);