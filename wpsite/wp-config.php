<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'FarmMarketWP' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root123456' );

/** Database hostname */
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
define( 'AUTH_KEY',         'Vy?V.Lwmb^zEGHYysxJ#p3HFlpkHPcXQeFK&GRzn2Bwc+V}Y:BK#J:2EL=_^?Dhb' );
define( 'SECURE_AUTH_KEY',  'y&$>!N:!j_j2+RId:l;AlPpAMpr3 VS)pTOOqGn)d&)CPy>X3y+=/7$.HN*rW/s:' );
define( 'LOGGED_IN_KEY',    '(K#aMh146 0;3p[ml>8+oS!RozU<&=v;B^+2d0iU?,bv>?[hW;Cr;WPV@Ir:Kqfj' );
define( 'NONCE_KEY',        '44tcvU<bhuz&C<?i-mwNh6Ie8jzpTqW{5crqr6=<X>Z@}aDKr<%9jWZDd[V UCNT' );
define( 'AUTH_SALT',        'B=uU~4W]`l0(A!e&Zge<`|HTh+cet/g{0u/6/e%ar-$l{7QWPM(P;%kWN9T VBb!' );
define( 'SECURE_AUTH_SALT', 'kb^okb3xIqZFCg.zmp$dE7?`De8orqkX;R.zZ,0d,,,9r[F>)PETEi]|L!Z#2+4E' );
define( 'LOGGED_IN_SALT',   'X:L:E 1w#%Pn=#w]U%{+u(:eeArbmRo9sPK2q^4G]5Vr1.0efG/As{i*Kz_.K8CO' );
define( 'NONCE_SALT',       'prWZXL*MdaZ?lga%:?a?5rrPHyylHd.y1Me7H?+}x+1=N $nX{pN%s>wk_hZZ)Fp' );

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */


define('FS_METHOD', 'direct');
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
