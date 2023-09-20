<?php


namespace WordThree\Metamask;

class Activate {

	public static function activate() {
		static::create_tables();
	}

	public static function create_tables() {
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$schema = static::getSchema();
		dbDelta($schema);
		update_option('wordthree_metamask_db_version', '1.0.0');
	}

	public static function getSchema() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		return 'CREATE TABLE ' . $wpdb->prefix . 'twothree_metamask_accounts (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) UNSIGNED NOT NULL,
            nonce varchar(18) NOT NULL,
            account_address varchar(155) NOT NULL,
            UNIQUE KEY account_address (account_address),
            PRIMARY KEY  (id)
        ) ' . $charset_collate . ';';
	}
}
