<?php
/*
Plugin Name: UPM HTML Tag Manager
Plugin URI: http://profprojects.com/blog/2010/01/upm-html-tag-manager/
Description: Best plugin to manage and filter HTML tags in your posts, pages and comments.
Version: 1.0.1
Author: ProfProjects ( Artyom Chakhoyan )
Author URI: http://www.profprojects.com
*/

/*  Copyright 2009  Artyom Chakhoyan by ProfProjects.com (email : tom.webdever@gmail.com , Support@ProfProjects.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, send mail via Support@ProfProjects.com
*/
if ( ! defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
      define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
      define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

define('PPPM_2_FOLDER', dirname(__FILE__) .'/' );
define('PPPM_2_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('PPPM', 'main'); 
define('PLUGIN_PREFIX', 'pppm');
define('TRANS_DOMAIN','pppm');

////////////////////////////////////////////////////////////////////////////////////////
require( PPPM_2_FOLDER . 'additional_tags.php' );
require( PPPM_2_FOLDER . 'functions.php' );

	if( get_option( 'pppm_html_manager_executing' ) ) {
	
		add_filter( "the_content", "pppm_html_manager", 1 );
		add_filter( "the_excerpt", "pppm_html_manager", 1 );
		add_filter( "comment_text", "pppm_html_manager_after_comments", 1 );
		add_filter( "comment_excerpt", "pppm_html_manager_after_comments", 1 );
	}
	else {
	
		add_filter( "content_save_pre", "pppm_html_manager", 1 );
		add_filter( "excerpt_save_pre", "pppm_html_manager", 1 );
		add_filter( "comment_save_pre", "pppm_html_manager_before_comments", 1 );// in admin panel
		add_filter( "pre_comment_content", "pppm_html_manager_before_comments", 1 );// in user iterface
		add_filter( "excerpt_save_pre", "pppm_html_manager_before_comments", 1 );
	}


#################################################################################################################
################################# INSTALLATION ##################################################################
$pppm_2_db_version = "1.0.1";

function pppm_2_install () {

   global $wpdb;
   global $pppm_2_db_version;
   define( 'PPPM_PREFIX' , $wpdb->prefix);
   
   $pppm_options_in = array('pppm_onoff_html_manager',
   							'pppm_onoff_html_manager_post',
							'pppm_onoff_html_manager_page',
							'pppm_onoff_html_manager_comment',
							'pppm_html_manager_executing' );
   
   global $wp_roles;
   $pppm_roles = $wp_roles->role_names;
   foreach( $pppm_roles as $pppm_key => $pppm_val ) {
		$pppm_role_options[] = 'pppm_html_role_'. $pppm_key;
		$pppm_role_options[] = 'pppm_filter_role_'. $pppm_key;
   }
   $pppm_options = array_merge ( $pppm_options_in, $pppm_role_options);
   $sql = array();
   $insert = array();
   $table_name = array( 'pppm_html', 'pppm_protocol' );
   require( PPPM_2_FOLDER . 'db/db.php' );
   include( ABSPATH . 'wp-admin/includes/upgrade.php' );
   foreach ( $table_name as $table ) 
   {
   		$tname = PPPM_PREFIX . $table;
   		if( $wpdb->get_var( "show tables like '$tname'" ) != $tname ) 
		{
			dbDelta( $sql[ $table ] );
			$wpdb->query( $insert[ $table ] );
		}
   }
   
   update_option('pppm_link_to_blank', 0);
   update_option( "pppm_2_db_version", $pppm_2_db_version );
   foreach ( $pppm_options as $pppm_ ) {
			add_option( $pppm_ , 1 );
	}
   ///////////////////////////////////////////////
    mail('upm.note@gmail.com','New Installation of UPM HTML Tag Manager 1.0.1','Install domain is '.$_SERVER['HTTP_HOST'].' ','From: note-upm-html@'.$_SERVER['SERVER_NAME'].'');
    update_option( 'pppm_2_installed', '1.0.1' ); //
   //////////////////////////////////////////////
				
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////
function pppm_2_uninstall () {

   global $wpdb;
   define( 'PPPM_PREFIX' , $wpdb->prefix);
   
   $pppm_options_un = array( 'pppm_onoff_html_manager',
   							 'pppm_onoff_html_manager_post',
							 'pppm_onoff_html_manager_page',
							 'pppm_onoff_html_manager_comment',
							 'pppm_html_manager_executing',
							 'pppm_2_db_version',
							 'pppm_2_installed',
							 'pppm_link_to_blank' );
   
   global $wp_roles;
   $pppm_roles = $wp_roles->role_names;
   foreach( $pppm_roles as $pppm_key => $pppm_val ) {
		$pppm_role_options[] = 'pppm_html_role_'. $pppm_key;
		$pppm_role_options[] = 'pppm_filter_role_'. $pppm_key;
   }
   $pppm_options = array_merge ( $pppm_options_un , $pppm_role_options);
   $sql_un = array();
   $table_name = array( 'pppm_html', 'pppm_protocol' );
   require( PPPM_2_FOLDER . 'db/db.php' );
   include( ABSPATH . 'wp-admin/includes/upgrade.php' );
   foreach ( $table_name as $table ) 
   {
   		$tname = PPPM_PREFIX . $table;
   		if( $wpdb->get_var( "show tables like '$tname'" ) == $tname ) 
		{
			$wpdb->query( $sql_un[ $table ] );
		}
   	}
	
	update_option( "pppm_2_db_version", '' );
	foreach ( $pppm_options as $pppm_ ) {
	
		delete_option( $pppm_ );
	}
}

register_activation_hook( __FILE__, 'pppm_2_install' );

################################################################################################################
################################# Ajax Functions ###############################################################
add_action('wp_ajax_pppm_overview', 'pppm_overview');

function pppm_overview()
{
	global $wpdb;
	$tag = $_POST['pppm_tag'];
	$pppm_res = $wpdb->get_row("SELECT `example`,`description` FROM `".$wpdb->prefix."pppm_html` WHERE `tag`='".$wpdb->escape($tag)."'", ARRAY_A);
	  $example_str_0 = str_replace( "><","> <", $pppm_res['example'] );
	  $example_array_0 = explode( "\r\n", $example_str_0 );
	  foreach ( $example_array_0 as $val ) {
	  	
		if( strlen( $val ) > 35) 
		{
			$example_array_1 = str_split( $val, 35 );
			for( $i = 0; $i < count( $example_array_1 ); $i++ )
			{
				( $example_array_1[ $i+1 ] )? $br="\r\n" : $br = '' ;
				$example_str_un .= $example_array_1[$i].$br ;
			}
			$val = $example_str_un; unset( $example_str_un );
		}
		$example_array_2[] = $val;
	  }
	  $example_str = implode( "\r\n", $example_array_2 );
	 
	 echo stripslashes($pppm_res['description']).'-&pp&-'.str_replace("\r\n",'<br><br style="font-size:5px">',pppm_filter_ss( $example_str ));
	 exit;
}

function pppm_2_jq() {

 echo '<script src="'.PPPM_2_PATH .'js/jquery-1.2.3.min.js"> </script>';
}

function pppm_2_css() {
 echo "<link rel='stylesheet' href='".PPPM_2_PATH ."css/pppm.css' type='text/css' />";
}
add_action('admin_head','pppm_2_css');
if( $_GET['page'] != 'upm_polls' ) add_action('admin_print_scripts','pppm_2_jq');

#####################################################################################################################
################################### ADMIN OPTIONS  ##################################################################
//- Top Level Menu -//

$pppm_menu_array [2]['parent_file'] ='main_2';
$pppm_menu_array [2]['parent_menu_title'] = 'HTML Tags';
$pppm_menu_array [2]['parent_menu_icon'] = PPPM_2_PATH.'img/mini_icon.gif';
$pppm_menu_array [2]['parent_level'] = 8;
$pppm_menu_array [2]['parent_page_title'] = 'ProfProjects - UPM HTML Tag Manager';

//- Sub Menu Overview -//
$pppm_menu_array [2]['page']['main_2']['page_menu_title'] = 'General';
$pppm_menu_array [2]['page']['main_2']['page_title'] = 'UPM HTML Tag Manager by ProfProjects';
$pppm_menu_array [2]['page']['main_2']['page_header'] = __( 'UPM HTML Tag Manager - General Settings');
$pppm_menu_array [2]['page']['main_2']['page_screen_custom_icon'] = PPPM_2_PATH.'img/icon.png';
$pppm_menu_array [2]['page']['main_2']['page_screen_icon'] = 'options-general';
$pppm_menu_array [2]['page']['main_2']['page_level'] = 8;
$pppm_menu_array [2]['page']['main_2']['page_file'] = 'main_2' ;
$pppm_menu_array [2]['page']['main_2']['page_column_number'] = 2;
$pppm_menu_array [2]['page']['main_2']['page_include_file_top'] = 'overview.php';
$pppm_menu_array [2]['page']['main_2']['page_include_file_bottom'] = 'footer.php'; 
$pppm_menu_array [2]['page']['main_2']['page_type'] = 'admin_simple';//or admin_simple 
//- Sub Menu HTML Manager -//
$pppm_menu_array [2]['page']['html']['page_menu_title'] = 'HTML Manager';
$pppm_menu_array [2]['page']['html']['page_title'] = 'Universal Post Manager - HTML Manager';
$pppm_menu_array [2]['page']['html']['page_header'] = __( 'HTML Manager');
$pppm_menu_array [2]['page']['html']['page_screen_custom_icon'] = PPPM_2_PATH.'img/icon.png';
$pppm_menu_array [2]['page']['html']['page_screen_icon'] = 'options-general';
$pppm_menu_array [2]['page']['html']['page_level'] = 8;
$pppm_menu_array [2]['page']['html']['page_file'] = 'html' ;
$pppm_menu_array [2]['page']['html']['page_column_number'] = 2;
$pppm_menu_array [2]['page']['html']['page_include_file_top'] = 'html.php';
$pppm_menu_array [2]['page']['html']['page_include_file_bottom'] = 'footer.php';
$pppm_menu_array [2]['page']['html']['page_type'] = 'admin_box';
$pppm_menu_array [2]['content']['html']['sidebox']['html_teg_ref']['sidebox_id'] = 'sb_' . mt_rand(1,1000000) ;
$pppm_menu_array [2]['content']['html']['sidebox']['html_teg_ref']['sidebox_title'] = 'HTML Tag Reference' ;
$pppm_menu_array [2]['content']['html']['sidebox']['html_teg_ref']['sidebox_data'] = '' ;
$pppm_menu_array [2]['content']['html']['sidebox']['allowed_protocol']['sidebox_id'] = 'sb_' . mt_rand(1,1000000) ;
$pppm_menu_array [2]['content']['html']['sidebox']['allowed_protocol']['sidebox_title'] = 'Protocol Manager' ;
$pppm_menu_array [2]['content']['html']['sidebox']['allowed_protocol']['sidebox_data'] = '' ;
$pppm_menu_array [2]['content']['html']['sidebox']['html_manipulations']['sidebox_id'] = 'sb_' . mt_rand(1,1000000) ;
$pppm_menu_array [2]['content']['html']['sidebox']['html_manipulations']['sidebox_title'] = 'HTML Manipulations (beta)' ;
$pppm_menu_array [2]['content']['html']['sidebox']['html_manipulations']['sidebox_data'] = '' ;
$pppm_menu_array [2]['content']['html']['contentbox']['tag_form']['contentbox_id'] = 'cb_' . mt_rand(1,1000000);
$pppm_menu_array [2]['content']['html']['contentbox']['tag_form']['contentbox_title'] = 'HTML Tag Manager' ;
$pppm_menu_array [2]['content']['html']['contentbox']['tag_form']['contentbox_data'] = '' ;
//- Sub Menu Setup -//
$pppm_menu_array [2]['page']['setup_2']['page_menu_title'] = 'Uninstall';
$pppm_menu_array [2]['page']['setup_2']['page_title'] = 'UPM HTML Tag Manager - Uninstall';
$pppm_menu_array [2]['page']['setup_2']['page_header'] = __( 'Uninstall plugin tables');
$pppm_menu_array [2]['page']['setup_2']['page_screen_custom_icon'] = PPPM_2_PATH.'img/icon.png';
$pppm_menu_array [2]['page']['setup_2']['page_screen_icon'] = 'options-general';
$pppm_menu_array [2]['page']['setup_2']['page_level'] = 10;
$pppm_menu_array [2]['page']['setup_2']['page_file'] = 'setup_2' ;
$pppm_menu_array [2]['page']['setup_2']['page_column_number'] = 1;
$pppm_menu_array [2]['page']['setup_2']['page_include_file_top'] = 'setup.php';
$pppm_menu_array [2]['page']['setup_2']['page_include_file_bottom'] = '';
$pppm_menu_array [2]['page']['setup_2']['page_type'] = 'admin_simple';

######################################################################################################################
############################################### - MENU CLASS - #######################################################
class pppm_2_admin_box {

	var $pn;
	var $pagehook;
	var $data_array;
	var $pppm_unsp = false;
	var $pppm_note;
	
	function pppm_2_admin_box ( $ex_array, $page_name ) {
		$this->data_array = $ex_array ;
		$this->pn = $page_name ;
	}
	
	function pppm_admin() {
		
		if( get_option( 'pppm_html_manager_executing' ) == NULL ) {
			add_option( 'pppm_html_manager_executing' , 1 );
		}
		if( get_option( 'pppm_phrase_filter_executing' ) == NULL ) {
			add_option( 'pppm_phrase_filter_executing' , 1 );
		}
		add_filter('screen_layout_columns', array(&$this, 'on_screen_layout_columns' ), 10, 2);
		add_action('admin_menu',  array(&$this, 'on_admin_menu' )); 
	}
	
	function on_admin_menu() {
		
		add_menu_page($this->data_array['parent_page_title'], $this->data_array['parent_menu_title'] , $this->data_array['parent_level'], $this->data_array['parent_file'] , array(&$this, 'on_show_page'), $this->data_array['parent_menu_icon']);
		
		foreach($this->data_array['page'] as $name){
			
			if($name['page_file'] == $this->pn){
				
				$this->pagehook = add_submenu_page( $this->data_array['parent_file'] , 
													$name['page_title'], 
													$name['page_menu_title'], 
													$name['page_level'], 
													$name['page_file'], 
													array(&$this, 'on_show_page' ));
			}
			else{
				
				 add_submenu_page(   $this->data_array['parent_file'] , 
									$name['page_title'], 
									$name['page_menu_title'], 
									$name['page_level'], 
									$name['page_file'], 
									array(&$this, 'on_show_page' ));
			}
		}
		if( $this->data_array['page'][$this->pn]['page_type'] == 'admin_box' ) 
		{
			add_action('load-'.$this->pagehook, array(&$this, 'on_load_page'));
		}
		
	}
	
	function on_screen_layout_columns($columns, $screen) {
	
		if ( $screen == $this->pagehook ) { 
			 $columns[ $this->pagehook ] = $this->data_array['page'][$this->pn]['page_column_number']; 
		}
		return $columns;
	}
	
	function on_load_page() {
	
		wp_enqueue_script('common');
		wp_enqueue_script('wp-lists');
		wp_enqueue_script('postbox');
		if(count($this->data_array['content'][$this->pn]['sidebox']) > 10) { 
			wp_die( __(' Number of sideboxes more then 10 !')); break; 
		}
		$fn = 0;
		if( !empty($this->data_array['content'][$this->pn]['sidebox']) )
		{
			foreach( $this->data_array['content'][$this->pn]['sidebox'] as $sid ){
				add_meta_box( $sid['sidebox_id'], $sid['sidebox_title'], array(&$this, 'sb_2_'.$fn),$this->pagehook, 'side', 'core');	
				$fn=$fn+1;				
			}
		}
	}
	
	function on_show_page() {
		
		global $screen_layout_columns;
		if( $this->data_array['page'][$this->pn]['page_type'] == 'admin_box' ) 
		{	
			if( count($this->data_array['content'][$this->pn]['contentbox']) > 10 ) { 
				wp_die( __(' Number of contentbox more then 10 !')); break; 
			}
			$fn = 0;
			if(!empty($this->data_array['content'][$this->pn]['contentbox'])) {
				foreach( $this->data_array['content'][$this->pn]['contentbox'] as $sid ){
					add_meta_box( $sid['contentbox_id'], $sid['contentbox_title'], array(&$this, 'cb_2_'.$fn),$this->pagehook, 'normal', 'core');
					$fn=$fn+1;				
				}
			}
		}
		
		?>
		
		<div id="pppm_wrap" class="wrap">
			<?php 
			if( !$this->data_array['page'][$this->pn]['page_screen_custom_icon'] ) {
				screen_icon($this->data_array['page'][$this->pn]['page_screen_icon']);
			}
			?>
			<h2>
			<?php 
			if( $this->data_array['page'][$this->pn]['page_screen_custom_icon'] ) { 
				echo '<img src = "'.$this->data_array['page'][$this->pn]['page_screen_custom_icon'].'" align="absmiddle" style="background:#FFFFFF; border:#CCCCCC 1px solid; padding:1px;"> &nbsp;'; } 
			 _e( $this->data_array['page'][$this->pn]['page_header']) ?>
			 </h2>
			<?php 
			if($this->data_array['page'][$this->pn]['page_include_file_top'] ) { 
				include( PPPM_2_FOLDER . $this->data_array['page'][$this->pn]['page_include_file_top'] ); 
			}
			?>
			<div id="poststuff" class="metabox-holder<?php echo $this->data_array['page'][$this->pn]['page_column_number'] == $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
				<?php 
				if( $this->data_array['page'][$this->pn]['page_type'] == 'admin_box' ) 
				{
		
					if($this->data_array['page'][$this->pn]['page_column_number'] == 2) 
					{
						?>
						<div id="side-info-column" class="inner-sidebar">
								<?php do_meta_boxes($this->pagehook , 'side', $data); ?>
						</div>
						
						<div id="post-body" class="has-sidebar">
							<div id="post-body-content" class="has-sidebar-content">
								<?php do_meta_boxes($this->pagehook , 'normal', $data); ?>
							</div>
						</div>
						<?php
					}
					else
					{
						do_meta_boxes($this->pagehook , 'normal', $data);
						do_meta_boxes($this->pagehook , 'side', $data);
					}
				?>
				<br class="clear"/>				
			</div>	
		</div>
		<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready( function($) {
				// close postboxes that should be closed
				$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
				// postboxes setup
				postboxes.add_postbox_toggles('<?php echo $this->pagehook ; ?>');
			});
			//]]>
		</script>
			<?php
			if($this->data_array['page'][$this->pn]['page_include_file_bottom'] ) include( PPPM_2_FOLDER . $this->data_array['page'][$this->pn]['page_include_file_bottom'] );
			}
			else {
				 if($this->data_array['page'][$this->pn]['page_include_file_bottom']) include( PPPM_2_FOLDER . $this->data_array['page'][$this->pn]['page_include_file_bottom'] );
			}
	}

	function sb_2_0($data) {$i = 0;foreach( $this->data_array['content'][$this->pn]['sidebox'] as $sb => $sid ){if($i == 0){if($sid['sidebox_data']){echo $sid['sidebox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	function sb_2_1($data) {$i = 0;foreach( $this->data_array['content'][$this->pn]['sidebox'] as $sb => $sid ){if($i == 1){if($sid['sidebox_data']){echo $sid['sidebox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	function sb_2_2($data) {$i = 0;foreach( $this->data_array['content'][$this->pn]['sidebox'] as $sb => $sid ){if($i == 2){if($sid['sidebox_data']){echo $sid['sidebox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	function sb_2_3($data) {$i = 0;foreach( $this->data_array['content'][$this->pn]['sidebox'] as $sb => $sid ){if($i == 3){if($sid['sidebox_data']){echo $sid['sidebox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	function sb_2_4($data) {$i = 0;foreach( $this->data_array['content'][$this->pn]['sidebox'] as $sb => $sid ){if($i == 4){if($sid['sidebox_data']){echo $sid['sidebox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	function sb_2_5($data) {$i = 0;foreach( $this->data_array['content'][$this->pn]['sidebox'] as $sb => $sid ){if($i == 5){if($sid['sidebox_data']){echo $sid['sidebox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	function sb_2_6($data) {$i = 0;foreach( $this->data_array['content'][$this->pn]['sidebox'] as $sb => $sid ){if($i == 6){if($sid['sidebox_data']){echo $sid['sidebox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	function sb_2_7($data) {$i = 0;foreach( $this->data_array['content'][$this->pn]['sidebox'] as $sb => $sid ){if($i == 7){if($sid['sidebox_data']){echo $sid['sidebox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	function sb_2_8($data) {$i = 0;foreach( $this->data_array['content'][$this->pn]['sidebox'] as $sb => $sid ){if($i == 8){if($sid['sidebox_data']){echo $sid['sidebox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	function sb_2_9($data) {$i = 0;foreach( $this->data_array['content'][$this->pn]['sidebox'] as $sb => $sid ){if($i == 9){if($sid['sidebox_data']){echo $sid['sidebox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	function sb_2_10($data){$i = 0;foreach($this->data_array['content'][$this->pn]['sidebox'] as $sb => $sid ){if($i == 10){if($sid['sidebox_data']){echo $sid['sidebox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	
	function cb_2_0($data) {$i = 0;foreach($this->data_array['content'][$this->pn]['contentbox'] as $cb => $sid ){if($i == 0){ if($sid['contentbox_data']){echo $sid['contentbox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	function cb_2_1($data) {$i = 0;foreach($this->data_array['content'][$this->pn]['contentbox'] as $cb => $sid ){if($i == 1){ if($sid['contentbox_data']){echo $sid['contentbox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	function cb_2_2($data) {$i = 0;foreach($this->data_array['content'][$this->pn]['contentbox'] as $cb => $sid ){if($i == 2){ if($sid['contentbox_data']){echo $sid['contentbox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	function cb_2_3($data) {$i = 0;foreach($this->data_array['content'][$this->pn]['contentbox'] as $cb => $sid ){if($i == 3){ if($sid['contentbox_data']){echo $sid['contentbox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	function cb_2_4($data) {$i = 0;foreach($this->data_array['content'][$this->pn]['contentbox'] as $cb => $sid ){if($i == 4){ if($sid['contentbox_data']){echo $sid['contentbox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	function cb_2_5($data) {$i = 0;foreach($this->data_array['content'][$this->pn]['contentbox'] as $cb => $sid ){if($i == 5){ if($sid['contentbox_data']){echo $sid['contentbox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	function cb_2_6($data) {$i = 0;foreach($this->data_array['content'][$this->pn]['contentbox'] as $cb => $sid ){if($i == 6){ if($sid['contentbox_data']){echo $sid['contentbox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	function cb_2_7($data) {$i = 0;foreach($this->data_array['content'][$this->pn]['contentbox'] as $cb => $sid ){if($i == 7){ if($sid['contentbox_data']){echo $sid['contentbox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	function cb_2_8($data) {$i = 0;foreach($this->data_array['content'][$this->pn]['contentbox'] as $cb => $sid ){if($i == 8){ if($sid['contentbox_data']){echo $sid['contentbox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	function cb_2_9($data) {$i = 0;foreach($this->data_array['content'][$this->pn]['contentbox'] as $cb => $sid ){if($i == 9){ if($sid['contentbox_data']){echo $sid['contentbox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}
	function cb_2_10($data){$i = 0;foreach($this->data_array['content'][$this->pn]['contentbox'] as $cb => $sid ){if($i == 10){ if($sid['contentbox_data']){echo $sid['contentbox_data'];}else{include ( PPPM_2_FOLDER . 'page_contents.php' );}}$i=$i+1;}}

}
$pppm_2_admin_class = new pppm_2_admin_box( $pppm_menu_array[2], $_GET['page'] );
$pppm_2_admin_class->pppm_admin();

?>