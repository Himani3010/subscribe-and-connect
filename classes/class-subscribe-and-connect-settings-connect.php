<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * Subscribe & Connect Connect Settings
 *
 * All functionality pertaining to the connect settings screen.
 *
 * @package WordPress
 * @subpackage Subscribe_And_Connect
 * @category Admin
 * @author WooThemes
 * @since 1.0.0
 *
 * TABLE OF CONTENTS
 *
 * - __construct()
 * - init_sections()
 * - init_fields()
 * - get_duration_options()
 */
class Subscribe_And_Connect_Settings_Connect extends Subscribe_And_Connect_Settings_API {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct () {
	    parent::__construct(); // Required in extended classes.
	    $this->token = 'subscribe-and-connect-connect';
	    $this->name = __( 'Connect', 'subscribe-and-connect' );
	} // End __construct()

	/**
	 * init_sections function.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function init_sections () {
		$sections = array();

		$sections['networks'] = array(
					'name' 			=> __( 'Social Networks', 'subscribe-and-connect' ),
					'description'	=> __( 'Add links and icons to the social networks you\'d like to link to.', 'subscribe-and-connect' )
				);

		$sections['subscriptions'] = array(
					'name' 			=> __( 'Subscription Options', 'subscribe-and-connect' ),
					'description'	=> __( 'Setup the various ways in which your visitors can subscribe to your content.', 'subscribe-and-connect' )
				);

		$this->sections = $sections;
	} // End init_sections()

	/**
	 * init_fields function.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function init_fields () {
		global $pagenow;

	    $fields = array();

	    $fields['rss'] = array(
								'name' 			=> __( 'RSS', 'subscribe-and-connect' ),
								'description' 	=> __( 'Display an RSS icon along with your social network links.', 'subscribe-and-connect' ),
								'type' 			=> 'checkbox',
								'default' 		=> true,
								'section' 		=> 'networks',
								'required' 		=> 0
								);

    	$fields['networks'] = array(
								'name' 			=> __( 'Social Networks', 'subscribe-and-connect' ),
								'description' 	=> __( 'The social networks to be linked to in the "Connect" portion of the output. Drag and drop to reorder.', 'subscribe-and-connect' ),
								'type' 			=> 'network',
								'default' 		=> 'facebook',
								'section' 		=> 'networks',
								'required' 		=> 0
								);

    	$fields['networks_order'] = array(
								'name' 			=> '',
								'description' 	=> '',
								'type' 			=> 'hidden',
								'default' 		=> '',
								'section' 		=> 'networks',
								'required' 		=> 0
								);

    	// Subscriptions
    	$newsletter_services = array(
    							'none' 				=> __( 'None', 'subscribe-and-connect' ),
    							'aweber' 			=> __( 'Aweber', 'subscribe-and-connect' ),
    							'campaign_monitor' 	=> __( 'Campaign Monitor', 'subscribe-and-connect' ),
    							'feedburner' 		=> __( 'Feedburner', 'subscribe-and-connect' ),
    							'mad_mimi' 			=> __( 'Mad Mimi', 'subscribe-and-connect' ),
    							'mailchimp' 		=> __( 'Mailchimp', 'subscribe-and-connect' )
    							);

    	$fields['newsletter_service'] = array(
								'name' 			=> __( 'Newsletter Service', 'subscribe-and-connect' ),
								'description' 	=> __( 'Select the newsletter service you are using', 'subscribe-and-connect' ),
								'type' 			=> 'select',
								'default' 		=> 'none',
								'options' 		=> $newsletter_services,
								'section' 		=> 'subscriptions'
								);

    	$fields['newsletter_service_id'] = array(
								'name' 			=> __( 'Feedburner Feed ID', 'subscribe-and-connect' ),
								'description' 	=> sprintf( __( 'Enter the your Feedburner Feed ID %s(?)%s.', 'subscribe-and-connect' ), '<a href="' . esc_url( 'http://support.google.com/feedburner/bin/answer.py?hl=en&answer=78982' ) . '" target="_blank">', '</a>' ),
								'type' 			=> 'text',
								'default' 		=> '' ,
								'section' 		=> 'subscriptions'
								);

		$fields['newsletter_service_form_action'] = array(
								'name' 			=> __( 'Newsletter Service Form Action', 'subscribe-and-connect' ),
								'description' 	=> __( 'Enter the the form action if required.', 'subscribe-and-connect' ),
								'type' 			=> 'text',
								'default' 		=> '' ,
								'section' 		=> 'subscriptions'
								);

		$fields['newsletter_mail_chimp_list_subscription_url'] = array(
								'name' 			=> __( 'MailChimp List Subscription URL', 'subscribe-and-connect' ),
								'description' 	=> sprintf( __( 'If you have a MailChimp account you can enter the %sMailChimp List Subscribe URL%s to allow your users to subscribe to a MailChimp List.', 'subscribe-and-connect' ), '<a href="' . esc_url( 'http://woochimp.heroku.com/' ) . '" target="_blank">', '</a>' ),
								'type' 			=> 'text',
								'default' 		=> '' ,
								'section' 		=> 'subscriptions'
								);

		$fields['newsletter_mad_mimi_subscription_url'] = array(
								'name' 			=> __( 'Mad Mimi Webform URL', 'subscribe-and-connect' ),
								'description' 	=> __( 'Your Mad Mini Webform URL, eg. https://madmimi.com/signups/subscribe/84680', 'subscribe-and-connect' ),
								'type' 			=> 'text',
								'default' 		=> '' ,
								'section' 		=> 'subscriptions'
								);

		$fields['newsletter_aweber_list_id'] = array(
								'name' 			=> __( 'Aweber List Name', 'subscribe-and-connect' ),
								'description' 	=> __( 'The name of the list to subscribe users to.', 'subscribe-and-connect' ),
								'type' 			=> 'text',
								'default' 		=> '' ,
								'section' 		=> 'subscriptions'
								);

		$this->fields = $fields;
	} // End init_fields()
} // End Class
?>