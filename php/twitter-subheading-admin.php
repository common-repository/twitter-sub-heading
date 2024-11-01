<?php
/*
 * Plugin Name:	Twitter Sub-Heading
 * Plugin URI:	http://invariabletruth.com
 * Version:		0.01
 * Author:		Stewart Malik
 * Author URI:	http://invariabletruth.com
 * Description:	This changes the sub-heading of your blog to your latest tweet.
 * 
 * Copyright 2009 Stewart Malik <mali0037@gmail.com>
 *     
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *     
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
*/

if($_POST['twitter_subheading_hidden'] == 'data_sent') {
	
	$twitterSubheading_username = $_POST['twitter_subheading_username'];
	update_option('twitterSubheading_username', $twitterSubheading_username);
	
	$twitterSubheading_interval = $_POST['twitter_subheading_interval'];
	update_option('twitterSubheading_interval', $twitterSubheading_interval);

	echo "<div class=\"updated\"><p><strong>Options Saved.</strong></p></div>";
	
}

else {
	
	$twitterSubheading_username = get_option('twitterSubheading_username');
	$twitterSubheading_interval = get_option('twitterSubheading_interval');
	
}

?>

<div class='wrap'>
<div id="icon-options-general" class="icon32"></div>
<h2>Twitter Sub-Heading Administration Options</h2>
</div>      
<form name="twitter_subheading_form" method="POST" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
<input type="hidden" name="twitter_subheading_hidden" value="data_sent">  
<br><br>
<table>
	<tr>
		<td><p> <?php _e("Twitter Username: "); ?></td>
		<td><input type="text" name="twitter_subheading_username" value="<?php echo $twitterSubheading_username; ?>"></td>
		<td><?php _e("<i>Example: Alias14</i>" ); ?> </p></td>
	</tr>
	<tr>
		<td><p><?php _e("Interval for Twitter Query: "); ?></td>
		<td><input type="text" name="twitter_subheading_interval" value="<?php echo $twitterSubheading_interval; ?>"></td>
		<td><?php _e("<i>Example: 5  (Default recommended)</i>" ); ?></p></td>
	</tr>	
</table>
<br><br>
<p class="submit">
<input class = 'button-primary' type = 'submit' name = 'Save' value = '<?php _e('Save Options'); ?>' id = 'submitbutton' />
</p>
</form>
</div>
