<?php

	global $wpdb;
	
	#############################################################################################
	if( $_POST[ 'pppm_hidden' ] == 'pppm_form_post_tags' ) {
			
		$pppm_tags = $_POST['pppm_tags'] ;
		$wpdb->query("UPDATE `".$wpdb->prefix."pppm_html` SET `status_post` = 1 ");
		if(!empty($pppm_tags))
		{
			foreach ( $pppm_tags as $pppm_tag_name )
			{
				$wpdb->query("UPDATE `".$wpdb->prefix."pppm_html` SET `status_post` = 0 WHERE `tag` = '$pppm_tag_name'");
			}
		}
		echo '<div class="updated"><p><strong>'. __( 'Options saved.' ) .'</strong></p></div>';
	}
	elseif(  $_POST[ 'pppm_hidden' ] == 'pppm_form_page_tags'  ) {
	
		$pppm_tags = $_POST['pppm_tags'] ;
		$wpdb->query("UPDATE `".$wpdb->prefix."pppm_html` SET `status_page` = 1 ");
		if(!empty($pppm_tags))
		{
			foreach ( $pppm_tags as $pppm_tag_name )
			{
				$wpdb->query("UPDATE `".$wpdb->prefix."pppm_html` SET `status_page` = 0 WHERE `tag` = '$pppm_tag_name'");
			}
		}
		echo '<div class="updated"><p><strong>'. __( 'Options saved.' ) .'</strong></p></div>';
	
	}
	elseif(  $_POST[ 'pppm_hidden' ] == 'pppm_form_comment_tags'  ) {
	
		$pppm_tags = $_POST['pppm_tags'] ;
		$wpdb->query("UPDATE `".$wpdb->prefix."pppm_html` SET `status_comment` = 1 ");
		if(!empty($pppm_tags))
		{
			foreach ( $pppm_tags as $pppm_tag_name )
			{
				$wpdb->query("UPDATE `".$wpdb->prefix."pppm_html` SET `status_comment` = 0 WHERE `tag` = '$pppm_tag_name'");
			}
		}
		echo '<div class="updated"><p><strong>'. __( 'Options saved.' ) .'</strong></p></div>';
	
	}
	elseif( $_POST[ 'pppm_hidden' ] == 'pppm_form_post_protocol' ) {
			
		$pppm_protocol = $_POST['pppm_protocol'] ;
		$wpdb->query("UPDATE `".$wpdb->prefix."pppm_protocol` SET `status_post` = 1 ");
		if(!empty($pppm_protocol))
		{
			foreach ( $pppm_protocol as $pppm_protocol_name )
			{
				$wpdb->query("UPDATE `".$wpdb->prefix."pppm_protocol` SET `status_post` = 0 WHERE `protocol` = '$pppm_protocol_name'");
			}
		}
		echo '<div class="updated"><p><strong>'. __( 'Options saved.' ) .'</strong></p></div>';
	}
	elseif( $_POST[ 'pppm_hidden' ] == 'pppm_form_page_protocol' ) {
			
		$pppm_protocol = $_POST['pppm_protocol'] ;
		$wpdb->query("UPDATE `".$wpdb->prefix."pppm_protocol` SET `status_page` = 1 ");
		if(!empty($pppm_protocol))
		{
			foreach ( $pppm_protocol as $pppm_protocol_name )
			{
				$wpdb->query("UPDATE `".$wpdb->prefix."pppm_protocol` SET `status_page` = 0 WHERE `protocol` = '$pppm_protocol_name'");
			}
		}
		echo '<div class="updated"><p><strong>'. __( 'Options saved.' ) .'</strong></p></div>';
	}
	elseif(  $_POST[ 'pppm_hidden' ] == 'pppm_form_comment_protocol'  ) {
	
		$pppm_protocol = $_POST['pppm_protocol'] ;
		$wpdb->query("UPDATE `".$wpdb->prefix."pppm_protocol` SET `status_comment` = 1 ");
		if(!empty($pppm_protocol))
		{
			foreach ( $pppm_protocol as $pppm_protocol_name )
			{
				$wpdb->query("UPDATE `".$wpdb->prefix."pppm_protocol` SET `status_comment` = 0 WHERE `protocol` = '$pppm_protocol_name'");
			}
		}
		echo '<div class="updated"><p><strong>'. __( 'Options saved.' ) .'</strong></p></div>';
	
	}
	elseif(  $_POST[ 'pppm_hidden' ] == 'pppm_html_manipulations'  ) {
		update_option( 'pppm_link_to_blank', $_POST['pppm_link_to_blank'] );
	}
#############################################################################################
	
	if( get_option('pppm_onoff_html_manager') ) 
	{
		$pppm_onoff_html_manager['on_check'] = 'checked="checked"';
		$pppm_onoff_html_manager['off_check'] = '';
	} 
	else 
	{
		$pppm_onoff_html_manager['on_check'] = '';
		$pppm_onoff_html_manager['off_check'] = 'checked="checked"';
	}
		
?>
		
<br />
<table width="100%" border="0" cellspacing="1" class="pppm_option_table">
  <tr>
    <td class="pppm_table_td"><div class="pppm_top_desc"><?php _e('Here you can manage HTML tags and protocols , which can be desabled in posts , pages and comments .') ?></div></td>
  </tr>
</table> 
<br />
