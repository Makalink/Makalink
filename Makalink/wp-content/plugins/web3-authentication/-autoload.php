<?php
/**
 * MiniOrange Web3 Authentication
 *
 * @package    miniOrange-web3-authentication
 * @author     miniOrange <info@miniorange.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MOWEB3_DIR', plugin_dir_path( __FILE__ ) );
define( 'MOWEB3_URL', plugin_dir_url( __FILE__ ) );
define( 'MOWEB3_VERSION', 'mo_web3_login_free' );

mo_web3_include_file( MOWEB3_DIR . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'common' );

/**
 * Traverse all sub-directories for files.
 *
 * Get all files in a directory.
 *
 * @param string $folder Folder to Traverse.
 * @param Array  $results Array of files to append to.
 * @return Array $results Array of files found.
 **/
function mo_web3_get_dir_contents( $folder, &$results = array() ) {
	$is_extension_loaded = extension_loaded( 'bcmath' ) || extension_loaded( 'gmp' );
	foreach ( new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $folder, RecursiveDirectoryIterator::KEY_AS_PATHNAME ), RecursiveIteratorIterator::CHILD_FIRST ) as $file => $info ) {
		if ( $info->isFile() && $info->isReadable() ) {
			$path = realpath( $info->getPathname() );
			$path = explode( DIRECTORY_SEPARATOR, $path );
			if ( in_array( 'lib', $path, true ) ) {
				if ( ! $is_extension_loaded ) {
					continue;
				}
			}
			$results[ $file ] = realpath( $info->getPathname() );
		}
	}
	
	return $results;
}

/**
 * Order all php files.
 *
 * Get all php files to require() in perfect order.
 *
 * @param string $folder Folder to Traverse.
 * @return Array Array of php files to require.
 **/
function mo_web3_get_sorted_files( $folder ) {

	$filepaths = mo_web3_get_dir_contents( $folder );

	$interfaces = array();
	$classes    = array();

	foreach ( $filepaths as $file => $filepath ) {
		if ( strpos( $filepath, '.php' ) !== false ) {
			if ( strpos( $filepath, 'Interface' ) !== false ) {
				$interfaces[ $file ] = $filepath;
			} else {
				$classes[ $file ] = $filepath;
			}
		}
	}

	return array(
		'interfaces' => $interfaces,
		'classes'    => $classes,
	);
}

/**
 * Wrapper for require_all().
 *
 * Wrapper to call require_all() in perfect order.
 *
 * @param string $folder Folder to Traverse.
 * @return void
 **/
function mo_web3_include_file( $folder ) {

	if ( ! is_dir( $folder ) ) {
		return;
	}

	$folder   = mo_web3_sane_dir_path( $folder );
	$realpath = realpath( $folder );
	if ( false !== $realpath && ! is_dir( $folder ) ) {
		return;
	}
	$sorted_elements = mo_web3_get_sorted_files( $folder );
	mo_web3_require_all( $sorted_elements['interfaces'] );
	mo_web3_require_all( $sorted_elements['classes'] );
}

/**
 * All files given as input are passed to require_once().
 *
 * Wrapper to call require_all() in perfect order.
 *
 * @param Array $filepaths array of files to require.
 * @return void
 **/
function mo_web3_require_all( $filepaths ) {

	foreach ( $filepaths as $file => $filepath ) {
		require_once $filepath;

	}

}

/**
 * Validate file paths
 *
 * File names passed are validated to be as required
 *
 * @param string $filename filepath to validate.
 * @return bool validity of file.
 **/
function mo_web3_is_valid_file( $filename ) {
	return '' !== $filename && '.' !== $filename && '..' !== $filename;
}

/**
 * Valid html
 *
 * Helper function for escaping.
 *
 * @param array $args HTML to add to valid args.
 *
 * @return array valid html.
 **/
function mo_web3_get_valid_html( $args = array() ) {
	$retval = array(
		'strong' => array(),
		'em'     => array(),
		'b'      => array(),
		'i'      => array(),
		'a'      => array(
			'href'   => array(),
			'target' => array(),
		),
	);
	if ( ! empty( $args ) ) {
		return array_merge( $args, $retval );
	}
	return $retval;
}

/**
 * Get Version number
 */
function mo_web3_get_version_number() {
	$file_data      = get_file_data( MOWEB3_DIR . DIRECTORY_SEPARATOR . 'miniorange-web3-login-settings.php', array( 'Version' ), 'plugin' );
	$plugin_version = isset( $file_data[0] ) ? $file_data[0] : '';
	return $plugin_version;
}

/**
 * Function to sanitize dir paths.
 *
 * @param string $folder Dir Path to sanitize.
 *
 * @return string sane path.
 */
function mo_web3_sane_dir_path( $folder ) {
	return str_replace( '/', DIRECTORY_SEPARATOR, $folder );
}



/**
 * Function to load all methods.
 *
 * @param array $all_methods create instance of the methods.
 */
function mo_web3_load_all_methods( $all_methods ) {

	foreach ( $all_methods as $method ) {
		new $method();
	}
}

