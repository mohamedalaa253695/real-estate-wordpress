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
define('DB_NAME', 'thecity_db');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'Nw4A6X59bvK3ae');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'HiFiTQ9U{LXm:1ZUlM-wfsFykq`*A+1n/~`a)IpB)R$Dpq?<R9Io;lLf|^&y+Ud7');
define('SECURE_AUTH_KEY',  '`*ZQRN#%zrTK?+-sOXlR**8)MO%1w^ 4y|q!I@ #tk4WLz@mD%hV;bU|4AzBrM3+');
define('LOGGED_IN_KEY',    '/.;BG3@%7Ax5k1g:6dm=wBOK~z`f98B#juEPv.Qi!g2Ra2L*?]!jEY:LEOIL}$ks');
define('NONCE_KEY',        '@oy*~;)%|Dcct{t}aW1q]<yn?Q6jJfq21@xGH^149|l DW9ar~ch3Hqo6BJF&Pvk');
define('AUTH_SALT',        '6.mY+.u0.D@9Bk4X5%-$/@?S06t!@Y=BWm$j6ebWL0]$Vs8k5djACG##vD}.;Ioq');
define('SECURE_AUTH_SALT', '<DCR{[Q_( /hL[gg7ggVXf+A)m>y7RVD[]HFuvCJd@qSWg)rdgN|d+r~GWnIOYi)');
define('LOGGED_IN_SALT',   'EKTel7q5*$qRWd=TsC5[1$2~BfM3R]x!~fuo!PP`Z2!C@&_2ez?{K6+l>}Uu;xk=');
define('NONCE_SALT',       'u>l*uIn EQbW),+tNP}2GFbX-$6(S$T}r+5nOgL1`J@SWqM0Et5-x:{v9{Q^I+b?');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
