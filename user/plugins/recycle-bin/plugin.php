<?php
/*
Plugin Name: Recyle Bin
Plugin URI: http://yourls.org/
Description:  plugin to enable recyle bin for Data Base
Version: 0.1
Author: BlueBerry Raspher
Author URI: http://ozh.org/
*/

//VARIBLE DEFINITIONS

if( !defined( 'YOURLS_ABSPATH' ) ) die();
$url = yourls_plugin_url( __DIR__ );

// db related functions
if (!defined( 'YOURLS_DB_TABLE_URL_BAK' ))
          define( 'YOURLS_DB_TABLE_URL_BAK', YOURLS_DB_PREFIX.'url_bak');

/* 
create table url_bak if already not exists during the activation of the plugin.

*/
yourls_add_action( 'activated_recycle-bin/plugin.php', 'amp_activated' );
function amp_activated() {
	 if ( null !== $pre ) {
        return $pre;
    }
	global $ydb;
	
	$table = YOURLS_DB_TABLE_URL_BAK;
	$create_tables 	= 
		'CREATE TABLE IF NOT EXISTS `'.YOURLS_DB_TABLE_URL_BAK.'`('.
		'`keyword` varchar(200) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,'.
		'`url` text BINARY NOT NULL,'.
		'`title` text CHARACTER SET utf8,'.
		'`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,'.
		'`ip` varchar(41) NOT NULL,'.
		'`clicks` int(10) unsigned NOT NULL,'.
		'`user` varchar(255) DEFAULT NULL,'.
		'PRIMARY KEY (`keyword`),'.
		'KEY `timestamp` (`timestamp`),'.
		'KEY `ip` (`ip`) '.
		');';
		
		$table_exits= $ydb->query("SHOW TABLES LIKE '`$table`'");
		
		if(!$table_exits){
			$insert = $ydb->query($create_tables);
		} 	
}
//Admin Menu option Addition 
yourls_add_action( 'admin_menu', 'add_menu_recyle' );
function add_menu_recyle() {

		$add_links['abinesh'] = array(
		'url'    =>yourls_admin_url ('recycler.php'),
		'title'  => yourls__( 'Go to the Recyle Bin' ),
		'anchor' => yourls__( 'Recyle Bin' )
	);
	foreach( (array)$add_links as $link => $ar ) {
		if( isset( $ar['url'] ) ) {
			$anchor = isset( $ar['anchor'] ) ? $ar['anchor'] : $link;
			$title  = isset( $ar['title'] ) ? 'title="' . $ar['title'] . '"' : '';
			printf( '<li id="admin_menu_%s_link" class="admin_menu_toplevel"><a href="%s" %s>%s</a>', $link, $ar['url'], $title, $anchor );
		}	
 	}
}

//Show Include JSS

echo <<<HEAD
			<script src="$url/assets/javascript.js"></script>
HEAD;














