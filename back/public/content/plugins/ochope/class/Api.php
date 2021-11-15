<?php

namespace OChope;

use WP_REST_Request;
use WP_User;
use Database\Recipe_Ingredient;

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

        register_rest_route(
            'ochope/v1', // le nom de notre API
            '/comment-save', // la route qui se mettra après le nom de notre api
            [
                // Attention, methods avec un S
                'methods' => 'post',
                'callback' => [$this, 'ochope_commentSave']  
            ]
        );

        register_rest_route(
            'ochope/v1', // le nom de notre API
            '/upload-image', // la route qui se mettra après le nom de notre api
            [
                // Attention, methods avec un S
                'methods' => 'post',
                'callback' => [$this, 'ochope_uploadImage']  
            ]
        );
    }

    public function ochope_recipe_save(WP_REST_Request $request)
    {
        // première étape, récupération des éléments de ma nouvelle recette (qui sont en transit dans ma requête)
        
        $title = $request->get_param('title'); 
        $type = $request->get_param('type');
        $description = $request->get_param('description');
        $doses = $request->get_param('doses');
        $imageId = $request->get_param('imageId');

        // récupération de l'utilisateur ayant envoyé la requête
        $user = wp_get_current_user();
        //var_dump($user->roles);die();
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
                foreach($doses as $dose) {

                    Recipe_Ingredient::ochope_insert($recipeCreateResult,$dose['ingredient'],$dose['quantity'],$dose['unit']);

                    wp_set_post_terms(
                        $recipeCreateResult,
                        [$dose['ingredient']],
                        'ingredient',
                        true
                    );
                }

                wp_set_post_terms(
                    $recipeCreateResult,
                    [$type], //todo faire l'experience : retirer les crochets pour vérifier si ce deuxieme argument peut bien etre de type string (https://developer.wordpress.org/reference/functions/wp_set_post_terms/)
                    'recipe-type'
                );

                //var_dump($ingredients);die();

                set_post_thumbnail(
                    $recipeCreateResult,
                    $imageId
                );

                $recipeCreated = get_post($recipeCreateResult);

                return $recipeCreated;
            }


            return [
                'success' => true,
                'title' => $title,
                'type' => $type,
                'description' => $description,
                'doses' => $doses,
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
        global $wpdb;
        $response = "failure";
        // première étape, récupération des éléments de ma nouvelle recette (qui sont en transit dans ma requête)
        
        $recipe_id = $request->get_param('recipeId'); 
        $ingredient_id = $request->get_param('ingredientId');
        $quantity = $request->get_param('quantity');
        $unit = $request->get_param('unit');


        $recipe_id = intval($recipe_id);
        $ingredient_id = intval($ingredient_id);
        $quantity = intval($quantity);
        $unit = sanitize_text_field($unit);

        // récupération de l'utilisateur ayant envoyé la requête
        $user = wp_get_current_user();
        //var_dump($user);die();
        if(
            in_array('brewer', (array) $user->roles) ||
            in_array('contributor', (array) $user->roles) ||
            in_array('administrator', (array) $user->roles) || true )
        {
            if( Recipe_Ingredient::ochope_insert($recipe_id,$ingredient_id,$quantity,$unit) == false ) {
                //$wpdb->show_errors();
                //$wpdb->hide_errors();
                $wpdb->print_error(); 

            } else {
                //var_dump("test");die();
                $response = "success";
            }
        }

        return [
            'success' => $response,
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
            $user->add_role('brewer');

            return [
                'success' => true,
                'userId' => $userCreateResult,
                'username' => $$userName,
                'email' => $email,
                'role' => 'brewer'
            ];


        } else {
            return [
                'success' => false,
                'error' => $userCreateResult
            ];
        }
    }

    public function ochope_commentSave(WP_REST_Request $request)
    {
        $comment = $request->get_param('comment');
        $recipeId = $request->get_param('recipeId');
        $user = wp_get_current_user();

        if (
            in_array( 'brewer', (array) $user->roles ) ||
            in_array( 'administrator', (array) $user->roles )
        ) {

            $commentSaveResult = wp_insert_comment([
                'user_id' => $user->ID,
                'comment_post_ID' => $recipeId,
                'comment_content' => $comment,
            ]
            );

            if(is_int($commentSaveResult)) {
                return [
                    'success' => true,
                    'recipe-id' => $recipeId,
                    'comment' => $comment,
                    'user' => $user,
                    'comment-id' => $commentSaveResult
                ];
            }
            else {
                return [
                    'success' => false
                ];
            }

        }
        else {
            return [
                'success' => false,
            ];
        }

    }
    public function ochope_uploadImage(WP_REST_Request $request)
    {

        // correspond au nom de la variable utilisée pour envoyer l'image
        $imageFileIndex = 'image';

        // récupération des informations concernant l'image uploadée
        $imageData = $_FILES[$imageFileIndex];

        // récupération du chemin fichier dans lequel est stockée l'image qui vient d'être uploadée
        $imageSource = $imageData['tmp_name'];

        // récupération es informations du dossier dans lequel wp stocke les fichiers uploadés
        $destination = wp_upload_dir();

        // dossier worpdress dans lequel nous allons stocker l'image
        $imageDestinationFolder = $destination['path'];

        // DOC nettoyage d'un nom de fichier avec wp https://developer.wordpress.org/reference/functions/sanitize_file_name/
        $imageName =  sanitize_file_name(
            md5(uniqid()) . '-' . // génération d'une partie aléatoire pour ne pas écraser de fichier existant
            $imageData['name']);
        $imageDestination = $imageDestinationFolder . '/' . $imageName;

        // on déplace le fichier uploadé dans le dossier de stokage de wp
        $success = move_uploaded_file($imageSource, $imageDestination);

        // si le déplacement du fichier à bien fonctionné
        if($success) {
            // récupération des informations dont wordpress a besoin pour identifier le type de fichier uploadé
            $imageType =  wp_check_filetype( $imageDestination, null);

            // préparation des informations nécessaires pour créer le media
            $attachment = array(
                'post_mime_type' => $imageType['type'],
                'post_title' => $imageName,
                'post_content' => '',
                'post_status' => 'inherit'
            );

            // on enregistre l'image dans wordpress
            $attachmentId = wp_insert_attachment( $attachment, $imageDestination );

            if(is_int($attachmentId)) {
                require_once( ABSPATH . 'wp-admin/includes/image.php' );

                // DOC on génère les metadatas pour le média https://developer.wordpress.org/reference/functions/wp_generate_attachment_metadata/
                $metadata = wp_generate_attachment_metadata( $attachmentId, $imageDestination );

                // on met à jour les metadata du media
                wp_update_attachment_metadata( $attachmentId, $metadata );

                return [
                    'status' => 'success',
                    'image' => [
                        'url' => $destination['url'] . '/' . $imageName,
                        'id' => $attachmentId
                    ]
                ];
            }
            else {
                return [
                    'status' => 'failed'
                ];
            }
        }

        return [
            'status' => 'failed'
        ];
    }
}
