<?php
/**
 * Plugin Name: Batch Maker
 * Description: Batch checker plugin to make your products verification easy.
 * Version: 1.0
 * Author: Samair Ali
 * Author URI: https://samair-ali.web.app
 * Text Domain: wporg
 */

// custom plugin row meta data here --means adding additional text in plugin data
function custom_plugins_row_meta( $links, $file ) {    
    if ( plugin_basename( __FILE__ ) == $file ) {
        $row_meta = array(
          'docs'    => '<a href="' . esc_url( 'https://samair-batch-checker.herokuapp.com/' ) . '" target="_blank" aria-label="' . esc_attr__( 'Plugin Additional Links', 'domain' ) . '" style="color:green;font-weight:bold;text-decoration:none;">' . esc_html__( 'Documentation', 'domain' ) . '</a>'
        );
 
        return array_merge( $links, $row_meta );
    }
    return (array) $links;
}
add_filter('plugin_row_meta','custom_plugins_row_meta',10,2);


function batch_checker_options_panel(){
  add_menu_page('BatchChecker options page', 'BatchChecker', 'manage_options', 'batch-options', 'samair_theme_func');
  add_submenu_page( 'batch-options', 'All Batches', 'All Batches', 'manage_options', 'batch-op-settings', 'samair_theme_func_settings');
  // add_submenu_page( 'theme-options', 'FAQ page title', 'FAQ menu label', 'manage_options', 'theme-op-faq', 'samair_theme_func_faq');
}
add_action('admin_menu', 'batch_checker_options_panel');

function batch_checker_style(){
	wp_enqueue_style('batchstyle',plugin_dir_url(__FILE__).'/style/style.css');
}
add_action('admin_enqueue_scripts','batch_checker_style');

function samair_theme_func(){
        require_once(plugin_dir_path(__FILE__).'/samair_theme_func.php');
}
function samair_theme_func_settings(){
  $action = isset($_GET['action'])?trim($_GET['action']):'';
  if ($action == 'batch-edit') {
    $postid = isset($_GET['post_id'])?intval($_GET['post_id']):'';
    require_once(plugin_dir_path(__FILE__).'/views/single_batch_edit.php');
  }elseif ($action == 'batch-delete') {
    require_once (plugin_dir_path( __FILE__ ).'views/single_batch_delete.php');
    
  }else{
    require_once(plugin_dir_path(__FILE__).'/views/all_batch_data.php');    
  }
}
// function samair_theme_func_faq(){
//         echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
//         <h2>FAQ</h2></div>';
// }
require_once(plugin_dir_path(__FILE__).'/batch-form.php');
add_action('admin_init', 'app_output_buffer');
function app_output_buffer() {
        ob_start();
}