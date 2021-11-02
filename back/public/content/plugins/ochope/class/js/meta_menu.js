/*const meta = {
    init : function(){
        console.log("appelé")
        
        
        let add =  document.getElementById('add');
        //console.log(add);
        add.addEventListener('click', meta.teste );
    },
    teste: function(event){
        event.preventDefault();
        console.log("hello");
        var str = 
        '<div id="array_ingredient1">\
            <tr>\
                <td>\
                    <select id=\'test1\'>\
                    </select>\
                </td>\
                <td>\
                    <input type="number">\
                </td>\
                <td>\
                    <select>\
                        <option>L</option>\
                        <option>g</option>\
                        <option>unité</option>\
                    </select>\
                </td>\
            </tr>\
        </div>';
        var div = document.getElementById( 'array' );
        div.insertAdjacentHTML( 'beforeend', str );
        var select = document.getElementById( 'test1' );
        //select.innerHTML = '<?php foreach("$names" as "$name") { echo "<option>"; echo "$name"; echo "</option>"; } ?>';
        select.innerHTML = '<?php $v = 2; $v = $v * 8; echo "<option>";echo "$v";echo "</option>"; ?>';
        //select.innerHTML = '<?php echo "<option"; ?>';
    }
};



document.addEventListener("DOMContentLoaded", meta.init);*/

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
