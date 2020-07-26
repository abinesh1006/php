<?php
define( 'YOURLS_ADMIN', true );
define( 'YOURLS_AJAX', true );
require_once( dirname( __DIR__ ) .'/includes/load-yourls.php' );
yourls_maybe_require_auth();

// This file will output a JSON string
yourls_content_type_header( 'application/json' );

if( !isset( $_REQUEST['action'] ) )
	die();

$action = $_REQUEST['action'];

switch( $action ) {
		case 'restore':
		echo $id;
			yourls_verify_nonce( 'restore-link_'.$_REQUEST['id'], $_REQUEST['nonce'], false, 'omg error' );
			$query = yourls_delete_link_by_keyword( $_REQUEST['keyword'] );
			echo json_encode(array('success'=>$query));
			break;
		case 'temp_delete':
			yourls_verify_nonce( 'delete-link_'.$_REQUEST['id'], $_REQUEST['nonce'], false, 'omg error' );
			$query = yourls_delete_link_by_keyword( $_REQUEST['keyword'] );
			echo json_encode(array('success'=>$query));
			break;
		case 'delete':
				yourls_verify_nonce( 'delete-link_'.$_REQUEST['id'], $_REQUEST['nonce'], false, 'omg error' );
				$query = yourls_delete_link_by_keyword( $_REQUEST['keyword'] );
				echo json_encode(array('success'=>$query));
		break;
}

		
	default:
		yourls_do_action( 'yourls_ajax_'.$action );

}

die();
