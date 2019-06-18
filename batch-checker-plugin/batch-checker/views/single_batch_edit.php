<?php 
global $wpdb;
$currentid = $_GET['post_id'];
//adding data to the database
if (isset($_POST['submit'])) {
	$batchnumber = $_POST['batch_number'];
	$batchdate = $_POST['batch_date'];
	$wpdb->update( 'batch_number', array(
		'batch'=>$batchnumber,
		'batchdate'=>$batchdate
	),array(
		'id'=>$_GET['post_id']
	) );//both arrays of update methods end here
	echo "<p>data updated</p>";
}
//getting data from database
$getcurrent_post_result = $wpdb->get_results('select * from batch_number where id="'.$currentid.'"');
// print_r($getcurrent_post_result);
foreach ($getcurrent_post_result as $currentpost_data) {
	
?>
<h3>Batch Details</h3>
<form method="post" action="<?php //echo $_SERVER['PHP_SELF'] ?>">
	<p>
		<label>Batch Number</label>
		<input type="text" placeholder="Enter Batch Number" class="batch-checker batch-number-input"  value="<?php echo $currentpost_data->batch ?>" name="batch_number" /> 
	</p>
	<p>
		<label>Batch Date</label>
		<input type="date" placeholder="Enter Batch date" class="batch-checker batch-date-input" value="<?php echo $currentpost_data->batchdate ?>" name="batch_date" /> 
	</p>
	<p>
		<input type="submit" class="batch-submit-button" value="submit" name="submit" />
	</p>
</form>
<?php 
}//end of foreach loop here


?>