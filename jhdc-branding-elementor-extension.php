<?php

/**
 * JHDC Branding Elementor Extension
 *
 * @package           JHDC
 * @author            Jimmy Howe
 * @copyright         2019 JimmyHowe.com
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       JHDC Branding Elementor Extension
 * Plugin URI:        https://jimmyhowe.com/products/plugins/jhdc-branding-elementor-extension
 * Description:       Smashes your site up with JHDC shizzle!
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Jimmy Howe
 * Author URI:        https://jimmyhowe.com
 * Text Domain:       jhdc-branding-elementor-extension
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

use Elementor\Plugin;

if ( ! defined('ABSPATH') )
{
	exit; // Exit if accessed directly.
}

/**
 * Main JHDC Elementor Brand Extension Class
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class JHDC_Branding_Elementor_Extension
{
	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Instance
	 *
	 * @since  1.0.0
	 * @access private
	 * @static
	 * @var JHDC__Branding_Elementor_Extension The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Constructor
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function __construct()
	{
		add_action('init', [ $this, 'i18n' ]);
		add_action('plugins_loaded', [ $this, 'init' ]);
	}

	/**
	 * Instance
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @return JHDC__Branding_Elementor_Extension An instance of the class.
	 * @since  1.0.0
	 * @access public
	 * @static
	 */
	public static function instance()
	{
		if ( is_null(self::$_instance) )
		{
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Load Textdomain
	 * Load plugin localization files.
	 * Fired by `init` action hook.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function i18n()
	{
		load_plugin_textdomain('jhdc-branding-elementor-extension');
	}

	/**
	 * Initialize the plugin
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function init()
	{
		// Check if Elementor installed and activated
		if ( ! did_action('elementor/loaded') )
		{
			add_action('admin_notices', [ $this, 'admin_notice_missing_main_plugin' ]);

			return;
		}

		// Check for required Elementor version
		if ( ! version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=') )
		{
			add_action('admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ]);

			return;
		}

		// Check for required PHP version
		if ( version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<') )
		{
			add_action('admin_notices', [ $this, 'admin_notice_minimum_php_version' ]);

			return;
		}

		// Register widgets
		add_action('elementor/widgets/widgets_registered', [ $this, 'register_widgets' ]);
	}

	/**
	 * Admin notice
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin()
	{
		if ( isset($_GET['activate']) )
		{
			unset($_GET['activate']);
		}

		$message = sprintf(/* translators: 1: Plugin name 2: Elementor */ esc_html__('"%1$s" requires "%2$s" to be installed and activated.',
			'jhdc-branding-elementor-extension'),
			'<strong>' . esc_html__('JHDC Elementor Brand Extension', 'jhdc-branding-elementor-extension') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'jhdc-branding-elementor-extension') . '</strong>');

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	/**
	 * Admin notice
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version()
	{
		if ( isset($_GET['activate']) )
		{
			unset($_GET['activate']);
		}

		$message = sprintf(/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */ esc_html__('"%1$s" requires "%2$s" version %3$s or greater.',
			'jhdc-branding-elementor-extension'),
			'<strong>' . esc_html__('JHDC Elementor Brand Extension', 'jhdc-branding-elementor-extension') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'jhdc-branding-elementor-extension') . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	/**
	 * Admin notice
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version()
	{
		if ( isset($_GET['activate']) )
		{
			unset($_GET['activate']);
		}

		$message = sprintf(/* translators: 1: Plugin name 2: PHP 3: Required PHP version */ esc_html__('"%1$s" requires "%2$s" version %3$s or greater.',
			'jhdc-branding-elementor-extension'),
			'<strong>' . esc_html__('JHDC Elementor Brand Extension', 'jhdc-branding-elementor-extension') . '</strong>',
			'<strong>' . esc_html__('PHP', 'jhdc-branding-elementor-extension') . '</strong>', self::MINIMUM_PHP_VERSION);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	/**
	 * Register widgets
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function register_widgets()
	{
		$this->includes();
		Plugin::instance()->widgets_manager->register_widget_type(new JHDC_Elementor_WithLove_Widget());
	}

	/**
	 * Include Files
	 * Load required plugin core files.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function includes()
	{
		require_once( __DIR__ . '/widgets/jhdc-branding-elementor-withlove-widget.php' );
	}

}

JHDC_Branding_Elementor_Extension::instance();
