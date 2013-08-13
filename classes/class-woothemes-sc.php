<?php
class Woothemes_SC {
	/**
	 * Property to contain the version number.
	 * @access  public
	 * @since   1.0.0
	 * @var     object
	 */
	public $version;

	/**
	 * Property to contain the Woothemes_SC_Admin or Woothemes_SC_Frontend object.
	 * @access  public
	 * @since   1.0.0
	 * @var     object
	 */
	public $context;

	/**
	 * Property to contain the various settings objects.
	 * @access  public
	 * @since   1.0.0
	 * @var     array
	 */
	public $settings_objs;

	/**
	 * Property to contain all settings, distributed by object.
	 * @access  private
	 * @since   1.0.0
	 * @var     array
	 */
	private $_settings;

	/**
	 * Constructor.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct ( $file ) {
		// Setup the settings objects.
		add_action( 'admin_init', array( $this, 'setup_settings' ) );

		// Maybe override the WooThemes settings.
		add_filter( 'option_woo_template', array( $this, 'maybe_override_woo_options' ) );
		add_action( 'widgets_init', array( $this, 'maybe_unregister_widget' ) );

		// Load in the utility functions.
		require_once( 'class-woothemes-sc-utils.php' );
		if ( is_admin() ) {
			// Load in the admin functionality.
			require_once( 'class-woothemes-sc-admin.php' );
			$this->context = new Woothemes_SC_Admin( $file );
		} else {
			// Load in the frontend functionality.
			require_once( 'class-woothemes-sc-frontend.php' );
			$this->context = new Woothemes_SC_Frontend( $file );
		}
	} // End __construct()

	/**
	 * Setup a settings object for our current tab, if applicable.
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function setup_settings () {
		require_once( 'class-woothemes-sc-settings-api.php' );

		// Load in the different settings sections.
		require_once( 'class-woothemes-sc-settings-subscribe.php' );
		require_once( 'class-woothemes-sc-settings-connect.php' );
		require_once( 'class-woothemes-sc-settings-integration.php' );

		$this->settings_objs = array();

		// Setup "Subscribe" settings.
		$this->settings_objs['subscribe'] = new Woothemes_SC_Settings_Subscribe();
		$this->settings_objs['subscribe']->setup_settings();

		// Setup "Connect" settings.
		$this->settings_objs['connect'] = new Woothemes_SC_Settings_Connect();
		$this->settings_objs['connect']->setup_settings();

		// Setup "Integration" settings.
		$this->settings_objs['integration'] = new Woothemes_SC_Settings_Integration();
		$this->settings_objs['integration']->setup_settings();

		$this->settings_objs = (array)apply_filters( 'woothemes_sc_setup_settings', $this->settings_objs );
	} // End setup_settings()

	/**
	 * Retrieve the settings from each section, separated by object.
	 * @access  public
	 * @since   1.0.0
	 * @return  array Settings.
	 */
	public function get_settings () {
		if ( is_array( $this->_settings ) && 0 < count( $this->_settings ) ) return $this->_settings;

		$this->_settings = array();
		if ( 0 < count( $this->settings_objs ) ) {
			foreach ( $this->settings_objs as $k => $v ) {
				$this->_settings[$k] = $v->get_settings();
			}
		}

		return $this->_settings;
	} // End get_settings()

	/**
	 * Attempt to remove the Subscribe & Connect theme options.
	 * @access  public
	 * @since   1.0.0
	 * @param   array $options Array of options.
	 * @return  array          Modified array of options.
	 */
	public function maybe_override_woo_options ( $options ) {
		$settings = $this->get_settings();

		if ( isset( $settings['integration']['disable_theme_sc'] ) && true == $settings['integration']['disable_theme_sc'] ) {
			$detected_sc = false;
			foreach ( $options as $k => $v ) {
				// Remove the section heading. This will kick start the removal of fields.
				if ( 'heading' == $v['type'] && 'connect' == $v['icon'] ) {
					$detected_sc = true;
					unset( $options[$k] );
					continue; // Move to the next itteration.
				}
				if ( true == $detected_sc ) {
					if ( 'heading' == $v['type'] ) $detected_sc = false; // If we're at the next section heading, stop removing fields.
					if ( true == $detected_sc ) unset( $options[$k] ); // Remove the field, if we're still set to remove fields.
				}

				// Remove the "Enable Subscribe & Connect" option from the theme options.
				if ( 'woo_contact_subscribe_and_connect' == $v['id'] ) unset( $options[$k] );
			}
		}

		return $options;
	} // End maybe_override_woo_options()

	/**
	 * Attempt to unregiter the Subscribe & Connect widget.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function maybe_unregister_widget () {
		$settings = $this->get_settings();

		if ( isset( $settings['integration']['disable_theme_sc'] ) && true == $settings['integration']['disable_theme_sc'] ) {
			unregister_widget( 'Woo_Subscribe' );
		}
	} // End maybe_unregister_widget()
} // End Class
?>