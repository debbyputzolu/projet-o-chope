<?php
/**
 * Plugin Name: oChope
 */
use OChope\Plugin;
use OChope\Api;

require __DIR__ . '/vendor-ochope/autoload.php';
$oChope = new Plugin();
// On branche une methode sur l'activation du plugin
// J'utilise la notation [$monObjet, 'maMethode']
register_activation_hook(
    __FILE__,
    [$oChope, 'ochope_activate']
);
// On branche une methode sur l'desactivation du plugin
register_deactivation_hook(
    __FILE__,
    [$oChope, 'ochope_deactivate']
);
$api = new Api();
