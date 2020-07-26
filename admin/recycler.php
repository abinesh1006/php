<?php
define( 'YOURLS_ADMIN', true );
require_once( dirname( __DIR__ ).'/includes/load-yourls.php' );
yourls_maybe_require_auth();


$table_url = YOURLS_DB_TABLE_URL;

$base_page   = yourls_admin_url( 'recycler.php' );
yourls_html_head( "recycler" );
yourls_html_logo();
yourls_html_menu() ;

?>
		<script type="text/javascript">
	//<![CDATA[
		var custom_ajax_url  = '<?php echo yourls_admin_url( 'recycler.php' ); ?>';
	//]]>
	</script>
	<h2><?php yourls_e( 'Recyle Bin' ); ?></h2>
<?php
	//Table Main Table Definition



	yourls_add_filter( 'table_add_custom_row_action_array', 'Modifyactions' );
	function Modifyactions($actions, $keyword ,$id  ){
		

	$keyword  = yourls_sanitize_keyword($keyword);
	$id       = yourls_string2htmlid( $keyword ); // used as HTML #id
	$shorturl = yourls_link( $keyword );

	$restore_link = yourls_nonce_url( 'restore-link_'.$id,
		yourls_add_query_arg( array( 'id' => $id, 'action' => 'restore', 'keyword' => $keyword ), yourls_admin_url( 'custom_ajax_url.php' ) )
	);
	
	$delete_link = yourls_nonce_url( 'delete-link_'.$id,
		yourls_add_query_arg( array( 'id' => $id, 'action' => 'delete', 'keyword' => $keyword ), yourls_admin_url( 'custom_ajax_url.php' ) )
	);
	
	
	$statlink = yourls_statlink( $keyword );
		
		$actions = array(
			'restore' => array(
				'href'    => $restore_link,
				'id'      => "restore-button-$id",
				'title'   => yourls_esc_attr__( 'Restore' ),
				'anchor'  => yourls__( 'Restore' ),
				'onclick' => "restore_link_display('$id');return false;",
			),
			'delete' => array(
				'href'    => $delete_link,
				'id'      => "delete-button-$id",
				'title'   => yourls_esc_attr__( 'Delete' ),
				'anchor'  => yourls__( 'Delete' ),
				'onclick' => "remove_link('$id');return false;",
			)
		);
	
		return $actions;
	}
	yourls_add_filter( 'table_head_cells', 'headers_modify');
	function headers_modify($array){
		$array = array(
			'shorturl' => yourls__( 'Short URL' ),
			'longurl'  => yourls__( 'Original URL' ),
			'date'     	=> yourls__( 'Date' ),
			'Modified By' => yourls__( 'Modified By' ),
			'clicks'   => yourls__( 'Clicks' ),
			'actions'  => yourls__( 'Actions' )
		) ;
		return $array;
	}
	yourls_table_head();
	


	$url_results = $ydb->fetchObjects( "SELECT * FROM `$table_url`");
	$found_rows = false;
	if( $url_results ) {
		$found_rows = true;
		foreach( $url_results as $url_result ) {
			$keyword = yourls_sanitize_keyword($url_result->keyword);
			$timestamp = strtotime( $url_result->timestamp );
			$url = stripslashes( $url_result->url );
			$user = $url_result->user;
			$title = $url_result->title ? $url_result->title : '';
			$clicks = $url_result->clicks;
			echo  yourls_table_add_row( $keyword, $url, $title, $user, $clicks, $timestamp );
		}
	}
	$display = $found_rows ? 'display:none' : '';
	echo '<tr id="nourl_found" style="'.$display.'"><td colspan="6">' . yourls__('No URL') . '</td></tr>';
	yourls_table_tbody_end();
	yourls_table_end();
 yourls_html_footer( ); 
 ?>
