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
define( 'DB_NAME', 'wordpress' );

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
define( 'AUTH_KEY',         '+,sM_ijg!Ykm=gY;va3 m;0{_,EI-X*i#}._)2l5uAONm![0S5+%f95k1(FMYxxF' );
define( 'SECURE_AUTH_KEY',  'Q~thyy?KKjW|:HeN$#V]^K6-BcH|T1aUihhZe?A0U-JGcdGi+HH3]6V5rmU2|X(Y' );
define( 'LOGGED_IN_KEY',    '_9OoeA5_Z^s;-tND&|KkkU{L<jR-!#`,t5UEau+?^O60d# G9lw%KdA%?ADxCh)k' );
define( 'NONCE_KEY',        'm5H&tr2zqCo#kQU{O>5jp4T+Yy?[GzdYm9BhlKO(UGh<;axVSpUO^5c C|M.>lu$' );
define( 'AUTH_SALT',        'fK@8!AW9T8d${C):=TMUy9U8S;HQ ~NSy%Ax%4DV6Tl53>m<m_0I; qEVT!u]3k|' );
define( 'SECURE_AUTH_SALT', 'tamd#?cSmr4GG1O+]La`~W s#gzh1Qb:MMCmw-3dBu9*|!{z/wFY+&B-r(kwE3ed' );
define( 'LOGGED_IN_SALT',   'R$Dy7X*7vV0$$g$2$~lRWjl!&g-VI6lp(x,all|T3+,XxS2P,Frk= [{!HK!RWmg' );
define( 'NONCE_SALT',       '&RW[w2pe-o~/-CdXP;zCGmr6og&5ZVN|QR?gME TY-v4](~@;`g>*WEL5HF#Ct`@' );

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
