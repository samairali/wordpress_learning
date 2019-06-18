<?php 
session_start();
if (isset($_GET['action']) == 'batch-delete') {
	
    
	global $wpdb;
	$delete_batch = $wpdb->delete( 'batch_number', array(
		'id'=>$_GET['post_id']
	) );
	$_SESSION['message'] = 'Batch Deleted Successfully';
	wp_redirect( admin_url( 'admin.php?page=batch-op-settings' ), 302, 'Deleted' );

	// exit;
}
?>