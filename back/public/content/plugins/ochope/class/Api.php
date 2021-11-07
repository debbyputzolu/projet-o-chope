<?php

namespace OChope;

use WP_REST_Request;
use WP_User;

class Api {

    protected $baseURI;

    public function __construct()
    {
        // Enregistrement de notre API Custom
        add_action('rest_api_init', [$this, 'ochope_api_initialize']);
    }

    public function ochope_api_initialize()
    {
        // récupération du nom d'un dossier depuis le chemin de fichier 
        // https://www.php.net/dirname
        $this->baseURI = dirname($_SERVER['SCRIPT_NAME']);

        // Création d'une route d'API

        register_rest_route(
            'ochope/v1', // le nom de notre API
            '/dose-save', // la route qui se mettra après le nom de notre api
            [
                // Attention, methods avec un S
                'methods' => 'post',
                'callback' => [$this, 'ochope_dose_save']  
            ]
        );

        register_rest_route(
            'ochope/v1', // le nom de notre API
            '/recipe-save', // la route qui se mettra après le nom de notre api
            [
                // Attention, methods avec un S
                'methods' => 'post',
                'callback' => [$this, 'ochope_recipe_save']  
            ]
        );

        register_rest_route(
            'ochope/v1', // le nom de notre API
            '/inscription', // la route qui se mettra après le nom de notre api
            [
                // Attention, methods avec un S
                'methods' => 'post',
                'callback' => [$this, 'ochope_inscription']  
            ]
        );
    }

    public function ochope_recipe_save(WP_REST_Request $request)
    {
        // première étape, récupération des éléments de ma nouvelle recette (qui sont en transit dans ma requête)
        
        $title = $request->get_param('title'); 
        $type = $request->get_param('type');
        $description = $request->get_param('description');
        $ingredients = $request->get_param('ingredients');

        // récupération de l'utilisateur ayant envoyé la requête
        $user = wp_get_current_user();
        //var_dump($user);die();
        if(
            in_array('brewer', (array) $user->roles) ||
            in_array('contributor', (array) $user->roles) ||
            in_array('administrator', (array) $user->roles))
        {
            $recipeCreateResult = wp_insert_post(
                [
                    'post_title' => $title,
                    'post_content' => $description,
                    'post_status' => 'publish',
                    'post_type' => 'recipe'
                ]
            );

            // si la recette a bien été crée
            // $recipeCreateResult va etre egal a l'id de cette dernière
            if(is_int($recipeCreateResult)){

                wp_set_post_terms(
                    $recipeCreateResult,
                    [$type], //todo faire l'experience : retirer les crochets pour vérifier si ce deuxieme argument peut bien etre de type string (https://developer.wordpress.org/reference/functions/wp_set_post_terms/)
                    'recipe-type'
                );

                wp_set_post_terms(
                    $recipeCreateResult,
                    $ingredients,
                    'ingredient'
                );
            }


            return [
                'success' => true,
                'title' => $title,
                'type' => $type,
                'description' => $description,
                'ingredients' => $ingredients,
                'user' => $user,
                'recipe-id'=> $recipeCreateResult

            ];


        }

        return [
            'success' => false,
        ];
        

    }

    public function ochope_dose_save(WP_REST_Request $request)
    {
        // première étape, récupération des éléments de ma nouvelle recette (qui sont en transit dans ma requête)
        
        $title = $request->get_param('recipeId'); 
        $type = $request->get_param('ingredientId');
        $description = $request->get_param('quantity');
        $ingredients = $request->get_param('unit');

        // récupération de l'utilisateur ayant envoyé la requête
        $user = wp_get_current_user();
        //var_dump($user);die();
        if(
            in_array('brewer', (array) $user->roles) ||
            in_array('contributor', (array) $user->roles) ||
            in_array('administrator', (array) $user->roles))
        {

        }

        return [
            'success' => false,
        ];
        

    }

    public function ochope_inscription(WP_REST_Request $request) {
        echo "hello";
        $email = $request->get_param('email');
        $password = $request->get_param('password');
        $userName = $request->get_param('username');

        echo "email  : " . $email . "<br>";
        echo "password  : " . $password . "<br>";
        echo "userName  : " . $userName . "<br>";

        $userCreateResult =  wp_create_user(
            $userName,
            $password,
            $email
        );

        if(is_int($userCreateResult)) {
            $user = new WP_User($userCreateResult);
            $user->remove_role('subscriber');
            $user->add_role('contributor');

            return [
                'success' => true,
                'userId' => $userCreateResult,
                'username' => $$userName,
                'email' => $email,
                'role' => 'contributor'
            ];


        } else {
            return [
                'success' => false,
                'error' => $userCreateResult
            ];
        }
    }


}
