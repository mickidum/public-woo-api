<?php

/**
 * The settings of the plugin.
 *
 * @link       http://devinvinson.com
 * @since      1.0.0
 *
 * @package    public_woo_api_Plugin
 * @subpackage public_woo_api_Plugin/admin
 */

/**
 * Class WordPress_Plugin_Template_Settings
 *
 */
class Public_Woo_Api_Settings {

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
	 * This function introduces the theme options into the 'Appearance' menu and into a top-level
	 * 'WPPB Demo' menu.
	 */
	public function setup_plugin_options_menu() {

		//Add the menu to the Plugins set of menu items
		add_menu_page(
			'Public Woo Api Settings', 					// The title to be displayed in the browser window for this page.
			'Public Woo',					// The text to be displayed for this menu item
			'manage_options',					// Which type of users can see this menu item
			'public_woo_api_options',			// The unique ID - that is, the slug - for this menu item
			array( $this, 'render_settings_page_content')				// The name of the function to call when rendering this menu's page
		);

	}


	/**
	 * Provide default values for the Options.
	 *
	 * @return array
	 */
	public function default_main_options() {

		$defaults = array(
			'consumer_key' =>	'',
			'consumer_secret'	=> '',
			'endpoint' => 'public-woo/v1'
		);

		return  $defaults;

	}

	/**
	 * Renders a page to display for the theme menu defined above.
	 */
	public function render_settings_page_content() {
		?>
		<!-- Create a header in the default WordPress 'wrap' container -->
		<div class="wrap">

			<h2><?php _e( 'Public Woo Api Options', 'public-woo-api' ); ?></h2>
			<?php settings_errors(); ?>

			<form class="public-woo-api" method="post" action="options.php">
				<?php
					settings_fields( 'public_woo_api_main_options' );

					do_settings_sections( 'public_woo_api_main_options' );

					submit_button();
				?>
			</form>
		<p>
			<strong style="color:coral;">Tip: always use keys with Read Only permissions</strong>
		</p>
		</div>
	<?php
	}

	public function main_options_callback() {
		$options = get_option('public_woo_api_main_options');

		$link_to_generate_keys = get_admin_url(null, 'admin.php?page=wc-settings&tab=advanced&section=keys', null);

		echo '<p>' . __( 'Insert here Consumer key and Consumer secret generated from ', 'public-woo-api' ). '<a href="'. $link_to_generate_keys .'">WC REST API</a></p><br />';
	} 

	public function initialize_main_options() {
		if( false == get_option( 'public_woo_api_main_options' ) ) {
			$default_array = $this->default_main_options();
			update_option( 'public_woo_api_main_options', $default_array );
		}

		add_settings_section(
			'public_woo_api_main_settings_section',			// ID used to identify this section and with which to register options
			__( 'Credentials From Woocommerce Rest Api', 'public-woo-api' ),		// Title to be displayed on the administration page
			array( $this, 'main_options_callback'),	// Callback used to render the description of the section
			'public_woo_api_main_options'		// Page on which to add this section of options
		);

		add_settings_field(
			'endpoint',
			'Rest Api Endpoint',
			array( $this, 'endpoint_callback'),
			'public_woo_api_main_options',
			'public_woo_api_main_settings_section'
		);

		add_settings_field(
			'consumer_key',
			'Consumer key',
			array( $this, 'consumer_key_callback'),
			'public_woo_api_main_options',
			'public_woo_api_main_settings_section'
		);

		add_settings_field(
			'consumer_secret',
			'Consumer secret',
			array( $this, 'consumer_secret_callback'),
			'public_woo_api_main_options',
			'public_woo_api_main_settings_section'
		);

		register_setting(
			'public_woo_api_main_options',
			'public_woo_api_main_options'
		);

	}

	public function endpoint_callback() {

		$options = get_option( 'public_woo_api_main_options' );

		$endpoint = 'public-woo/v1';
		if( !empty( $options['endpoint'] ) ) {
			$endpoint = $options['endpoint'];
		}

		echo '<div class="woo-endpoint"><strong id="endpoint-for-select">'.get_site_url().'/wp-json/'.$endpoint.'</strong></div><input type="text" id="endpoint" name="public_woo_api_main_options[endpoint]" value="' . esc_attr($endpoint) . '" placeholder="Your Endpoint" /><br />';
	}

	public function consumer_key_callback() {

		$options = get_option( 'public_woo_api_main_options' );

		$consumer_key = '';
		if( !empty( $options['consumer_key'] ) ) {
			$consumer_key = $options['consumer_key'];
		}

		echo '<input type="text" id="consumer_key" name="public_woo_api_main_options[consumer_key]" value="' . esc_attr($consumer_key) . '" placeholder="ck_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" />';
	}

	public function consumer_secret_callback() {

		$options = get_option( 'public_woo_api_main_options' );

		$consumer_secret = '';
		if( !empty( $options['consumer_secret'] ) ) {
			$consumer_secret = $options['consumer_secret'];
		}

		echo '<input type="text" id="consumer_secret" name="public_woo_api_main_options[consumer_secret]" value="' . esc_attr($consumer_secret) . '" placeholder="cs_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" />';
	}
}