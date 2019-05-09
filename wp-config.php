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
define( 'AUTH_KEY',         'evqSw/yl(u_z25eS:5^KNc9f1rmIVMQ{WgF>D9w0VN8014?] ~+&FO![c8m?Ia`[' );
define( 'SECURE_AUTH_KEY',  'u?qT7HLK.QjURZSOE?G?[-80GwBN?e&P#a;c|vGTsn+#G<v4Bh/(4}aH*-(UI$;N' );
define( 'LOGGED_IN_KEY',    'viVQ#Y2_Wbsnx#?t=A9 [hV<sw}W_A;Dm5 DNawe5u`-MH !<e9Vw!^li@LOdbLy' );
define( 'NONCE_KEY',        '#&L*Lf!u%b`]sf!B}s-!+W8x#=Y)T]>:8 #iCD9sF}6rUd#7pvUMA%ip!dv&;xiW' );
define( 'AUTH_SALT',        'n4Yg4_pBQX>% `*Nx}cNaMjji5Y6h3#&7u*%7;!|alI~NuwuY dg.ZD|Ym_Ko3~V' );
define( 'SECURE_AUTH_SALT', '0e_rWf#zP;LP/MpD cd#tRLjAMWcL#4=_s:*?vv91M8xQhC$`$+Pe?A^b_Vvm.Ts' );
define( 'LOGGED_IN_SALT',   '8)@`>MTyRm|XXO9Y>kI;G?*9V]Wl2;Vx}5 cmrz}7X2D3+RjtLIg-/mosS2zFugT' );
define( 'NONCE_SALT',       'DUYVr}k2.s>N#iY;1k<.XesD[K~jT&ymJ)p>}bXhgQ]3$!2rmacTtckt=~(`Fvn}' );

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
