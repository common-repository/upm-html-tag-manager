<?php

function upm_manipulations( $str ){
	if(!function_exists('upm_link_target') && get_option('pppm_link_to_blank')){ $str = preg_replace( '|(<a[^><]+)(>)|i', '$1 target="_blank" $2', $str );}
	return $str;
}
add_filter( "the_content", "upm_manipulations");

################################################################################################################
function pppm_html_manager ( $string ) {
	
	global $wpdb;
	global $allowedposttags;
	global $additional_tags;
	global $post;
	global $userdata;
	
	if( is_admin() ) {
		$pppm_userdata = $userdata;
	}
	else {
		if(!IS_WPMU){
			$pppm_user = wp_get_current_user();
			$pppm_array = $pppm_user->roles;
		}
		else{
			$pppm_userdata = get_userdata( $post->post_author );
			$pppm_array = $pppm_userdata->wp_capabilities;
		}
	}
	if( $pppm_array[0] == '' )$pppm_array[0] = 'administrator';
	$pppm_user_role = array_keys( $pppm_array );
	$allowedposttags = array_merge( $allowedposttags, $additional_tags );
	$string = stripslashes(trim( $string ));
	( is_page() ) ? $mode = 'page': $mode = 'post';
	
	///////////////////////////////////////////////////////////
	///////////////// HTML Manager ////////////////////////////
	///////////////////////////////////////////////////////////
	$mode_html_post = false;
	$mode_html_page = false;
	if( get_option( 'pppm_onoff_html_manager' ) ) {
		if( get_option( 'pppm_html_role_'.$pppm_user_role[0] )) { 
			if( get_option( 'pppm_onoff_html_manager_post' ) && $mode == 'post' ) { $mode_html_post = true; }
			if( get_option( 'pppm_onoff_html_manager_page' ) && $mode == 'page' ) { $mode_html_page = true; }
		}
		if( ( $mode == 'post' && $mode_html_post ) || ( $mode == 'page' && $mode_html_page ) ) {
			///////////////////////////////////////////////////////////////
			$pppm_res = $wpdb->get_results("SELECT `tag` FROM `".$wpdb->prefix."pppm_html` WHERE `status_".$mode."` = 1 ");
			foreach ( $pppm_res as $res ) {
				$allowed_html[$res->tag] = $allowedposttags[$res->tag];
			}
			$pppm_res = $wpdb->get_results("SELECT `protocol` FROM `".$wpdb->prefix."pppm_protocol` WHERE `status_".$mode."` = 1 ");
			foreach ( $pppm_res as $res ) {
				$allowed_protocols[] = $res->protocol;
			}
			
			foreach ( $allowed_html as $key => $check_empty ) {
			
				if( !is_array( $check_empty )) continue;
				$allowed_html_array[ $key ] = $check_empty;
			}
			
			$string = wp_kses($string, $allowed_html_array, $allowed_protocols);
			/////////////////////////////////////////////////////////////////
		}
	}
	
	return $string;
}

##################################################################################################
function  pppm_html_manager_after_comments ( $string ) {
	
	global $wpdb;
	global $allowedposttags;
	global $additional_tags;
	global $comment;
	
	$allowedposttags = array_merge( $allowedposttags, $additional_tags );
	$string = stripslashes(trim( $string ));
	///////////////////////////////////////////////////////////
	///////////////// HTML Manager ////////////////////////////
	///////////////////////////////////////////////////////////
	if( get_option( 'pppm_onoff_html_manager' ) ) {
		if( $comment->user_id ) {
			$pppm_userdata = get_userdata( $comment->user_id );
			$pppm_user_role = array_keys( $pppm_userdata->wp_capabilities );
			if( get_option( 'pppm_html_role_'.$pppm_user_role[0] ) &&  get_option( 'pppm_onoff_html_manager_comment' ) ) {
				///////////////////////////////////////////////////////////////
				$pppm_res = $wpdb->get_results("SELECT `tag` FROM `".$wpdb->prefix."pppm_html` WHERE `status_comment` = 1 ");
				foreach ( $pppm_res as $res ) {
				
					$allowed_html[$res->tag] = $allowedposttags[$res->tag];
				}
				unset($pppm_res);
				$pppm_res = $wpdb->get_results("SELECT `protocol` FROM `".$wpdb->prefix."pppm_protocol` WHERE `status_comment` = 1 ");
				foreach ( $pppm_res as $res ) {
				
					$allowed_protocols[$res->protocol] = $res->protocol;
				}
				
				foreach ( $allowed_html as $key => $check_empty ) {
			
					if( !is_array( $check_empty )) continue;
					$allowed_html_array[ $key ] = $check_empty;
				}
				
				$string = wp_kses($string, $allowed_html_array, $allowed_protocols);
				/////////////////////////////////////////////////////////////////
			}
		}
	}
	return $string;
}
###############################################################################################################
function  pppm_html_manager_before_comments( $string ) {
	
	global $wpdb;
	global $allowedposttags;
	global $additional_tags;
	global $comment;
	global $userdata;
	
	$allowedposttags = array_merge( $allowedposttags, $additional_tags );
	$string = stripslashes(trim( $string ));
	
	$pppm_userdata = $userdata;
	///////////////////////////////////////////////////////////
	///////////////// HTML Manager ////////////////////////////
	///////////////////////////////////////////////////////////
	if( get_option( 'pppm_onoff_html_manager' ) ) {
		if( $pppm_userdata->ID ) {
			
			$pppm_user_role = array_keys( $pppm_userdata->wp_capabilities );
			
			if( get_option( 'pppm_html_role_'.$pppm_user_role[0] ) &&  get_option( 'pppm_onoff_html_manager_comment' ) ) {
				///////////////////////////////////////////////////////////////
				$pppm_res = $wpdb->get_results("SELECT `tag` FROM `".$wpdb->prefix."pppm_html` WHERE `status_comment` = 1 ");
				foreach ( $pppm_res as $res ) {
				
					$allowed_html[$res->tag] = $allowedposttags[$res->tag];
				}
				unset($pppm_res);
				$pppm_res = $wpdb->get_results("SELECT `protocol` FROM `".$wpdb->prefix."pppm_protocol` WHERE `status_comment` = 1 ");
				foreach ( $pppm_res as $res ) {
				
					$allowed_protocols[$res->protocol] = $res->protocol;
				}
				
				foreach ( $allowed_html as $key => $check_empty ) {
			
					if( !is_array( $check_empty )) continue;
					$allowed_html_array[ $key ] = $check_empty;
				}
				
				$string = wp_kses($string, $allowed_html_array, $allowed_protocols);
				/////////////////////////////////////////////////////////////////
			}
		}
	}
	return $string;
}
?>