<?php

namespace OChope;

use Database\Recipe_Ingredient;


class Plugin
{
    const UNITS = array("L","g","unité");
         
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

        //executer ajax
        add_action(
            'wp_ajax_create_ingredient',
            [$this, 'ochope_create_ingredient']
        );

        //executer ajax
        add_action(
            'wp_ajax_nopriv_create_ingredient',
            [$this, 'ochope_create_ingredient']
        );

        //executer ajax
        add_action(
            'wp_ajax_meta_menu',
            [$this, 'ochope_meta_menu']
        );

        //executer ajax
        add_action(
            'wp_ajax_nopriv_meta_menu',
            [$this, 'ochope_meta_menu']
        );

        add_filter('rest_prepare_comment', [$this, 'custom_comment_author'], 10, 2 );
        add_filter('rest_pre_echo_response', [$this, 'addDoseDataToRecipe']);
    }

    function addDoseDataToRecipe($response) {
        //* Get the post ID
        $post_id = $response[ 'id' ];
      
        //* Make sure of the post_type
        //if( 'recipe' !== $response[ 'post' ] ) return;
      
        //* Do something with the post ID
        $ingredientsArgs = [
            'taxonomy'      => 'ingredient',
            'hide_empty'    => false
        ];
        
        $doses = Recipe_Ingredient::ochope_get_doses_of_a_recipe($post_id);
        $ingredients = get_terms($ingredientsArgs);
        $formattedDoses = [];
        foreach ($doses as $dose) {
            $dose->formatted_unit = self::UNITS[$dose->unit];
            $ingredientName = '';
            foreach ($ingredients as $ingredient) {
                if($ingredient->term_id == intval($dose->ingredient_id)) {
                    $ingredientName = $ingredient->name;
                    break;
                }
            }
            $dose->formatted_ingredient = $ingredientName;
            $formattedDoses[] = $dose;
        }
        $response['dose'] = $formattedDoses;
      
        //* Return the new response
        return $response;
      }
    
function custom_comment_author( $response, $comment ) {
    $userData = get_userdata($comment->user_id);
    $comment->comment_author = $userData->display_name;
    return $comment;
}
    
    public function ochope_pw_load_scripts() {
        wp_enqueue_script( 'ochope-meta_menu', plugins_url( 'class/js/meta_menu.js' , dirname(__FILE__) ) , array('jquery') );
        wp_localize_script('ochope-meta_menu', 'ajaxurl', array(admin_url('admin-ajax.php')));

        wp_enqueue_script( 'ochope-add_ingredients', plugins_url( 'class/js/add_ingredients.js' , dirname(__FILE__) ) , array('jquery') );
        wp_localize_script('ochope-add_ingredients', 'ajaxurl', array(admin_url('admin-ajax.php')));
    }

    public function ochope_metabox_recipe_data() {
        add_meta_box(
            'ochope_recipe_parameters_control',
            __( 'Paramétrage de la recette', 'sitepoint' ),
            [$this,'ochope_ingredient_recipe'],
            'recipe'
        );
    }

    public function ochope_create_ingredient() {
        if (isset($_POST['post_id']) && isset($_POST['name']))
        {
            $postId = intval($_POST['post_id']);
            $name = sanitize_text_field($_POST['name']);

            // wp_insert_term( string $term, string $taxonomy, array|string $args = array() )
            $newTerm = wp_insert_term($name, 'ingredient');
        }

        wp_send_json($newTerm);

        wp_die();
    }

    public function ochope_meta_menu() {
        global $wpdb;
        $response = "failure";

        if(isset($_POST['post_id']) && isset($_POST['ingredient_id']) && isset($_POST['quantity']) && isset($_POST['unit']))
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

        //var_dump($doses[0]->id);die();

         ?>
            <table>
                Ajout d'ingrédients
                <table style="border:solid;">
                    <tr>
                        <td>Nom de l'ingredient</td>
                    </tr>
                    <tr> 
                        <td><input id="new-ingredient-name" type="text" name ="ing"></td>
                        <td><input type="button" id="add-ingredient" name="add-ingredient" value="Ajouter un ingrédient" data-post-id="<?= $post->ID ?>" ></td>
                    </tr>
                </table>
            
                <table style="border:solid;">
                    Ajout de doses
                    <tr>
                        <td>Nom</td><td>Quantité</td><td>Unité</td>
                    </tr>
                    <tr class = "ingredient-rows">
                        <td>
                            <select id="dose-ingredient-list-0" class="dose-ingredient-list">
                            <?php for($i = 0; $i < $arrLength; $i++) {
                                echo '<option value="'.$termsId[$i].'">';
                                    echo $names[$i];
                                echo '</option>';
                            } ?>
                            </select>
                        </td>
                        <td>
                            <input id="dose-quantity" type="number" name ="dose-quantity">
                        </td>
                        <td>
                            <select id="dose-unit-select" name="dose-unit-select">
                                <?php foreach (self::UNITS as $key => $unit) : ?>
                                    <option value="<?= $key ?>"><?= $unit ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>https://developer.mozilla.org/fr/docs/Web/API/Node/cloneNode
                        <td><input id="dose-add-button" type="button" name="dose-add-button" value="Ajouter une dose" data-post-id="<?= $post->ID ?>" ></td>

                    </tr>
                </table>
            
                <table style="border:solid;">
                    Doses
                    <tr id="dose-list">
                        <td>Nom</td><td>Quantité</td><td>Unité</td>
                    </tr>
                <?php for($i = 0; $i < $arrLengthDoses; $i++) {
                    echo "<tr>";
                        echo "<td>";
                            echo "<select id='dose-ingredient-list-".($i+1)."' autocomplete='off' class='dose-ingredient-list'>";
                            for($j = 0; $j < $arrLength; $j++) {
                                echo '<option value="'.$termsId[$j].'" '.( $termsId[$j] == $doses[$i]->ingredient_id ? 'selected="selected"' : '' ).'>';
                                    echo $names[$j];
                                echo '</option>';
                            }
                            echo "</select>";
                        echo "</td>";
                        echo "<td>";
                            echo "<input id='dose-quantity' type='number' name ='dose-quantity' value='".$doses[$i]->quantity."'>";
                        echo "</td>";
                        echo "<td>";
                            echo "<select id='dose-unit-select' name='dose-unit-select' autocomplete='off'>";
                            for($j = 0; $j < count(self::UNITS); $j++) {
                                echo '<option value="'.$j.'" '.( $j == $doses[$i]->unit ? 'selected="selected"' : '' ).'>'.self::UNITS[$j].'</option>';
                            }
                            echo "</select>";
                        echo "</td>";
                        echo "<td><input id='dose-modify-button' type='button' name='dose-modify-button' value='Modifier la dose' data-post-id='".$post->ID."' ></td>";
                    echo "</tr>";
                } 
                if ( $arrLengthDoses == 0 ) {
                    echo "<tr><td><p>Il n'y a pas de doses pour cette recette !</p></td></tr>";
                } ?>
                </table>
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
                'show_in_rest' => true
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

