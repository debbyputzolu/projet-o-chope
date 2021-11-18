<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ochope' );

/** MySQL database username */
define( 'DB_USER', 'ochope' );

/** MySQL database password */
define( 'DB_PASSWORD', 'ochope' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'iD#6W&(h6ZnpQIia!3pM^ 5-Dpi)}qmiV0ZNYoL!tL-@EVf-^C_G<^!m)~cumeOJ' );
define( 'SECURE_AUTH_KEY',  'u84Un?S*[;y?}Y`}>LdOro-2y`!Qj)MQ#lMSC~Q$`gGaa,q}kpUJ}-*kLr<FQ|ts' );
define( 'LOGGED_IN_KEY',    'N;+y#SzW~jWTHw|TEIJkO^K`*jZsJI09TXr)fSD@6o!!x`L}1hx99V-&@n=}H:Oh' );
define( 'NONCE_KEY',        'Y!vW7O,E-d9&)V:X&#oHr<}>0Ka63$kJ:+jf|*v;;vlpG@;vhD9R$o@?H@<P.k.P' );
define( 'AUTH_SALT',        'E!4]lU8>H`!!`E--@:,@/qt;X{TXFF= ?%bM9?ri6K(Aa*Jr|d}$9l|Wl|Cowi.]' );
define( 'SECURE_AUTH_SALT', 'Iic<epqt_PI*,[K )c$Q^+m=$-&hos:pq,&E4H]R I4hLL{rD-08D]Ooq 0<9{qO' );
define( 'LOGGED_IN_SALT',   '9vKDa5NTO)!@Jo8okR`uF7#n[xhqAh;D]Pr%}seG/OC_a!PWnzQ3OU,WQQ/196T^' );
define( 'NONCE_SALT',       'VMa!1Q)|]z}l8TH[LKAMu!o5uF87oci{t5DPeP8(8;JcN:.tjVi,|[FjM)GNtFm7' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */

define('WP_HOME', rtrim ( 'http://localhost/valkyrie/apotheose/ochope/back/public', '/' ));

// nous spécifions dans quel dossier sont installés les fichiers de wordpress
define('WP_SITEURL', WP_HOME . '/wp');

define('WP_CONTENT_URL', WP_HOME . '/content');
define('WP_CONTENT_DIR', __DIR__ . '/content');

define('FS_METHOD','direct');
define('JWT_AUTH_CORS_ENABLE', true);

define('JWT_AUTH_SECRET_KEY', 'r_q!qXPYbCF,k4)W9/{Z(Lp+|Ruj*>Vx3qRXezE{5g>=YkZ4#l-wU};Dw#t&yQYI');
	
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
