<?php
function batch_checker(){
	ob_clean();
	?>
	<form method="post" action="<?php bloginfo('url') ?>/wp-admin/admin-ajax.php" id="batchcheckerform">
		<input type="text" name="inputbatch" id="inputbatch">
		<input type="date" name="batchdate" id="batchdate">
		<input type="submit" name="inputbacthsubmit" id="submitform">
	</form>
	<p id="resultbatchcheker"></p>
	<?php

    $output = ob_get_clean(); // set the buffer data to variable and clean the buffer
    return $output;
}
add_shortcode('batchchecker','batch_checker');

function ajax_form(){
	global $wpdb;

	$db_result = $wpdb->get_results('select * from batch_number');	
	$inputbatch = $_POST['name'];
	$batchdate = $_POST['batchdate'];
	if (!empty($inputbatch) && !empty($batchdate)) {
		$countbatch = $wpdb->get_var("select count(*) from batch_number where batch = ".$inputbatch." AND batchdate = '$batchdate' ");
		if ($countbatch >=1 ) {
			echo "Batch number ".$inputbatch." is verified";
		}else{
			echo "Batch number ".$inputbatch." is not verified<br>";
		}
	}else{
		echo 'please enter the fields';
	}
	die();
}
add_action('wp_ajax_batch_checker_form','ajax_form');
add_action('wp_ajax_nopriv_batch_checker_form','ajax_form');
?>