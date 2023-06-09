<?php
/**
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @version    2.5.2 for parent theme wpa_installer for publication on WordPress.org
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'wpa_register_recommended_plugins', 10 );

function wpa_register_recommended_plugins() {

    $plugins = array(
        array(
            'name'      => 'Contact Form 7',
            'slug'      => 'contact-form-7',
            'required'  => false,
        ),
        array(
            'name'      => 'Advanced Editor Tools (previously TinyMCE Advanced)',
            'slug'      => 'tinymce-advanced',
            'required'  => false,
        ),
	    array(
            'name'      => 'AJAX Thumbnail Rebuild',
            'slug'      => 'ajax-thumbnail-rebuild',
            'required'  => false,
        ),
        array(
            'name'      => 'Yoast SEO',
            'slug'      => 'wordpress-seo',
            'required'  => false,
            'is_callable' => 'wpseo_init',
        ),
        array(
            'name'               => 'Advanced Custom Fields: PRO',
            'slug'               => 'advanced-custom-fields-pro',
            'source'             => get_stylesheet_directory() . '/inc/plugins/advanced-custom-fields-pro.zip',
            'required'           => true,
            'version'            => '',
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => 'http://www.advancedcustomfields.com/pro/', // If set, overrides default API URL and points to an external URL.
        )
    );
    $config = array(
        'id'           => 'wpa_inst',              // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'wpa-install-plugins',   // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true,                    // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
    );
    tgmpa( $plugins, $config );
}