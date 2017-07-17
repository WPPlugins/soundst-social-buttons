<?php
/*
Plugin Name: Soundst Social Buttons
Plugin URI: http://www.soundst.com/
Description: This plugin will add a social networks share buttons after the body content on pages and posts
Author: Sound Strategies
Version: 0.0.4
*/

class Add_social_buttons {

	public function __construct() {
		add_action('admin_menu', array( $this, 'fb_create_menu' ), 1);
		add_filter('the_content',  array( $this, 'add_post_content' ));
		
	}
	
	public function add_post_content($content) {
		if(is_page() || is_single()) {
			$fb_theme_options = get_option('fb_theme_options');
			$fb_button_page = $fb_theme_options['fb_button_page'];
			$fb_button_post = $fb_theme_options['fb_button_post'];
			
			$tw_button_page = $fb_theme_options['tw_button_page'];
			$tw_button_post = $fb_theme_options['tw_button_post'];
			
			
			
			if (/*getimagesize($fb_button_page) === false  ||*/ ($fb_button_page === '')) {
				$fb_button_page = plugins_url() . '/' . basename(__DIR__)  . '/ss_fb_share.png';
			}
			if (/*getimagesize($fb_button_post) === false ||*/ ($fb_button_post === '')) {
				$fb_button_post = plugins_url() . '/' . basename(__DIR__)  . '/ss_fb_share.png';
			}
			
			
			if (/*getimagesize($tw_button_page) === false  ||*/ ($tw_button_page === '')) {
				$tw_button_page = plugins_url() . '/' . basename(__DIR__)  . '/ss_tw_share.png';
			}
			if (/*getimagesize($tw_button_post) === false ||*/ ($tw_button_post === '')) {
				$tw_button_post = plugins_url() . '/' . basename(__DIR__)  . '/ss_tw_share.png';
			}
			
			
			$fb_page_box = $fb_theme_options['fb_page_box'];
			$fb_post_box = $fb_theme_options['fb_post_box'];
			
			$tw_page_box = $fb_theme_options['tw_page_box'];
			$tw_post_box = $fb_theme_options['tw_post_box'];
			
			
			
			$Path = urlencode('http://' . $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI']);
			
			
			
			
			$fb_URI='https://www.facebook.com/sharer/sharer.php?u='.$Path . '&t='. get_the_title();
			
			$tw_URI='https://www.twitter.com/share?url='.$Path . '&text='. get_the_title();
			
			
			
			
			if (is_page()) {
				if ($fb_page_box || $tw_page_box) {  $content .= '<div class="social-b" style="display: inline-block; width: 100%;">'; }
					if ($fb_page_box) {
						$content .= '<p class="facebook_button alignleft"><a target="_blank" href="' . $fb_URI . '"><img style="border: none; background: none; margin-right: 10px;" src=" ' . $fb_button_page . '" /></a></p>';
					}
					if ($tw_page_box) {
						$content .= '<p class="twitter_button alignleft"><a target="_blank" href="' . $tw_URI . '"><img style="border: none; background: none;" src=" ' . $tw_button_page . '" /></a></p>';
					}
				if ($fb_page_box || $tw_page_box) { $content .= '</div>'; }
			}

			if (is_single()) {
				if ($fb_page_box || $tw_page_box) {  $content .= '<div class="social-b" style="display: inline-block; width: 100%;">'; }
					if ($fb_post_box) {
						$content .= '<p class="facebook_button alignleft"><a target="_blank" href="' . $fb_URI . '"><img style="border: none; background: none; margin-right: 10px;" src=" ' . $fb_button_post . '" /></a></p>';
					}
					if ($tw_post_box) {
						$content .= '<p class="twitter_button alignleft"><a target="_blank" href="' . $tw_URI . '"><img style="border: none; background: none;" src=" ' . $tw_button_post . '" /></a></p>';
					}
				if ($fb_page_box || $tw_page_box) { $content .= '</div>'; }
			}
		}
		return $content;
	}
	
	
	/**** Add theme options ***/
	
	
	public function fb_create_menu() {
		add_submenu_page('options-general.php', 'Soundst Social Buttons', 'Soundst Social Buttons', 'edit_themes', 'theme_options',  array($this, 'theme_options_admin'));
	}
	
	
	function theme_options_admin () {
		if (!current_user_can('edit_themes')) {
			wp_die('No privileges to edit this page!');
		}
		$fb_theme_options = get_option('fb_theme_options');
	
		if (empty($fb_theme_options)) {
			$fb_theme_options_defaults = array(
					'fb_button_page' => 'fb_button_page',
					'fb_button_post'  => 'fb_button_post',
					'fb_page_box' => 'fb_page_box',
					'fb_post_box' => 'fb_post_box',
					
					'tw_button_page' => 'tw_button_page',
					'tw_button_post'  => 'tw_button_post',
					'tw_page_box' => 'tw_page_box',
					'tw_post_box' => 'tw_post_box',
			);
			add_option('fb_theme_options', $fb_theme_options_defaults);
	
			$fb_theme_options = $fb_theme_options_defaults;
		}
	
		if (isset($_POST['options_submit']) && $_POST['options_submit'] == 'yes') {
	
			$fb_button_page = $_POST['fb_button_page'];
			$fb_button_post = $_POST['fb_button_post'];
			$fb_page_box = $_POST['fb_page_box'];
			$fb_post_box = $_POST['fb_post_box'];
			
			
			$tw_button_page = $_POST['tw_button_page'];
			$tw_button_post = $_POST['tw_button_post'];
			$tw_page_box = $_POST['tw_page_box'];
			$tw_post_box = $_POST['tw_post_box'];
	
			$fb_theme_options = array (
					'fb_button_page' => $fb_button_page,
					'fb_button_post' => $fb_button_post,
					'fb_page_box' => $fb_page_box,
					'fb_post_box' => $fb_post_box,
					
					'tw_button_page' => $tw_button_page,
					'tw_button_post' => $tw_button_post,
					'tw_page_box' => $tw_page_box,
					'tw_post_box' => $tw_post_box,
			);
			update_option ('fb_theme_options', $fb_theme_options);
		}
		?>
		
		<?php 
			$fb_button_page_ = $fb_theme_options['fb_button_page'];
			$fb_button_post_ = $fb_theme_options['fb_button_post'];
			if ($fb_button_page_ === '') {$fb_button_page_ =  plugins_url() . '/' . basename(__DIR__)  . '/ss_fb_share.png';}
			if ($fb_button_post_ === '') {$fb_button_post_ =  plugins_url() . '/' . basename(__DIR__)  . '/ss_fb_share.png';}
			
			$tw_button_page_ = $fb_theme_options['tw_button_page'];
			$tw_button_post_ = $fb_theme_options['tw_button_post'];
			if ($tw_button_page_ === '') {
				$tw_button_page_ =  plugins_url() . '/' . basename(__DIR__)  . '/ss_tw_share.png';
			}
			if ($tw_button_post_ === '') {
				$tw_button_post_ =  plugins_url() . '/' . basename(__DIR__)  . '/ss_tw_share.png';
			}
		?>
		<div class="wrap">
			<h2>Facebook Share Button</h2>
				<form method="post">
					<input type="hidden" name="options_submit" value="yes" />
						<table>
						<tr>
							<td><label for="fb_button_page"><span>Facebook Button for Pages</span></label></td>
							<td><input style="width: 450px;" id="fb_button_page" type="text" size="20" name="fb_button_page" value="<?php  echo $fb_button_page_; ?>" /></td>
						</tr>
						 
						<tr>
							<td><label for="fb_button_post"><span>Facebook Button for Posts</span></label></td>
							<td><input style="width: 450px;" id="fb_button_post" type="text" size="20" name="fb_button_post" value="<?php  echo $fb_button_post_ ?>" /></td>
						</tr>
						
						<tr>
							<td><label for="fb_page_box"><span>Display on pages?</span></label></td>
							<td><input type="checkbox" name="fb_page_box" id="fb_page_box" value="true" <?php echo ( 'true' == $fb_theme_options['fb_page_box'] ) ? 'checked="checked"' : ''; ?> /></td>
						</tr>

						<tr>
							<td><label for="fb_post_box"><span>Display on posts?</span></label></td>
							<td><input type="checkbox" name="fb_post_box" id="fb_post_box" value="true" <?php echo ( 'true' == $fb_theme_options['fb_post_box'] ) ? 'checked="checked"' : ''; ?> /></td>
						</tr>
						
						<tr>
						<hr>
						</tr>
						
						<tr>
							<td><label for="tw_button_page"><span>Twitter Button for Pages</span></label></td>
							<td><input style="width: 450px;" id="tw_button_page" type="text" size="20" name="tw_button_page" value="<?php  echo $tw_button_page_; ?>" /></td>
						</tr>
						 
						<tr>
							<td><label for="tw_button_post"><span>Twitter Button for Posts</span></label></td>
							<td><input style="width: 450px;" id="tw_button_post" type="text" size="20" name="tw_button_post" value="<?php  echo $tw_button_post_; ?>" /></td>
						</tr>
						
						<tr>
							<td><label for="tw_page_box"><span>Display on pages?</span></label></td>
							<td><input type="checkbox" name="tw_page_box" id="tw_page_box" value="true" <?php echo ( 'true' == $fb_theme_options['tw_page_box'] ) ? 'checked="checked"' : ''; ?> /></td>
						</tr>

						<tr>
							<td><label for="tw_post_box"><span>Display on posts?</span></label></td>
							<td><input type="checkbox" name="tw_post_box" id="tw_post_box" value="true" <?php echo ( 'true' == $fb_theme_options['tw_post_box'] ) ? 'checked="checked"' : ''; ?> /></td>
						</tr>
						
						
						<tr> 
							<td></td>
							<td><input type="submit" class="button-primary" value="Update Settings" /></td>
						</tr>
				</table>
				</form>	
				
				
			</div>
		<?php
		
	}
	
}
new Add_social_buttons();

