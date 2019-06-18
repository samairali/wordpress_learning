<?php
session_start();
if (isset($_SESSION['message'])) {
	echo "<p>".$_SESSION['message']."</p>";
	unset($_SESSION['message']);
}
require_once(plugin_dir_path(__DIR__).'/Batch_Checker_WP_List_Table.php');
// add_action('');
class All_Batch_data extends Batch_Checker_WP_List_Table{
	public function prepare_items(){
		$orderby = isset($_GET['orderby']) ? trim($_GET['orderby']) : ''; 
		$order = isset($_GET['order']) ? trim($_GET['order']) : '';
		$batch_search_term = isset($_POST['s']) ? trim($_POST['s']) : '';
		$data = $this->list_table_data($orderby,$order,$batch_search_term);
		$columns = $this->get_columns();
		$hidden = $this->get_hidden_columns();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array($columns,$hidden,$sortable);
		// Pagination Feature code here
		$posts_per_page = 5;
		$current_page = $this->get_pagenum();
		$total_data_page_count = count($data);
		$this->set_pagination_args(array(
			'total_items' => $total_data_page_count,
			'per_page' => $posts_per_page,
		)
		);
		$this->items = array_slice($data, (($current_page-1)*$posts_per_page) ,$posts_per_page);

	} 
	public function get_columns(){
		$columns = array(
			'id' => 'id',
			'batch' => 'batch',
			'batchdate' => 'batchdate',
			'action' => 'Action'
		);
		return $columns;
	}
	public function get_sortable_columns(){
		return array(
			'id'=>array('id',true),
		);
	}
	public function list_table_data($orderby='',$order='',$batch_search_term=''){
		global $wpdb;
		$table_name = 'batch_number' ;
		
			if (!empty($batch_search_term)) {
				$alldata = $wpdb->get_results( 'select * from '.$table_name.' where batch like "%'.$batch_search_term.'%"' );
				$posts_array = array();
				if (count($alldata) > 0 ) {
					foreach($alldata as $alleachdata){
						$posts_array[] = array(
							'id' => $alleachdata->id,
							'batch' => $alleachdata->batch,
							'batchdate' => $alleachdata->batchdate
						);
					}
				}
				else{
					$posts_array = "no data available";
				}
			}else{
				if ($orderby == 'id' && $order == 'asc') {
					$alldata = $wpdb->get_results('select * from '.$table_name.' order by id asc');
					$posts_array = array();
						if (count($alldata) > 0 ) {
							foreach($alldata as $alleachdata){
								$posts_array[] = array(
									'id' => $alleachdata->id,
									'batch' => $alleachdata->batch,
									'batchdate' => $alleachdata->batchdate
								);
							}
						}
						else{
							$posts_array = "no data available";
						}
				}elseif ($orderby == 'id' && $order == 'desc'){
					$alldata = $wpdb->get_results('select * from '.$table_name.' order by id desc');
					$posts_array = array();
						if (count($alldata) > 0 ) {
							foreach($alldata as $alleachdata){
								$posts_array[] = array(
									'id' => $alleachdata->id,
									'batch' => $alleachdata->batch,
									'batchdate' => $alleachdata->batchdate
								);
							}
						}
						else{
							$posts_array = "no data available";
						}
				}else{
					$alldata = $wpdb->get_results('select * from '.$table_name.'');
					$posts_array = array();
						if (count($alldata) > 0 ) {
							foreach($alldata as $alleachdata){
								$posts_array[] = array(
									'id' => $alleachdata->id,
									'batch' => $alleachdata->batch,
									'batchdate' => $alleachdata->batchdate
								);
							}
						}
						else{
							$posts_array = "no data available";
						}
				}
			}
		
		return $posts_array;
	}
	public function get_hidden_columns(){
		return array();
	}
	public function column_default($item , $column_name){
		
		switch ($column_name) {
			case 'id':
			case 'batch':
			case 'batchdate':
				return $item[$column_name];
			case 'action' :
				return '<a href="?page='.$_GET['page'].'&action=batch-edit&post_id='.$item['id'].'">Edit</a>';
			default:
				return 'no value';
		}
	}
	public function column_batch($item){
		$action = array(
			'edit' => '<a href="?page='.$_GET['page'].'&action=batch-edit&post_id='.$item['id'].'">Edit</a>',
			'delete' => '<a href="?page='.$_GET['page'].'&action=batch-delete&post_id='.$item['id'].'">Delete</a>'
		);
		return sprintf('%1$s %2$s', $item['batch'], $this->row_actions($action));

	}


}
function batch_show_data(){
		$all_batch_data = new All_Batch_data();
		$all_batch_data -> prepare_items();
		echo '<form method="post" name="batch_form_search" action="'.$_SERVER['PHP_SELF'].'?page=batch-op-settings">';
		$all_batch_data->search_box( 'Search Specific Batch Here', 'batch_data_search' );
		echo '</form>';
		$all_batch_data -> display();

}
batch_show_data();
?>
