<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'students-in-tech_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Oko/^.v`SPkI(V|_iDpD^=a0FAEF-+4%H/<E~qt@~_=&m8c:l*fg4Zq>!hH}bVu[' );
define( 'SECURE_AUTH_KEY',  '<+$8$R++l$a6pPYshF>>h@j6(YsNK5q<.KfGg5% Z,L&`nN~d=&O_If uk<4.GH6' );
define( 'LOGGED_IN_KEY',    'v$iny{s`_A%~GyB0dJSWszKkqU|EBfMJy5zwVjw?q7aETF}3yUD4Vp89`zl|3;6C' );
define( 'NONCE_KEY',        'p/L`<aJk.I{?)s`aF$}cs#%vr&@==f3T&w_HeF0Wptv~wN md.EC4M@$P/[A}idH' );
define( 'AUTH_SALT',        '*JG(k_9s=X2G/]1w36vw$F8BtqhP]Fi.29@G:hm&E%j)4zR+RHyguzHPX V*)@jO' );
define( 'SECURE_AUTH_SALT', 'LsBfi38_Ah[4FS p0VFc1$Z%mYG=viau:&9C/Flu8@&zSG UU[et4)kF!u]- cCK' );
define( 'LOGGED_IN_SALT',   'db$]N.dk8pfA;gJ4h}0I(5pAMMSKYL3.U7R2qO2#zjxV9ReEtyGWFcv5ec:sEWA>' );
define( 'NONCE_SALT',       'QD8U.6`[^4?QL/2T4I)*!ea?UCR:lq/kVaN9Fs3yAOk>0<)-^<jBYc$Dyn=+H&sE' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
