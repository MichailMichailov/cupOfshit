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
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'volkonli_cup_bd' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3306' );

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
define( 'AUTH_KEY',         '2yVV^RSI_4A2(SXj;|%1wWa0)(VIc!zg&p2V0I(9;^a^5L}V(t-9BkblzFT0WKDE' );
define( 'SECURE_AUTH_KEY',  '+Cb~;1uKjz4;UgpPNoBIJbNT7jaXsu|j&Qq?}GzQ=x]wEd:B#`;;99}|uzkSjAY/' );
define( 'LOGGED_IN_KEY',    '?|4NnZ(Z*GNSsP_2M(|f10+lfKn$tx]J05NEz[Fhd#iNQm1_@8QBmB|]7uq%q:M[' );
define( 'NONCE_KEY',        '[_DejMN)<yb@40>lB|qVUnhG2&`5wO%7hObHLkq^#d1bq{HDh-m1<AQT4-.Y/*Z{' );
define( 'AUTH_SALT',        'dh{?vjZ1yXD]Q4=:vDL@VA?0a:wdSM^qb8<a,oE[]*J&Cn`okzQ@y{27MHfv{7C%' );
define( 'SECURE_AUTH_SALT', ' ZjV{tzZ1d<A+6j_:-^3Zpin[YT2*h 7NhP,i4:cVT4~^A~{jTN`IlK9q KlQ@p]' );
define( 'LOGGED_IN_SALT',   '+bPxu$IEcu  a7mh;7fGR1=0Y@H!0s+CnI=e3[jz#LV+?oBY-p?yztM&lZ#tVaCE' );
define( 'NONCE_SALT',       'r5Ju:R7DD7@[chv<Dum!wm=Gihceya7SPrW6Xk#^DhR.>u0PnRJF[$=259HkRV2L' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );
define( 'DISALLOW_FILE_MODS', true );
/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';