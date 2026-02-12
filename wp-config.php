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
define( 'DB_NAME', 'pradeep' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         '(KzhW33-l]FT7`,5.4/%jl:zPH)6&K;]$o,?]+<z7Kfs2dFz%j@knU)hG(zlT%P}' );
define( 'SECURE_AUTH_KEY',  'UeYh(:>J7.O3@MUqi1c|j|Z__i49mB(<h;rMz}lVQm<5klCoVh@V_#cu|+>T?uP3' );
define( 'LOGGED_IN_KEY',    'DW#QTxb~o0ddE*&lx@k|lBCv$zX[Cg76?P`>XY&gN@w.+$%<w>vFtR@ycG*A?qTf' );
define( 'NONCE_KEY',        '8{z{,`PC7WT+BbO%qHrRP 7Aul3G:Qb`p~x[mtBr:+Ew)]^k.7gJ`u8CT!?8|+(Z' );
define( 'AUTH_SALT',        'g)c$LDjZc>y@*x)tV,?h=UyJ4;.{GdV:TD~~!`Q/N2BGg4_>{=b +xj`9),2Qa8v' );
define( 'SECURE_AUTH_SALT', '#lJeEe)g(>aFoCqzT(@14*zTKT!5X`tpEC@0ct:A:V&$tu:|r30*Il@ri4(I&qSg' );
define( 'LOGGED_IN_SALT',   '^K&s<d[^(RPOUF]g`NSs<1pf(l^>:{i(g6G5dlr1KRg~L^JsHnzWG!#hMc^9Y;( ' );
define( 'NONCE_SALT',       '&i,^=y|hP`}g6`VQx1JHT`T794MWqTq391}`mHeh|cvfl!!jvdy{_w4&A@-!KQHC' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
