<?php 
global $wpdb ;

switch( $_GET['page'] ) {
	####################################################################################################
	#######  PAGE  #####################################################################################
	####################################################################################################
	case 'html' : 
	{
	
		switch ( $sb ) {
			////////////////////////////////////////////////////////////////////////////////////////////
			//////// SBOX //////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////////
			case 'html_teg_ref' : 
			{
				?>
				
				<script type="text/javascript">
				//<![CDATA[
					function sendAjaxRequest(tag)
					{
						$.post("<?php echo get_option('siteurl') ?>/wp-admin/admin-ajax.php", 
						{
						action:"pppm_overview", 
						"cookie": encodeURIComponent(document.cookie),
						"pppm_tag": tag 
						}, 
							function(str){
								var get_string = str;
								get_string=new String(get_string);
								var get_arr=get_string.split("-&pp&-");
								
								if( get_arr[0] ) {
									document.getElementById('tag_desc').innerHTML = get_arr[0];
								} else {
									document.getElementById('tag_desc').innerHTML = '<?php _e( 'There is no description' ) ?>';
								}
								if( get_arr[1] ) {
									document.getElementById('tag_example').innerHTML = get_arr[1];
								} else {
									document.getElementById('tag_example').innerHTML = '<?php _e( 'There is no example' ) ?>';
								}
							}
						);
					}
					//]]>
				</script>
				
				<table width="100%" border="0" cellpadding="2" class="pppm_tag_table" cellspacing="1">
					<tr valign="top" align="left">
						<td scope="row" class="pppm_table_td">
						<form name="pppm_form_tag_ref" >
						<select name="pppm_tag_ref">
						<?php 
						$pppm_res = $wpdb->get_results("SELECT `tag`,`status_post`,`status_page`,`status_comment` FROM `".$wpdb->prefix."pppm_html` ORDER BY `tag` ASC ");
						foreach ( $pppm_res as $res ) 
						{
							if( !$res->status_post || !$res->status_comment || !$res->status_page )
								{echo '<option class="pppm_option_disallow" value="'.$res->tag.'">&lt;'.$res->tag.'&gt;</option>';}
							else
								{echo '<option class="pppm_option_allow" value="'.$res->tag.'">&lt;'.$res->tag.'&gt;</option>';}
						 }
						?>
						</select>&nbsp;&nbsp;
						<input type="button" value="<?php _e( 'Read') ?>" 
						onclick="sendAjaxRequest(pppm_form_tag_ref.pppm_tag_ref.options[pppm_form_tag_ref.pppm_tag_ref.selectedIndex].value)" style="cursor:pointer" name="read" >
						</form>
						</td>
					</tr>
					<tr>
					<td class="pppm_box_desc">
					<div id="tag_desc">
						<?php _e( 'Tag Description' ) ?>
					</div>
					</td>
					</tr>
					<tr>
					<td class="pppm_box_tag_example">
					  <br />
					  <div id="tag_example">
					  	<?php _e( 'Tag Example' ) ?>
					  </div>
					  <br /><br />
					  <a href="http://htmlhelp.com/reference/wilbur/list.html" target="_blank">
					  <?php _e( 'Read more' ) ?> ...
					  </a>
					</td>
					</tr>
				</table>
				
				<?php
				
			} break ;
			////////////////////////////////////////////////////////////////////////////////////////////
			//////// SBOX //////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////////
			case 'allowed_protocol' : 
			{
				?>
				<a name="protocol"></a>
				<form id="pppm_form_protocol" name="pppm_form_protocol" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>#protocol">
					<input type="hidden" name="pppm_hidden" 
					value="<?php if( $_GET['pppm_ps'] == 'c' ) { print('pppm_form_comment_protocol'); }
								  elseif( $_GET['pppm_ps'] == 'd' ) { print('pppm_form_page_protocol'); }
								  else { print('pppm_form_post_protocol'); } ?>">
				<table width="100%" border="0" cellspacing="0" cellpadding="1">
				  <tr>
					<td width="33%" class="pppm_box_desc_button">
						<?php
						if($_GET['pppm_ps'] == 'p' || !isset($_GET['pppm_ps']) ) {
							echo '<div class="pppm_link_button_activ">'.__( 'Post').'</div>';
						}
						else {
							echo '<div class="pppm_link_button_inactiv">
							<a href="'.str_replace( '&pppm_ps=p','',str_replace( '&pppm_ps=d','',str_replace('&pppm_ps=c','',str_replace( '%7E', '~', $_SERVER['REQUEST_URI'])))).'&pppm_ps=p#protocol" class="pppm_tagbox_link">'.__( 'Post').'</div>';
						}
						?>
					</td>
					<td width="33%" class="pppm_box_desc_button">
						<?php
						if($_GET['pppm_ps'] == 'd' ) {
							echo '<div class="pppm_link_button_activ">'.__( 'Page').'</div>';
						}
						else {
							echo '<div class="pppm_link_button_inactiv">
							<a href="'.str_replace( '&pppm_ps=p','',str_replace( '&pppm_ps=d','',str_replace('&pppm_ps=c','',str_replace( '%7E', '~', $_SERVER['REQUEST_URI'])))).'&pppm_ps=d#protocol" class="pppm_tagbox_link">'.__( 'Page').'</div>';
						}
						?>
					</td>
					<td width="34%" class="pppm_box_desc_button">
					<?php
						if($_GET['pppm_ps'] == 'c') {
							echo '<div class="pppm_link_button_activ">'.__( 'Comment').'</div>';
						}
						else {
							echo '<div class="pppm_link_button_inactiv">
							<a href="'.str_replace( '&pppm_ps=p','',str_replace( '&pppm_ps=d','',str_replace('&pppm_ps=c','',str_replace( '%7E', '~', $_SERVER['REQUEST_URI'])))).'&pppm_ps=c#protocol" class="pppm_tagbox_link">'.__( 'Comment').'
							</div>';
						}
					?>
					</td>
				  </tr>
				  <tr>
					<td colspan="3" align="left" class="pppm_box_desc">
					<span class="pppm_small_font"><?php _e( 'Check/Uncheck All') ?></span>
					<input type="checkbox" value="<?php _e( 'Check All') ?>" style="cursor:pointer" name="checkall" onclick="checkedAll('pppm_form_protocol');">
					</td>
				  </tr>
				  <tr>
				  <td colspan="3">
				   <table width="100%" class="pppm_tag_table" border="0" cellspacing="1" cellpadding="2">
				    <tr bgcolor="#FFFFFF">
				<?php
				if($_GET['pppm_ps'] == 'c') {
				
					$pppm_res = $wpdb->get_results("SELECT `id`,`protocol`,`status_comment` FROM `".$wpdb->prefix."pppm_protocol` ORDER BY `protocol` ASC ");
					$pppm_i= 0;
					foreach ( $pppm_res as $res ) 
					{
						if($res->status_comment)
						{
							$pppm_protocol_str=$res->protocol;
							$pppm_protocol_checked = '';
						}
						else
						{
							$pppm_protocol_str = '<font color="#FF3E3E">'.$res->protocol.'</font>';
							$pppm_protocol_checked = 'checked="checked"';
						}
						( $res->protocol == 'http' ) ? $pppm_protocol_dis = 'disabled="disabled"' : $pppm_protocol_dis = '';
						if($pppm_i%4 == 0 && $pppm_i > 0) echo '</tr> <tr bgcolor="#FFFFFF">';
						echo '<td class="pppm_protocol_table_td">
						<input type="checkbox" '.$pppm_protocol_dis.' name="pppm_protocol[]" id="'.$res->protocol.'" value="'.$res->protocol.'" '.$pppm_protocol_checked.' />
						<br><label for="'.$res->protocol.'">'.$pppm_protocol_str.'</label>
						</td>'; 
						$pppm_i = $pppm_i+1;
					 }
				
				}
				elseif($_GET['pppm_ps'] == 'd') {
				
					$pppm_res = $wpdb->get_results("SELECT `id`,`protocol`,`status_page` FROM `".$wpdb->prefix."pppm_protocol` ORDER BY `protocol` ASC ");
					$pppm_i= 0;
					foreach ( $pppm_res as $res ) 
					{
						if($res->status_page)
						{
							$pppm_protocol_str = $res->protocol;
							$pppm_protocol_checked = '';
						}
						else
						{
							$pppm_protocol_str = '<font color="#FF3E3E">'.$res->protocol.'</font>';
							$pppm_protocol_checked = 'checked="checked"';
						}
						
						( $res->protocol == 'http' ) ? $pppm_protocol_dis = 'disabled="disabled"' : $pppm_protocol_dis = '';
						if( $pppm_i%4 == 0 && $pppm_i > 0 ) echo '</tr> <tr bgcolor="#FFFFFF">';
						echo '<td class="pppm_protocol_table_td">
						<input type="checkbox" '.$pppm_protocol_dis.' name="pppm_protocol[]" id="'.$res->protocol.'" value="'.$res->protocol.'" '.$pppm_protocol_checked.' />
						<br><label for="'.$res->protocol.'">'.$pppm_protocol_str.'</label>
						</td>'; 
						$pppm_i = $pppm_i+1;
					 }
				
				
				}
				else {
				
					$pppm_res = $wpdb->get_results("SELECT `id`,`protocol`,`status_post` FROM `".$wpdb->prefix."pppm_protocol` ORDER BY `protocol` ASC ");
					$pppm_i= 0;
					foreach ( $pppm_res as $res ) 
					{
						if($res->status_post)
						{
							$pppm_protocol_str=$res->protocol;
							$pppm_protocol_checked = '';
						}
						else
						{
							$pppm_protocol_str = '<font color="#FF3E3E">'.$res->protocol.'</font>';
							$pppm_protocol_checked = 'checked="checked"';
						}
						
						( $res->protocol == 'http' ) ? $pppm_protocol_dis = 'disabled="disabled"' : $pppm_protocol_dis = '';
						if($pppm_i%4 == 0 && $pppm_i > 0) echo '</tr> <tr bgcolor="#FFFFFF">';
						echo '<td class="pppm_protocol_table_td">
						<input type="checkbox" '.$pppm_protocol_dis.' name="pppm_protocol[]" id="'.$res->protocol.'" value="'.$res->protocol.'" '.$pppm_protocol_checked.' />
						<br><label for="'.$res->protocol.'">'.$pppm_protocol_str.'</label>
						</td>'; 
						$pppm_i = $pppm_i+1;
					 }
				
				}
				
				 ?> 
					</tr>
				  </table>
				  
				  </td>
				  </tr>
				  <tr>
					<td  colspan="3"><br style="font-size:5px" />
						<p class="submit" style="padding:1px">
						<input type="submit" name="Submit" value="<?php _e( 'Disable Protocols' ) ?>" />
						</p>
					</td>
				  </tr>
				</table>
				</form>
				<?php
			}break;
			////////////////////////////////////////////////////////////////////////////////////////////
			//////// SBOX //////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////////
			case 'html_manipulations' : 
			{
				?>
				<a name="html_manipulations"></a>
				<form id="pppm_form_manipulations" name="pppm_form_manipulations" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>#html_manipulations">
					<input type="hidden" name="pppm_hidden" value="pppm_html_manipulations">
				<table width="100%" border="0" cellspacing="0" cellpadding="1">
				  <tr>
					<td width="33%" class="pppm_box_desc_button">
						<table width="100%" border="0" cellspacing="2" cellpadding="2">
                          <tr>
                            <td><label for="pppm_link_to_blank">Change all link targets to new window</label></td>
                            <td style="text-align:center;"><input type="checkbox" id="pppm_link_to_blank" <?php (get_option('pppm_link_to_blank')) ? print('checked="checked"') : print('') ; ?> name="pppm_link_to_blank" value="1"</td>
                          </tr>
                        </table>
					</td>
				  </tr>
				  <tr>
					<td  colspan="3"><br style="font-size:5px" />
						<p class="submit" style="padding:1px">
						<input type="submit" name="Submit" value="<?php _e( 'Save Options' ) ?>" />
						</p>
					</td>
				  </tr>
				</table>
				</form>
				<?php
			}break;
			////////////////////////////////////////////////////////////////////////////////////////////
			//////// SBOX //////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////////
		} 
		
		################################################################################################
		////////////////////////////////////////////////////////////////////////////////////////////////
		################################################################################################
		switch( $cb ) {
			////////////////////////////////////////////////////////////////////////////////////////////
			//////// CBOX //////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////////
			case 'tag_form' : 
			{
				?>
				<script language="javascript">
				checked = false ;
				function checkedAll (form_id) {
					var aa= document.getElementById(form_id);
					if (checked == false) {checked = true;} else{checked = false;}
					for (var i =0; i < aa.elements.length; i++) {aa.elements[i].checked = checked;}
				}
				</script>
				<!-- Script by hscripts.com -->
				<form id="pppm_form_tags" name="pppm_form_tags" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
					<input type="hidden" name="pppm_hidden" 
					value="<?php if( $_GET['pppm_ts'] == 'c' ) { print('pppm_form_comment_tags'); }
								  elseif( $_GET['pppm_ts'] == 'd' ) { print('pppm_form_page_tags'); }
								  else { print('pppm_form_post_tags'); } ?>">
				<table width="100%" border="0" cellspacing="0" cellpadding="1">
				  <tr>
					<td width="33%" class="pppm_box_desc_button">
						<?php
						if($_GET['pppm_ts'] == 'p' || !isset($_GET['pppm_ts']) ) {
							echo '<div class="pppm_link_button_activ">'.__( 'Post setting').'</div>';
						}
						else {
							echo '<div class="pppm_link_button_inactiv">
							<a href="'.str_replace( '&pppm_ts=p','',str_replace( '&pppm_ts=d','',str_replace('&pppm_ts=c','',str_replace( '%7E', '~', $_SERVER['REQUEST_URI'])))).'&pppm_ts=p#tag" class="pppm_tagbox_link">'.__( 'Post setting').'</div>';
						}
						?>
					</td>
					<td width="33%" class="pppm_box_desc_button">
					<?php
						if( $_GET['pppm_ts'] == 'd' ) {
							echo '<div class="pppm_link_button_activ">'.__( 'Page setting').'</div>';
						}
						else{
							echo '<div class="pppm_link_button_inactiv">
							<a href="'.str_replace( '&pppm_ts=p','',str_replace( '&pppm_ts=d','',str_replace('&pppm_ts=c','',str_replace( '%7E', '~', $_SERVER['REQUEST_URI'])))).'&pppm_ts=d#tag" class="pppm_tagbox_link">'.__( 'Page setting').'
							</div>';
						}
					?>
					</td>
					<td width="34%" class="pppm_box_desc_button">
					<?php
						if($_GET['pppm_ts'] == 'c') {
							echo '<div class="pppm_link_button_activ">'.__( 'Comment setting').'</div>';
						}
						else {
							echo '<div class="pppm_link_button_inactiv">
							<a href="'.str_replace( '&pppm_ts=d','',str_replace( '&pppm_ts=p','',str_replace('&pppm_ts=c','',str_replace( '%7E', '~', $_SERVER['REQUEST_URI'])))).'&pppm_ts=c#tag" class="pppm_tagbox_link">'.__( 'Comment setting').'
							</div>';
						}
					?>
					</td>
				  </tr>
				  <tr>
					<td colspan="3" align="left" class="pppm_box_desc">
					<?php _e( 'Check the tags and make these as disabled ') ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
					<span class="pppm_small_font"><?php _e( 'Check/Uncheck All') ?></span>
					<input type="checkbox" value="<?php _e( 'Check All') ?>" style="cursor:pointer" name="checkall" onclick="checkedAll('pppm_form_tags');">
					</td>
				  </tr>
				  <tr>
				  <td colspan="3">
				   <table width="100%" class="pppm_tag_table" border="0" cellspacing="1" cellpadding="2">
				    <tr bgcolor="#FFFFFF">
				<?php
				if( $_GET['pppm_ts'] == 'c' ) {
				
					$pppm_res = $wpdb->get_results("SELECT `id`,`tag`,`status_comment` FROM `".$wpdb->prefix."pppm_html` ORDER BY `tag` ASC ");
					$pppm_i= 0;
					foreach ( $pppm_res as $res ) 
					{
						if($res->status_comment)
						{
							$pppm_tag_str='&lt;'.$res->tag.'&gt;';
							$pppm_tag_checked = '';
						}
						else
						{
							$pppm_tag_str = '<font color="#FF3E3E">&lt;'.$res->tag.'&gt;</font>';
							$pppm_tag_checked = 'checked="checked"';
						}
						
						if($pppm_i%6 == 0 && $pppm_i > 0) echo '</tr> <tr bgcolor="#FFFFFF">';
						echo '<td class="pppm_tag_table_td">
						<input type="checkbox" name="pppm_tags[]" id="'.$res->tag.'" value="'.$res->tag.'" '.$pppm_tag_checked.' />
						<br><label for="'.$res->tag.'">'.$pppm_tag_str.'</label>
						</td>'; 
						$pppm_i = $pppm_i+1;
					 }
				
				
				}
				elseif( $_GET['pppm_ts'] == 'd' ) {
				
					$pppm_res = $wpdb->get_results("SELECT `id`,`tag`,`status_page` FROM `".$wpdb->prefix."pppm_html` ORDER BY `tag` ASC ");
					$pppm_i= 0;
					foreach ( $pppm_res as $res ) 
					{
						if($res->status_page)
						{
							$pppm_tag_str='&lt;'.$res->tag.'&gt;';
							$pppm_tag_checked = '';
						}
						else
						{
							$pppm_tag_str = '<font color="#FF3E3E">&lt;'.$res->tag.'&gt;</font>';
							$pppm_tag_checked = 'checked="checked"';
						}
						
						if($pppm_i%6 == 0 && $pppm_i > 0) echo '</tr> <tr bgcolor="#FFFFFF">';
						echo '<td class="pppm_tag_table_td">
						<input type="checkbox" name="pppm_tags[]" id="'.$res->tag.'" value="'.$res->tag.'" '.$pppm_tag_checked.' />
						<br><label for="'.$res->tag.'">'.$pppm_tag_str.'</label>
						</td>'; 
						$pppm_i = $pppm_i+1;
					 }
				}
				else {
				
					$pppm_res = $wpdb->get_results("SELECT `id`,`tag`,`status_post` FROM `".$wpdb->prefix."pppm_html` ORDER BY `tag` ASC ");
					$pppm_i= 0;
					foreach ( $pppm_res as $res ) 
					{
						if($res->status_post)
						{
							$pppm_tag_str='&lt;'.$res->tag.'&gt;';
							$pppm_tag_checked = '';
						}
						else
						{
							$pppm_tag_str = '<font color="#FF3E3E">&lt;'.$res->tag.'&gt;</font>';
							$pppm_tag_checked = 'checked="checked"';
						}
						
						if($pppm_i%6 == 0 && $pppm_i > 0) echo '</tr> <tr bgcolor="#FFFFFF">';
						echo '<td class="pppm_tag_table_td">
						<input type="checkbox" name="pppm_tags[]" id="'.$res->tag.'" value="'.$res->tag.'" '.$pppm_tag_checked.' />
						<br><label for="'.$res->tag.'">'.$pppm_tag_str.'</label>
						</td>'; 
						$pppm_i = $pppm_i+1;
					 }
				
				
				}
				
				 ?> 
					</tr>
				  </table>
				  
				  </td>
				  </tr>
				  <tr>
					<td  colspan="3"><br style="font-size:9px" />
						<p class="submit">
						<input type="submit" name="Submit" value="<?php _e( 'Disable HTML Tags' ) ?>" />
						</p>
					</td>
				  </tr>
				</table>
				</form>
				<?php
				
			} break ;
			////////////////////////////////////////////////////////////////////////////////////////////
			//////// CBOX //////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////////
		}
		
	} break ;
	
}

?>
			