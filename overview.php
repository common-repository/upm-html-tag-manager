<?php

	global $wpdb;
	
	global $wp_roles;
	$pppm_roles = $wp_roles->role_names;
	foreach( $pppm_roles as $pppm_key => $pppm_val ) {
		$pppm_role_options[] = 'pppm_html_role_'. $pppm_key;
		$pppm_role_options[] = 'pppm_filter_role_'. $pppm_key;
	}
	
	$pppm_options = array(	'pppm_onoff_html_manager',
							'pppm_onoff_html_manager_post',
							'pppm_onoff_html_manager_page',
							'pppm_onoff_html_manager_comment',
							'pppm_html_manager_executing' );
	
	$pppm_options = array_merge ( $pppm_options, $pppm_role_options);
	
	
	if( $_POST[ 'pppm_hidden' ] == 'x' ) {
	
		foreach( $pppm_options as $pppm ) {
		
			( $_POST[ $pppm ] == '' ) ? $pppm_op = 0 : $pppm_op = $_POST[ $pppm ];
			update_option( $pppm, $pppm_op );
		}
				
		?>
		<div class="updated"><p><strong><?php _e( 'Options saved.' ); ?></strong></p></div>
		<?php
		
	}

	foreach( $pppm_options as $pppm ) {
		
		if( get_option($pppm) ) {
			
			$pppm_checked['checkbox'][ $pppm ][ 'checked' ] = 'checked="checked"';
			$pppm_checked['radio'][ $pppm ][ 'on_check' ] = 'checked="checked"';
			$pppm_checked['radio'][ $pppm ][ 'off_check' ] = '';
		} 
		else {
		
			$pppm_checked['checkbox'][ $pppm ][ 'checked' ] = '';
			$pppm_checked['radio'][ $pppm ][ 'on_check' ] = '';
			$pppm_checked['radio'][ $pppm ][ 'off_check' ] = 'checked="checked"';
		}
	}

?>
<br />
<br />
<style type="text/css">
.pppm_option_table {
background-color:#CCCCCC;
}
.pppm_option_th {
background-color:#F9F9F9;
text-align:left;
font-weight:100;
padding:2px;
width:60%;
}
.pppm_option_td {
background-color:#F9F9F9;
text-align:left;
font-weight:100;
padding:2px;
width:40%;
}
.pppm_option_top_th {
background-color:#F0F0F0;
text-align:left;
font-weight:bold;
padding:2px;
width:60%;
}
.pppm_option_top_td {
background-color:#F0F0F0;
text-align:left;
font-weight:bold;
padding:2px;
width:40%;
}
ul li{
padding-left:0px;
font-size:13px;
}
.upm_yes{
	list-style-image:url(<?php echo PPPM_2_PATH ?>img/1.gif);
}
.upm_no{
	list-style-image:url(<?php echo PPPM_2_PATH ?>img/0.gif);
}
</style>

	<form name="form_options" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="pppm_hidden" value="x">
        <table width="100%" border="0">
          <tr>
            <td style="padding:10px; padding-left:0px;">
            	<table width="100%" border="0" cellspacing="1" class="widefat">
        <thead>
        <tr>
        <th>&nbsp;Information</th>
        </tr>
        </thead>
			<tr valign="top">
				<td style="background:#FFF; padding:5px; text-align:left; font-size:13px;">
				"UPM HTML Tag Manager" is a part of the "Universal Polst Manager" plugin and only html tag and protocol filtering features are available here. If you want to use complete version of this plugin you should deactivate ( not uninstall ) "UPM HTML Tag Manager" then install latest version of <a href="http://wordpress.org/extend/plugins/universal-post-manager/" target="_blank">Universal Post Manager</a>.
                <br />Please DO NOT use both plugins together , one of them should be deactivated !
                <br /><br /><strong>All features of Universal Post Manager:</strong>
                <div style="margin-left:40px; margin-top:10px;">
                <ul>
                <li class="upm_yes">HTML tag Manager ,</li>
    			 <li class="upm_yes">Protocol Manager,</li>
                 <li class="upm_no">Phrase filtering and shortcut Manager</li>
                 <li class="upm_no">Long Phrase Manager</li>
                 <li class="upm_no">Post and page Saving Manager ( Save as Text, HTML, MS Word, PDF, XML )</li>
                 <li class="upm_no">Share Manager ( Social Bookmarks, Email, Subscribe )</li>
                 <li class="upm_no">Poll Manager</li>
                 <li class="upm_no">Print Manager</li>
                </ul>
                </div>
                </td>
			</tr>
        </table>
            </td>
            <td valign="top" style="padding:10px; padding-right:0px;">
            	<table width="100%" border="0" cellspacing="1" class="widefat">
                    <thead>
                    <tr>
                    <th>&nbsp;Like UPM HTML Tag Manager plugin?</th>
                    </tr>
                    </thead>
                        <tr valign="top">
                            <td style="background:#FFF; padding:5px; text-align:left; font-size:13px;">
                            <ul>
                            <li>Why not do any or all of the following:</li>
                            <li>- Link to it so other folks can find out about it.</li>
                            <li>- Give it a good rating on <a href="http://wordpress.org/extend/plugins/upm-html-tag-manager/" target="_blank">WordPress.org.</a></li>
                            </ul>
                            </td>
                        </tr>
                    </table>
        	<br />
                <table width="100%" border="0" cellspacing="1" class="widefat">
                <thead>
                <tr>
                <th>&nbsp;Need Help?</th>
                </tr>
                </thead>
                    <tr valign="top">
                        <td style="background:#FFF; padding:5px; text-align:left; font-size:13px;">
                        If you need help with this plugin , add custom features, or if you want to make a suggestion, then please visit to our forum at <a href="http://www.profprojects.com/forum/" target="_blank">ProfProjects.com</a>
                        </td>
                    </tr>
            </table>
            </td>
          </tr>
        </table>
        <br />
		<table width="100%" border="0" cellspacing="1" class="widefat">
        <thead>
			<tr valign="top">
				<th>
				<strong><?php _e( 'Turn On/Off HTML & Protocol Manager' ) ?></strong>
				</th>
				<th style="padding-left:0px;">
				<input type="radio" id="pppm_onoff_html_manager_1" name="pppm_onoff_html_manager" value="1" 
				<?php echo $pppm_checked['radio'][ 'pppm_onoff_html_manager' ][ 'on_check' ] ?>/> 
				<label for="pppm_onoff_html_manager_1"><?php _e( 'On' ) ?></label>&nbsp;
				<input type="radio" id="pppm_onoff_html_manager_0" name="pppm_onoff_html_manager" value="0" 
				<?php echo $pppm_checked['radio'][ 'pppm_onoff_html_manager' ][ 'off_check' ] ?> />
				<label for="pppm_onoff_html_manager_0"><?php _e( 'Off' ) ?></label>
				
				</th>
			</tr>
         </thead>
			<tr valign="top">
				<th class="pppm_option_th">
				<?php _e( 'Turn on/off HTML & Protocol Manager in posts' ) ?>
				</th>
				<td class="pppm_option_td">
				<input type="radio" id="pppm_onoff_html_manager_post_1" name="pppm_onoff_html_manager_post" value="1" 
				<?php echo $pppm_checked['radio'][ 'pppm_onoff_html_manager_post' ][ 'on_check' ] ?>/> 
				<label for="pppm_onoff_html_manager_post_1"><?php _e( 'On' ) ?></label> &nbsp;&nbsp; 
				<input type="radio" id="pppm_onoff_html_manager_post_0" name="pppm_onoff_html_manager_post" value="0" 
				<?php echo $pppm_checked['radio'][ 'pppm_onoff_html_manager_post' ][ 'off_check' ] ?> />
				<label for="pppm_onoff_html_manager_post_0"><?php _e( 'Off' ) ?></label>
				
				</td>
			</tr>
			<tr valign="top">
				<th class="pppm_option_th">
				<?php _e( 'Turn on/off HTML & Protocol Manager in pages' ) ?>
				</th>
				<td class="pppm_option_td">
				<input type="radio" id="pppm_onoff_html_manager_page_1" name="pppm_onoff_html_manager_page" value="1" 
				<?php echo $pppm_checked['radio'][ 'pppm_onoff_html_manager_page' ][ 'on_check' ] ?>/> 
				<label for="pppm_onoff_html_manager_page_1"><?php _e( 'On' ) ?></label> &nbsp;&nbsp; 
				<input type="radio" id="pppm_onoff_html_manager_page_0" name="pppm_onoff_html_manager_page" value="0" 
				<?php echo $pppm_checked['radio'][ 'pppm_onoff_html_manager_page' ][ 'off_check' ] ?> />
				<label for="pppm_onoff_html_manager_page_0"><?php _e( 'Off' ) ?></label>
				
				</td>
			</tr>
			<tr valign="top">
				<th class="pppm_option_th">
				<?php _e( 'Turn on/off HTML & Protocol Manager in comments' ) ?>
				</th>
				<td class="pppm_option_td">
				<input type="radio" id="pppm_onoff_html_manager_comment_1" name="pppm_onoff_html_manager_comment" value="1" 
				<?php echo $pppm_checked['radio'][ 'pppm_onoff_html_manager_comment' ][ 'on_check' ] ?>/> 
				<label for="pppm_onoff_html_manager_comment_1"><?php _e( 'On' ) ?></label> &nbsp;&nbsp; 
				<input type="radio" id="pppm_onoff_html_manager_comment_0" name="pppm_onoff_html_manager_comment" value="0" 
				<?php echo $pppm_checked['radio'][ 'pppm_onoff_html_manager_comment' ][ 'off_check' ] ?> />
				<label for="pppm_onoff_html_manager_comment_0"><?php _e( 'Off' ) ?></label>
				
				</td>
			</tr>
			<tr valign="top">
				<th class="pppm_option_th">
				<?php _e( 'Applay HTML Manager in posts, pages and comments, which have been made from users who have got these roles.' ) ?>
				</th>
				<td class="pppm_option_td">
				<?php
				foreach ( $pppm_roles as $pppm_role_key => $pppm_role_value ) {
				
				if( get_option( 'pppm_html_role_'. $pppm_role_key ) ) {
					$pppm_role_html_check = 'checked="checked"';
				} 
				else {
					$pppm_role_html_check = '';
				}
					echo '<nobr><input type="checkbox" '.$pppm_role_html_check.' name="pppm_html_role_'.$pppm_role_key.'" id="pppm_html_role_'.$pppm_role_key.'" value="1" />
					<label for="pppm_html_role_'.$pppm_role_key.'">'.$pppm_role_value.'</label></nobr> ';
				}
				?>
				</td>
			</tr>
			<tr valign="top">
				<th class="pppm_option_th">
				<?php _e( 'HTML Manager Executing Mode' ) ?>
				</th>
				<td class="pppm_option_td">
				<input type="radio" id="pppm_html_manager_executing_0" name="pppm_html_manager_executing" value="0" 
				<?php echo $pppm_checked['radio'][ 'pppm_html_manager_executing' ][ 'off_check' ] ?>/> 
				<label for="pppm_html_manager_executing_0"><?php _e( 'Do HTML filter on saving' )?> 
				<br>&nbsp;&nbsp;&nbsp;
				<span style="color:#777777; font-style:italic">(<?php _e( 'before insert into db' ) ?>)</span></label><br />
				<input type="radio" id="pppm_html_manager_executing_1" name="pppm_html_manager_executing" value="1" 
				<?php echo $pppm_checked['radio'][ 'pppm_html_manager_executing' ][ 'on_check' ] ?> />
				<label for="pppm_html_manager_executing_1"><?php _e( 'Do HTML filter on showing' )?> 
				<br>&nbsp;&nbsp;&nbsp;
				<span style="color:#777777; font-style:italic">(<?php _e( 'after reading from database' ) ?>)</span></label>
				
				</td>
			</tr>
        </table>
		<br />
			<p class="submit" align="right">
			<input type="submit" name="Submit" value="<?php _e( 'Update Options' ) ?>" />
			&nbsp;&nbsp;&nbsp;&nbsp;
			</p>
		</form>
		</div>
		
		