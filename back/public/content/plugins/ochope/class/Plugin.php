<?php

namespace OChope;

use Database\Recipe_Ingredient;


class Plugin
{
    public function __construct()
    {
        // coté constructeur je vais placer tous mes add_action
        // ces derniers me permettent de brancher une methode sur un hook
        add_action(
            'init', 
            [$this, 'ochope_create_recipe_post_type']
        );

        add_action(
            'init', 
            [$this, 'ochope_create_ingredient_custom_taxonomy']
        );

        add_action(
            'init', 
            [$this, 'ochope_create_recipe_type_custom_taxonomy']
        );

        add_action(
            'add_meta_boxes',
            [$this,'ochope_metabox_recipe_data']
        );

        add_action(
            'admin_enqueue_scripts', 
            [$this,'ochope_pw_load_scripts']
        );

        /*
            scripts JS
        */
        add_action(
            'wp_ajax_add_ingredient',
            [$this, 'ochope_add_ingredient']
        );

        add_action(
            'wp_ajax_nopriv_add_ingredient',
            [$this, 'ochope_add_ingredient']
        );

        add_action(
            'wp_ajax_add_dose',
            [$this, 'ochope_add_dose']
        );

        add_action(
            'wp_ajax_nopriv_add_dose',
            [$this, 'ochope_add_dose']
        );

        add_action(
            'wp_ajax_modify_dose',
            [$this, 'ochope_modify_dose']
        );

        add_action(
            'wp_ajax_nopriv_modify_dose',
            [$this, 'ochope_modify_dose']
        );

        add_action(
            'wp_ajax_delete_element',
            [$this, 'ochope_delete_element']
        );

        add_action(
            'wp_ajax_nopriv_delete_element',
            [$this, 'ochope_delete_element']
        );
    }
    
    public function ochope_pw_load_scripts() {
        wp_enqueue_script( 'ochope-add_dose', plugins_url( 'class/js/add_dose.js' , dirname(__FILE__) ) , array('jquery') );
        wp_localize_script('ochope-add_dose', 'ajaxurl', array(admin_url('admin-ajax.php')));

        wp_enqueue_script( 'ochope-add_ingredient', plugins_url( 'class/js/add_ingredient.js' , dirname(__FILE__) ) , array('jquery') );
        wp_localize_script('ochope-add_ingredient', 'ajaxurl', array(admin_url('admin-ajax.php')));

        wp_enqueue_script( 'ochope-modify_dose', plugins_url( 'class/js/modify_dose.js' , dirname(__FILE__) ) , array('jquery') );
        wp_localize_script('ochope-modify_dose', 'ajaxurl', array(admin_url('admin-ajax.php')));

        wp_enqueue_script( 'ochope-delete_element', plugins_url( 'class/js/delete_element.js' , dirname(__FILE__) ) , array('jquery') );
        wp_localize_script('ochope-delete_element', 'ajaxurl', array(admin_url('admin-ajax.php')));
    }

    public function ochope_metabox_recipe_data() {
        add_meta_box(
            'ochope_recipe_parameters_control',
            __( 'Paramétrage de la recette', 'sitepoint' ),
            [$this,'ochope_ingredient_recipe'],
            'recipe'
        );
    }

    public function ochope_add_ingredient() {
        if (isset($_POST['post_id']) && isset($_POST['name']))
        {
            $name = sanitize_text_field($_POST['name']);
            $postId = intval($_POST['post_id']);

            $newTerm = wp_insert_term($name, 'ingredient');
        }

        wp_set_object_terms($postId,$newTerm['term_id'],'ingredient',true);

        wp_send_json($newTerm);

        wp_die();
    }

    public function ochope_add_dose() {
        global $wpdb;
        $response = "failure";

        if(isset($_POST['post_id']) && isset($_POST['ingredient_id']) && 0 < strlen($_POST['ingredient_id']) && isset($_POST['quantity']) && isset($_POST['unit']))
        {
            $recipe_id = intval($_POST['post_id']);
            $ingredient_id = intval($_POST['ingredient_id']);
            $quantity = intval($_POST['quantity']);
            $unit = sanitize_text_field($_POST['unit']);
            
            $result = Recipe_Ingredient::ochope_get_doses_of_a_recipe_and_ingredient($recipe_id,$ingredient_id);

            if( count($result) == 0 ) {
                if( Recipe_Ingredient::ochope_insert($recipe_id,$ingredient_id,$quantity,$unit) == false ) {
                    $wpdb->print_error(); 
                } else {
                    $response = "success";
                }
            }
        }

        echo $response;

        wp_die();
    }

    public function ochope_modify_dose() {
        global $wpdb;
        $response = "failure";

        if(isset($_POST['post_id']) && isset($_POST['ingredient_id']) && isset($_POST['quantity']) && isset($_POST['unit']))
        {
            $recipe_id = intval($_POST['post_id']);
            $ingredient_id = intval($_POST['ingredient_id']);
            $quantity = intval($_POST['quantity']);
            $unit = sanitize_text_field($_POST['unit']);

            $res = Recipe_Ingredient::ochope_get_doses_of_a_recipe_and_ingredient($recipe_id,$ingredient_id);
            
            if( $res[0]->quantity != $quantity || $res[0]->unit != $unit ) {
                if( Recipe_Ingredient::ochope_update($res[0]->id,$ingredient_id,$recipe_id,$quantity,$unit) ) {
                    $response = "success";
                }
            }
        }

        echo $response;

        wp_die();
    }

    public function ochope_delete_element() {
        global $wpdb;
        $response = "failure";

        if( isset($_POST['concerned_element']) && isset($_POST['post_id']) && isset($_POST['ingredient_id']) )
        {
            $recipe_id = intval($_POST['post_id']);
            $ingredient_id = intval($_POST['ingredient_id']);
            $concerned_element = $_POST['concerned_element'];

            $res = Recipe_Ingredient::ochope_get_doses_of_a_recipe_and_ingredient($recipe_id,$ingredient_id);

            for($i=0;$i<count($res);$i++) {
                Recipe_Ingredient::ochope_delete($res[$i]->id);
            }

            if( $concerned_element == 'ingredient' ) {
                wp_remove_object_terms($recipe_id,$ingredient_id,'ingredient');
                wp_delete_term($ingredient_id,'ingredient');
            }
        }

        echo $response;

        wp_die();
    }

    public function ochope_ingredient_recipe( $post ) {

        // Add a nonce field so we can check for it later.
        wp_nonce_field( 'global_notice_nonce', 'global_notice_nonce' );
    
        $value = get_post_meta( $post->ID, '_global_notice', true );

        $ingredientArgs = [
            'taxonomy' => 'ingredient',
            'hide_empty' => false
        ]; 
        $taxonomies = get_terms($ingredientArgs);
        $names = wp_list_pluck($taxonomies, 'name');
        $termsId = wp_list_pluck($taxonomies, 'term_id');
        $arrLength = count($names);
        $doses = Recipe_Ingredient::ochope_get_doses_of_a_recipe($post->ID);
        $arrLengthDoses = count($doses);
        $unitTable = array("cL","g","unité");

        //var_dump($doses[0]->id);die();

         ?>
            <table style="border:solid;">
                <caption>Ajout d'ingrédients</caption>
                <thead>
                    <th>Nom de l'ingredient</th>
                </thead>
                <tbody>
                    <tr> 
                        <td><input id="new-ingredient-name" type="text" name ="ing"></td>
                        <td><input type="button" id="add-ingredient" name="add-ingredient" value="Ajouter un ingrédient" data-post-id="<?= $post->ID ?>" ></td>
                    </tr>
                </tbody>
            </table>

            <table style="border:solid;">
                <caption>Ajout de doses</caption>
                <thead>
                    <th>Nom</th>
                    <th>Quantité</th>
                    <th>Unité</th>
                </thead>
                <tbody>
                    <tr id="ingredient-rows">
                        <td>
                            <select id="dose-ingredient-list" autocomplete="off">
                            <?php for($i = 0; $i < $arrLength; $i++) {
                                echo '<option value="'.$termsId[$i].'">';
                                    echo $names[$i];
                                echo '</option>';
                            } ?>
                            </select>
                            <input id="ingredient-delete-button" class="delete-button" type="button" name="ingredient-delete-button" value="X" data-post-id="<?= $post->ID ?>">
                        </td>
                        <td>
                            <input id="dose-quantity" type="number" name ="dose-quantity" style="width:70px;" min="1" ></input>
                        </td>
                        <td>
                            <select id="dose-unit-select" name="dose-unit-select">
                            <?php for($j = 0; $j < count($unitTable); $j++) {
                                echo '<option value="'.$j.'">'.$unitTable[$j].'</option>';
                            } ?>
                            </select>
                        </td>
                        <td><input id="dose-add-button" type="button" name="dose-add-button" value="Ajouter une dose" data-post-id="<?= $post->ID ?>" ></td>
                    </tr>
                </tbody>
            </table>
            
            <table id="dose-table" style="border:solid;">
                <caption>Doses</caption>
                <thead>
                    <th>Nom</th>
                    <th>Quantité</th>
                    <th>Unité</th>
                </thead>
                <tbody>
                <?php 
                    echo "<tr id='dose-message' ".( $arrLengthDoses == 0 ? "style=''" : "style='display:none;'" )."><td><p>Il n'y a pas de doses pour cette recette !</p></td></tr>";
                for($i = 0; $i < $arrLengthDoses; $i++) {
                    echo "<tr>";
                        echo "<td>";
                            for($j = 0; $j < $arrLength; $j++) {
                                if($termsId[$j] == $doses[$i]->ingredient_id) {
                                    echo "<data id='dose-ingredient-".($i+1)."' value='".$termsId[$j]."'>".$names[$j]."</data>";
                                }
                            }
                        echo "</td>";
                        echo "<td>";
                            echo "<input id='dose-quantity-".($i+1)."' type='number' name ='dose-quantity-".($i+1)."' value='".$doses[$i]->quantity."' style='width:70px;'>";
                        echo "</td>";
                        echo "<td>";
                            echo "<select id='dose-unit-select-".($i+1)."' name='dose-unit-select-".($i+1)."' autocomplete='off'>";
                            for($j = 0; $j < count($unitTable); $j++) {
                                echo '<option value="'.$j.'" '.( $j == $doses[$i]->unit ? 'selected="selected"' : '' ).'>'.$unitTable[$j].'</option>';
                            }
                            echo "</select>";
                        echo "</td>";
                        echo "<td><input id='dose-modify-button-".($i+1)."' class='dose-modify-button' type='button' name='dose-modify-button-".($i+1)."' value='Modifier la dose' data-post-id='".$post->ID."' ></td>";
                        echo "<td><input id='dose-delete-button-".($i+1)."' class='delete-button' type='button' name='dose-delete-button-".($i+1)."' value='X'></td>";
                    echo "</tr>";
                } 
                ?>
                </tbody>
            </table>
            
        <?php
            
    }

    public function ochope_create_recipe_post_type()
    {
        // Methode qui nous permet d'ajouter le CPT Recipe
        register_post_type(
            'recipe', // nom du cpt
            [
                'label' => 'Recette',
                'public' => true,
                'hierarchical' => false,
                'menu_icon' => 'dashicons-food',
                'supports' => [ // je définis les fonctionnalités dont va bénéficier le CPT
                    'title',
                    'thumbnail',
                    'editor',
                    'author',
                    'excerpt',
                    //! ATTENTION IL NE FAUT SURTOUT PAS OUBLIER D'aCTVIER la "feature" COMMENTS coté BO
                    'comments'    
                ],
                'capability_type' => 'recipe',
                'map_meta_cap' => true,

                //! Pour faire en sorte d'y avoir acces depuis l'api
                'show_in_rest' => true


            ]

            );  
    }

    public function ochope_create_ingredient_custom_taxonomy()
    {
        $labels = array(
            'name' => _x( 'Ingrédient', 'taxonomy general name' ),
            'singular_name' => _x( 'Ingrédient', 'taxonomy singular name' ),
            'search_items' =>  __( 'Chercher ingrédient' ),
            'all_items' => __( 'Tous les ingrédients' ),
            'parent_item' => __( 'Ingrédient parent' ),
            'parent_item_colon' => __( 'Ingrédient parent:' ),
            'edit_item' => __( 'Modifier l\'ingrédient' ), 
            'update_item' => __( 'Sauvegarder l\'ingrédient' ),
            'add_new_item' => __( 'Ajouter un nouvel ingrédient' ),
            'new_item_name' => __( 'Nouveau nom de l\ingrédient' ),
            'menu_name' => __( 'Ingrédients' ),
        );    
        // Methode qui nous permet d'ajouter la Custom taxo "Ingredient"
        register_taxonomy(
            'ingredient',
            ['recipe'], // seul les recettes pourront avoir un/des ingredients
            [
                'labels' => $labels,
                'hierarchical' => true,
                'public' => true,
                'show_in_rest' => true,
                'show_ui'                    => false,
                'show_in_quick_edit'         => false,
                'meta_box_cb'                => false,
            ]
        );
    }

    public function ochope_create_recipe_type_custom_taxonomy()
    {
        // Methode qui nous permet d'ajouter la Custom taxo "Type de recette"
        register_taxonomy(
            'recipe-type',
            ['recipe'], // seul les recettes pourront avoir un/des ingredients
            [
                'label' => 'Type de recette',
                'hierarchical' => false,
                'public' => true,
                'show_in_rest' => true
            ]
        );
    }

    public function ochope_add_cap_admin()
    {
        // methode qui nous permet d'ajouter les droits sur le CPT recipe pour le role administrateur
        //! Attention, sans cette opération le CPT recipe va disparaire
        //! en effet, nous avons définis un "capability_type" pour ce dernier
        //! et l'adminstrateur ne vas pas avoir automatiquement les droits 
        $role = get_role('administrator');
        $role->add_cap('delete_others_recipes');
        $role->add_cap('delete_private_recipes');
        $role->add_cap('delete_published_recipes');
        $role->add_cap('delete_recipes');
        $role->add_cap('edit_others_recipes');
        $role->add_cap('edit_private_recipes');
        $role->add_cap('edit_published_recipes');
        $role->add_cap('edit_recipes');
        $role->add_cap('publish_recipes');
        $role->add_cap('read_private_recipes');
    }

    public function ochope_register_brewer_role()
    {
        add_role(
            'brewer',
            'Brasseur'
        );
    }

    //! Pour ajouter/supprimer un role, je dois imperativement me situer dans activate/deactivate
    public function ochope_activate()
    {
        Recipe_Ingredient::ochope_create_table();
        // ajout du role chef
        $this->ochope_register_brewer_role();
        // ajout cap sur CPT recipe pour admin
        $this->ochope_add_cap_admin();

    }

    public function ochope_deactivate()
    {
        // Suppression de la table custom
        Recipe_Ingredient::ochope_drop_table();
        // suppression du role chef
        remove_role('brewer');
    }
}

