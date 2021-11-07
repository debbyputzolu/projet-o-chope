<?php
namespace Database;

class Recipe_Ingredient
{
    // Gere la création de la table
    public static function ochope_create_table()
    {
        global $wpdb;
        // Nom de la table custom
        $table_name = "wp_ochope_recipe_ingredient";
        // Charset de la table
        $charset = $wpdb->get_charset_collate();

        // SQL pour creation de la table
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            ingredient_id mediumint(9) NOT NULL,
            recipe_id mediumint(9) NOT NULL,
            quantity mediumint(9) NOT NULL,
            unit char(10) NOT NULL,
            PRIMARY KEY (id)
        ) $charset;";

        // Execution de la requete SQL
        // Chargement de la fonctionnalité dbDelta
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    // Gere la suppression de la table
    public static function ochope_drop_table()
    {
        global $wpdb;
        $table_name = "wp_ochope_recipe_ingredient";
        $wpdb->query("DROP TABLE IF EXISTS $table_name");
    }

    public static function ochope_insert($recipe_id,$ingredient_id,$quantity,$unit) {
        global $wpdb;

        // we insert a link between recipe and ingredient in recipeIngredient table
        $table_name = "wp_ochope_recipe_ingredient";
        return $wpdb->insert(
            $table_name,
            [
                'ingredient_id' => $ingredient_id,
                'recipe_id' => $recipe_id,
                'quantity' => $quantity,
                'unit' => $unit
            ]
        );
    }

    public function ochope_delete($id)
    {
        $where = [
            'id' => $id
        ];
        
        $this->database->delete(
            'wp_ochope_recipe_ingredient',
            $where
        );
    }
    
    public function ochope_update($id,$ingredient_id,$recipe_id,$quantity,$unit)
    {
        $data = [
            'ingredient_id' => $ingredient_id,
            'recipe_id' => $recipe_id,
            'quantity' => $quantity,
            'unit' => $unit
        ];

        $where = [
            'id' => $id
        ];

        $this->database->update(
            'wp_ochope_recipe_ingredient',
            $data,
            $where
        );
    }
}
