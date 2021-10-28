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
            [$this, 'createRecipePostType']
        );

        add_action(
            'init', 
            [$this, 'createIngredientCustomTaxonomy']
        );

        add_action(
            'init', 
            [$this, 'createRecipeTypeCustomTaxonomy']
        );

        add_action(
            'init', 
            [$this, 'createRecipeDifficultyCustomTaxonomy']
        );

        add_action(
            'add_meta_boxes',
            [$this,'global_notice_meta_box']
        );
    }
    
    public function global_notice_meta_box() {
        add_meta_box(
            'global-notice',
            __( 'Insérer une dose', 'sitepoint' ),
            [$this,'ochope_ingredientRecipe'],
            'recipe'
        );
    }

    public function ochope_ingredientRecipe( $post ) {

        // Add a nonce field so we can check for it later.
        wp_nonce_field( 'global_notice_nonce', 'global_notice_nonce' );
    
        $value = get_post_meta( $post->ID, '_global_notice', true );
    
        //echo '<textarea style="width:100%" id="global_notice" name="global_notice">' . esc_attr( $value ) . '</textarea>';

        ?>
            <table>
                <tr><td>Nom</td><td>Quantité</td><td>Unité</td></tr>
                <tr><td><select><option>Houblon</option><option>Orge</option></select></td><td><input type="number"></td><td><select><option>Cl</option><option>G</option></select></td></tr>
            </table>
        <?php
    }

    public function createRecipePostType()
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

    public function createIngredientCustomTaxonomy()
    {
        // Methode qui nous permet d'ajouter la Custom taxo "Ingredient"
        register_taxonomy(
            'ingredient',
            ['recipe'], // seul les recettes pourront avoir un/des ingredients
            [
                'label' => 'Ingrédient',
                'hierarchical' => true,
                'public' => true,
                'show_in_rest' => true
            ]
        );
    }

    public function createRecipeTypeCustomTaxonomy()
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

    public function createRecipeDifficultyCustomTaxonomy()
    {
        // Methode qui nous permet d'ajouter la Custom taxo "Difficulty"
        register_taxonomy(
            'difficulty',
            ['recipe'], // seul les recettes pourront avoir un/des ingredients
            [
                'label' => 'Difficulté',
                'hierarchical' => false,
                'public' => true,
                'show_in_rest' => true
            ]
        );
    }

    public function addCapAdmin()
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

    public function registerChefRole()
    {
        add_role(
            'brewer',
            'Brasseur'
        );
    }

    //! Pour ajouter/supprimer un role, je dois imperativement me situer dans activate/deactivate
    public function activate()
    {
        Recipe_Ingredient::createTable();
        // ajout du role chef
        $this->registerChefRole();
        // ajout cap sur CPT recipe pour admin
        $this->addCapAdmin();

    }

    public function deactivate()
    {
        // Suppression de la table custom
        Recipe_Ingredient::dropTable();
        // suppression du role chef
        remove_role('brewer');
    }
}

