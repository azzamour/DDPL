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
define('DB_NAME', 'sataproj_gool');

/** MySQL database username */
define('DB_USER', 'sataproj_gool');

/** MySQL database password */
define('DB_PASSWORD', 'p1803e![7S');

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
define('AUTH_KEY',         'ieta6y9gxw7bzfkc5eetlz2pquf8xvfyny8zro0osqlkxup5wkx3o4sbfwfqxcjz');
define('SECURE_AUTH_KEY',  'f7xu4mrnmrrkofgr8gikdv2wj3nbtjioqegu99nxneal7bbwa1pmo4yrgiek2b4q');
define('LOGGED_IN_KEY',    'm1jpjtli7mh5khf1ghdc6fdinzpdmrtctffcc3eohy7qiqqslrg9yihbc2jbllqi');
define('NONCE_KEY',        'xxybim4za04nhzhmjmxtcibketns4xjob59b8pr2n9rvrxjnak8ax70vthohzzhi');
define('AUTH_SALT',        '3jbpkeezklrj7re9e7moobnbkmtjviiexm8hgod2gti9pabezdqi4gnpj23kznzm');
define('SECURE_AUTH_SALT', 'lmz11th0x85xssytjdimhzim8gungqpn8qydeypzkl1stoccizc2icwjrhl7xtsm');
define('LOGGED_IN_SALT',   'n3gww5znitempzgbrckwst3ip8weqp6llbiu5bxc3u01l9k9h3uedkqi2dtcn6hl');
define('NONCE_SALT',       'ns7oqqeifdij543oeg0otl1tuuz96rinciu8hpqfhbpvwr5nh9ezrezc6yeaah2s');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'gf_';

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
