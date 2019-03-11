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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'username');

/** MySQL database password */
define('DB_PASSWORD', 'password');

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
define('AUTH_KEY',         'B~YpjT.qV#VV$F1[C^DK`o0>LHT>K&)]s_R}AIpt+~|OAy!m%>9G~iP-@?a_SN^e');
define('SECURE_AUTH_KEY',  'H;-n~seZZiGqrPILZjYg:G:0m%5N9y70tY0r!qg82Kz_Q]Fr?PuV9~!dV36whL^>');
define('LOGGED_IN_KEY',    '1^q[],X]uz5|1<[(@!@e.WsjUQ973k&Wq)MC0}rZ.2VIyuw_l>}]xhX}iZ0xGCF&');
define('NONCE_KEY',        '0,C.#x{FM*H=LaX*4J9Y]A4tBnn~?g/OAK1L@u2[.<g>MD:&5ej]K;H<Ptv7Mk@{');
define('AUTH_SALT',        'ez93V5jLl*Colg|B<m2^kerwk9hjRHPL;I{RmLB6~sdcF]kB7Y2su<~+.^m)]p+S');
define('SECURE_AUTH_SALT', 'o^Q&JUI7;V=TMQoa9K=AU9SgtAba*]jwc+S)`FJ<1<R189>Jz0Au/PJJU=7]5G.)');
define('LOGGED_IN_SALT',   ':#`=*aA8er@q:T}i`OmK25=:z}Pz*Z:g(5K8Z_/{UW{eb?|jw{m,(nO1=z&9X{x9');
define('NONCE_SALT',       'V3@){H/zy2engIjr:WR[B}j|P7ediWPrl%5iQ%wR}*>IT!o>`}#<fYLtQTh?[.8B');

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
