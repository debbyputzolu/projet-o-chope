jQuery(document).on(
    'click',
    '#dose-add-button',
    function() {
        const post_id = document.getElementById('dose-add-button').dataset.postId;
        const ingredient_id = document.getElementById('dose-ingredient-list-0').value;
        const quantity = document.getElementById('dose-quantity').value;
        const unit = document.getElementById('dose-unit-select').value;

        var row = document.getElementById('ingredient-rows');
        var row2 = row.cloneNode(true);

        for (var i = 0; i < row2.children[0].children[0].length; i++) {
            if( row2.children[0].children[0].children[i].value == ingredient_id ) {
                row2.children[0].children[0].children[i].selected = "selected";
                break;
            }
        }
        row2.children[1].children[0].value = quantity;
        row2.children[2].children[0].children[unit].selected = "selected";
        row2.children[3].children[0].value = "Modifier la dose";

        var elt = document.getElementById("dose-table");
        elt.append(row2);
        
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