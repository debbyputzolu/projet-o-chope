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

                if( response === 'failure' ) {
                    doseAddButton.style.backgroundColor = 'red';
                } else {
                    doseAddButton.style.backgroundColor = 'green';

                    //"cachage" du message "pas de doses" si nécessaire
                    var mes = document.getElementById('dose-message');
                    mes.style.display = "none";

                    //recuperation de la ligne "ajout d'une dose" qui sert de model pour notre ligne "dose"
                    var row = document.getElementById('ingredient-rows');
                    var newDose = row.cloneNode(true);

                    //remplcement du select ingredient par un texte avec 1 ingredient
                    newDose.children[0].children[0].remove();
                    newDose.children[0].children[0].remove();
                    var data = document.createElement("data");
                    data.value = ingredient_id;
                    var getNameIngredient = document.getElementById("dose-ingredient-list");
                    data.textContent = getNameIngredient.options[getNameIngredient.selectedIndex].text;
                    var nb = document.querySelectorAll('data').length + 1;
                    data.id = 'dose-ingredient-'+nb;
                    ronewDosew2.children[0].append(data);

                    newDose.children[1].children[0].id = 'dose-quantity-'+nb;
                    newDose.children[1].children[0].value = quantity;

                    newDose.children[2].children[0].id = 'dose-unit-select-'+nb;
                    newDose.children[2].children[0].children[unit].selected = "selected";

                    newDose.children[3].children[0].id = 'dose-modify-button-'+nb;
                    newDose.children[3].children[0].value = "Modifier la dose";
                    newDose.children[3].children[0].className = 'dose-modify-button';

                    var rowAdd = document.createElement("td");
                    var btn = document.createElement("button");
                    btn.innerHTML = "X";
                    
                    rowAdd.appendChild(btn);
                    newDose.appendChild(rowAdd);

                    newDose.children[4].children[0].id = 'dose-delete-button-'+nb;
                    newDose.children[4].children[0].name = 'dose-delete-button-'+nb;
                    newDose.children[4].children[0].className = 'delete-button';
            
                    var elt = document.getElementById("dose-table");
                    elt.append(newDose);
                }
            }
        );
    }
);
