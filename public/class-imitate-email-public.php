<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://imitate.email
 * @since      1.0.0
 *
 * @package    Imitate_Email
 * @subpackage Imitate_Email/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Imitate_Email
 * @subpackage Imitate_Email/public
 * @author     Mark Jerzykowski <mark@imitate.email>
 */
class Imitate_Email_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, 'https://imitate.email/imitate-widget.min.js', array(), $this->version, true );

	}

	public function mailer_init($phpmailer)	{
		$username = get_option('imitate_email_username');
		$password = get_option('imitate_email_password');
		if($username && $password) {
			$phpmailer->isSMTP();
			$phpmailer->Host       = 'smtp.imitate.email';
			$phpmailer->Port       = '587';
			$phpmailer->SMTPSecure = 'tls';
			$phpmailer->SMTPAuth   = true;
			$phpmailer->Username = $username;
			$phpmailer->Password = $password;
		}
	}

	public function wp_mail_from($fromAddress) {
		if (!$fromAddress || str_ends_with($fromAddress, 'localhost')) {		
			/* work round issue with wordpress@localhost blowing up */	
			return "test@imitate.email";
		}
	}

	public function wp_mail_failed($wp_error) {
		echo sprintf('<div class="notice notice-error"><p>%s</p></div>',
			esc_html(__( 'Email Delivery Failure:').$wp_error->get_error_message())
		);
	}

}
