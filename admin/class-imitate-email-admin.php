<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://imitate.email
 * @since      1.0.0
 *
 * @package    Imitate_Email
 * @subpackage Imitate_Email/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Imitate_Email
 * @subpackage Imitate_Email/admin
 * @author     Mark Jerzykowski <mark@imitate.email>
 */
class Imitate_Email_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		 wp_enqueue_script( $this->plugin_name, 'https://imitate.email/imitate-widget.min.js', array(), $this->version, true );

	}

	public function menu_setup() {
		add_options_page('Imitate Email', 'Imitate Email', 'manage_options', 'imitate-email', array( $this, 'options_page_html' ));
	}

	function options_page_html() {
		// check user capabilities
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="wrap">
			<h1 style="display: flex; flex-direction: row; align-items: center;">
				<img style="height: 32px; margin-right: 10px;" src="https://imitate.email/images/logo-icon-dark-bg-rounded.png" alt="Imitate Email Logo" />
				<span><?php echo esc_html( get_admin_page_title() ); ?></span>
			</h1>
			<?php if (get_option('imitate_email_username')) { ?>
			
			<?php } else { ?>
			<h2>Welcome to the Imitate Email for WordPress plugin settings</h2>
			<p>It's easy to get started:</p>
			<ol style="margin-bottom:40px">
				<li>Sign up at <a href="https://imitate.email" target="_blank">https://imitate.email</a> - only an email required</li>
				<li>Copy and paste your username/password from "Settings -> My Mailbox" here</li>
				<li>Open the chameleon (bottom right) and log in. <br/>
					<span style="font-size: 0.8rem">(You may have to wait for your password reset email to be sent to you by email)</span>
				<li>When an email is sent, the chameleon will light up to let you know</li>
			</ol>
			<?php } ?>
			<form action="options.php" method="post">
				<?php 
				settings_fields( 'imitate-email' );
				
				// output setting sections and their fields
				// (sections are registered for "wporg", each field is registered to a specific section)
				do_settings_sections( 'imitate-email' );
				// output save settings button
				submit_button( __( 'Save Settings', 'textdomain' ) );
				?>
			</form>
		</div>
		<?php
	}

	function username_callback(){
		echo '<input type="text" name="imitate_email_username" class="regular-text" value="'. esc_attr(get_option('imitate_email_username')) .'" />';
	}

	function password_callback(){
		echo '<input type="text" name="imitate_email_password" class="regular-text" value="'. esc_attr(get_option('imitate_email_password')) .'" />';
	}

	function section_callback() {
		if (get_option('imitate_email_username')) {
			echo 'You will find these when you log in to Imitate Email, under "Settings -> My Mailbox"';
		}
	}

	public function init_settings() {
		register_setting( 'imitate-email', 'imitate_email_username' );
		register_setting( 'imitate-email', 'imitate_email_password' );
		
		add_settings_section(
			'imitateemail_section_smtp',
			__( 'SMTP Credentials', 'imitate-email' ), 
			array( $this, 'section_callback' ),
			'imitate-email'
		);

		add_settings_field(
			'imitateemail_field_username', // As of WP 4.6 this value is used only internally.
									// Use $args' label_for to populate the id inside the callback.
				__( 'Username', 'imitate-email' ),
			array( $this, 'username_callback'),
			'imitate-email',
			'imitateemail_section_smtp'
		);

		add_settings_field(
			'imitate_email_password', // As of WP 4.6 this value is used only internally.
									// Use $args' label_for to populate the id inside the callback.
				__( 'Password', 'imitate-email' ),
			array( $this, 'password_callback'),
			'imitate-email',
			'imitateemail_section_smtp'
		);
	}

}
