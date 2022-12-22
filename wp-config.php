<?php
define( 'WP_CACHE', true ); // Added by WP Rocket


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

// ** MySQL settings - You can get this info from your web host** //
/** The name of the database for WordPress */
define( 'DB_NAME', '' );

/** MySQL database username */
define( 'DB_USER', '' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'c=}^4w7._wHvp]^Dxv6y &~%a#OOjNV:EUNu5xzO8{iX:=U<h8WhOQ48VM+ffRw[' );
define( 'SECURE_AUTH_KEY',  'zq@Zcfr.p%cAncD :#nU/lZDZ[}:[`j4]A;K@Gpzg_nZXYbkUg!jLM@?rrx-Ehsu' );
define( 'LOGGED_IN_KEY',    'SJT5QtmIj~<w@(N4QHsL tcOjNeWKWJ&IJ] d@dfIs:!O]g,CRb4|.}l,mM~|[{{' );
define( 'NONCE_KEY',        'vfOS[ty@CqIx(>&(^6/fDPnMSFx4ydnt0~,2MPSJ]gcA.`9%%C6sF]||4LcD}_dg' );
define( 'AUTH_SALT',        '>e}~1Nj#bcZbup:Vu):Ibp_eCwazU_&N~ plO:B6 0lu, pU-6/X]}<Ukg+e<b@b' );
define( 'SECURE_AUTH_SALT', 'p|iO+}(J~X*:7=LBfxPRU0]jD>@GYy(,>$^;~xS9Wef: ky3S8;w.|3_izyG,tWS' );
define( 'LOGGED_IN_SALT',   'D`o.`~l&SaXCWdW?)F#r}.JOmB`xP4<QWn<I=xBhh{:s;]CXoq-30;nN3.zxOpB+' );
define( 'NONCE_SALT',       'ma:-Z(6&-p{[X4!AN^GN{~,~Dn]_]PDH7g=.E#@^pbLPQn6`)tIeN9H~~g9@I]nP' );

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
