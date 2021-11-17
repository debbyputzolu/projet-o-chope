jQuery(document).on(
    'click',
    '.delete-button',
    function(event) {
        var targetId = event.target.id + '';
        var concerned_element = null;
        var post_id = null;
        var ingredient_id = null;

        if( targetId == 'ingredient-delete-button' ) {
            concerned_element = 'ingredient';

            post_id = document.getElementById('ingredient-delete-button').dataset.postId;
            ingredient_id = document.getElementById('dose-ingredient-list').value;
        } else {
            concerned_element = 'dose';
            no = targetId.split('-').at(-1);

            post_id = document.getElementById('dose-modify-button-'+no).dataset.postId;
            ingredient_id = document.getElementById('dose-ingredient-'+no).value;
        }
        
        if (confirm('Etes vous sûr de vouloir supprimer cet ingrédient et toutes les doses qui en contiennent ?')) {
            jQuery.ajax({
                url: ajaxurl, 
                type: "POST", 
                data : {
                    'action' : 'delete_element',
                    'concerned_element' : concerned_element,
                    'post_id' : post_id,
                    'ingredient_id' : ingredient_id
                }
            }).done(
                function(response) {
                    if( concerned_element == 'ingredient' ) {
                        var ingredientList = document.getElementById("dose-ingredient-list");
    
                        for(i=0;i<ingredientList.childElementCount;i++) {
                            if( ingredientList.children[i].value == ingredient_id ) {
                                ingredientList.children[i].remove();
                                break;
                            }
                        }
                    }
    
                    var doseList = document.getElementById("dose-table").children[2];
    
                    for(i=0;i<doseList.childElementCount;i++) {
                        if( doseList.children[i].children[0].children[0].value == ingredient_id ) {
                            doseList.children[i].remove();
                            break;
                        }
                    }
    
                    var doseMessage = document.getElementById("dose-message");
                    if( doseList.childElementCount == 1 ) {
                        doseMessage.style = "";
                    } else {
                        doseMessage.style = "display:none;";
                    }
                }
            )

            return true;
        } else {
            return false;
        }
    }
);