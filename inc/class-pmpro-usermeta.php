<?php

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

new UserMeta_Stuff();

class UserMeta_Stuff {

	public function __construct() {
		add_action( 'customize_register', array( $this, 'site_customizer_manager' ) );
		add_filter( 'the_content', array( $this, 'something_before_content' ) );
		add_action( 'admin_menu', array( $this, 'meta_dash_menu' ) );
		add_shortcode( 'some-usermeta-form', array( $this, 'usermeta_form_function' ) );

		add_action( 'wphead', array( $this, 'show_plugin_active' ) );
	}


	/**
	 * [site_customizer_manager description]
	 *
	 * @param  [type] $customizer_additions [description]
	 * @return [type]             [description]
	 */
	public function meta_dash_menu() {
		add_dashboard_page( 'Meta Dashboard', 'Meta Dashboard', 'manage_options', 'meta-dashboard',  array( $this, 'meta_dash_page' ) );
	}

	/**
	 * [site_customizer_manager description]
	 *
	 * @param  [type] $customizer_additions [description]
	 * @return [type]             [description]
	 */
	public function meta_dash_page() {
		echo '<div class="wrap">';
		echo '<h3>' . __FILE__ . '</h3>';

		$current_user = get_current_user_id();
		// $current_users_meta = get_user_meta( 3 );
		$current_users_meta = get_user_meta( $current_user );
		echo '<pre>';
		print_r( $current_users_meta );
		echo '</pre>';

		echo '</div>';
	}

	public function usermeta_form_function() {
		global $current_user;

		$user_chapter = get_user_meta( $current_user->ID, '_user_chapter', true );
		?>
		<style type="text/css">
			fieldset {
				padding:1rem;
			}
		</style>
		<div style="padding: 2rem;width:77%;margin: 2rem auto; border: 1px solid salmon;">
			<form name="setPrices" action="" method="POST">

				<fieldset>
					<label for="chapter">User Chapter:</label>
					<input type="text" id="chapter" name="chapter" placeholder="Chapter" value="<?php echo $user_chapter; ?>" />
				</fieldset>

				<button type="submit">Save</button>
			</form>
		</div>
		<?php
		$user_chapter = $_POST['chapter'];

		update_user_meta( $current_user->ID, '_user_chapter', $user_chapter );
	}

	/**
	 * [site_customizer_manager description]
	 *
	 * @param  [type] $customizer_additions [description]
	 * @return [type]             [description]
	 */
	public function something_before_content( $content ) {
		if ( true === get_theme_mod('usermeta_checkbox') ) {
			$thumbnail = '<img src="http://via.placeholder.com/600x150" />';
			$something = $thumbnail . $content;
		} else {
			$something = $content;
		}

		return $something;
	}

	/**
	 * [site_customizer_manager description]
	 *
	 * @param  [type] $customizer_additions [description]
	 * @return [type]             [description]
	 */
	public function site_customizer_manager( $customizer_additions ) {
		$this->panel_creation( $customizer_additions );
	}

	/**
	 * A section to show how you use the default customizer controls in WordPress
	 *
	 * @param Obj $customizer_additions - WP Manager
	 *
	 * @return Void
	 */
	private function panel_creation( $customizer_additions ) {
		// $customizer_additions->add_panel(
		// 'usermeta_panel', array(
		// 'title'       => 'Site Panel',
		// 'label'       => 'Site Panel',
		// 'description' => 'This is a description of this usermeta panel',
		// 'priority'    => 10,
		// )
		// );
		// Checkbox control
		$customizer_additions->add_section( 'usermeta_section', array(
			'title'          => 'UserMeta Controls',
			'priority'       => 35,
		) );

		$customizer_additions->add_setting( 'usermeta_checkbox', array(
			'default'        => true,
			'transport'      => 'refresh',
		) );

		$customizer_additions->add_control( 'usermeta_checkbox', array(
			'label'   => 'Show Usermeta info',
			// 'section' => 'title_tagline',
			'section' => 'usermeta_section',
			'type'    => 'checkbox',
			'priority' => 72,
		) );

		$customizer_additions->add_setting( 'textbox_setting', array(
			'default'        => 'Default Value',
		) );

		$customizer_additions->add_control( 'textbox_setting', array(
			'label'   => 'Text Setting',
			'section' => 'usermeta_section',
			'type'    => 'text',
			'priority' => 1,
		) );

	}
	/**
	 *
	 * @param  [type] [description]
	 * @return [type]             [description]
	 */
	public function show_plugin_active() {
		?>
		<style type="text/css">
			body {
				background-color: aliceblue;
			}
		</style>
		<?php
	}

}
