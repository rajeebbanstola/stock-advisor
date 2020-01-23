<?php
/**
 * Plugin Name:       Stock Advisor
 * Plugin URI:        https://fool.com/
 * Description:       Stock Advisor Plugin
 * Version:           1.0.0
 * Author:            The Motley Fool
 * Author URI:        https://fool.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       stockadvisor
 * Domain Path:       /languages
 **/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'StockAdvisor' ) ) :

	/**
	 * Main StockAdvisor Class
	 *
	 * @since 1.0
	 */
	final class StockAdvisor {

		/** Singleton *************************************************************/
		/**
		 * StockAdvisor Instance
		 *
		 * @since  1.0
		 * @access private
		 *
		 * @var    StockAdvisor() The one true StockAdvisor
		 */
		protected static $_instance;

		/**
		 * Main StockAdvisor Instance
		 *
		 * Ensures that only one instance of StockAdvisor exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @since     1.0
		 * @access    public
		 *
		 * @static
		 * @see       StockAdvisor()
		 *
		 * @return    StockAdvisor
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * StockAdvisor Constructor.
		 */
		public function __construct() {
			$this->setup_constants();
			$this->includes();
			$this->init_hooks();

			do_action( 'stockadvisor_loaded' );
		}

		/**
		 * Hook into actions and filters.
		 *
		 * @since  1.8.9
		 */
		private function init_hooks() {
			register_activation_hook( STOCKADVISOR_PLUGIN_FILE, 'stockadvisor_install' );
			add_action( 'plugins_loaded', array( $this, 'init' ), 0 );
		}


		/**
		 * Init StockAdvisor when WordPress Initializes.
		 *
		 * @since 1.8.9
		 */
		public function init() {

			/**
			 * Fires before the StockAdvisor core is initialized.
			 *
			 * @since 1.8.9
			 */
			do_action( 'stockadvisor_before_init' );

			// Set up localization.
			$this->load_textdomain();

			/**
			 * Fire the action after StockAdvisor core loads.
			 *
			 * @param StockAdvisor class instance.
			 *
			 * @since 1.8.7
			 */
			do_action( 'stockadvisor_init', $this );

		}

		/**
		 * Throw error on object clone
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object, therefore we don't want the object to be cloned.
		 *
		 * @since  1.0
		 * @access protected
		 *
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'stockadvisor' ) );
		}

		/**
		 * Disable unserializing of the class
		 *
		 * @since  1.0
		 * @access protected
		 *
		 * @return void
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'stockadvisor' ) );
		}

		/**
		 * Setup plugin constants
		 *
		 * @since  1.0
		 * @access private
		 *
		 * @return void
		 */
		private function setup_constants() {

			// Plugin version.
			if ( ! defined( 'STOCKADVISOR_VERSION' ) ) {
				define( 'STOCKADVISOR_VERSION', '1.0.0' );
			}

			// Plugin Root File.
			if ( ! defined( 'STOCKADVISOR_PLUGIN_FILE' ) ) {
				define( 'STOCKADVISOR_PLUGIN_FILE', __FILE__ );
			}

			// Plugin Folder Path.
			if ( ! defined( 'STOCKADVISOR_PLUGIN_DIR' ) ) {
				define( 'STOCKADVISOR_PLUGIN_DIR', plugin_dir_path( STOCKADVISOR_PLUGIN_FILE ) );
			}

			// Plugin Folder URL.
			if ( ! defined( 'STOCKADVISOR_PLUGIN_URL' ) ) {
				define( 'STOCKADVISOR_PLUGIN_URL', plugin_dir_url( STOCKADVISOR_PLUGIN_FILE ) );
			}

			// Plugin Basename aka: "stockadvisor/stockadvisor.php".
			if ( ! defined( 'STOCKADVISOR_PLUGIN_BASENAME' ) ) {
				define( 'STOCKADVISOR_PLUGIN_BASENAME', plugin_basename( STOCKADVISOR_PLUGIN_FILE ) );
			}
		}

		/**
		 * Include required files
		 *
		 * @since  1.0
		 * @access private
		 *
		 * @return void
		 */
		private function includes() {
			/**
			 * Load plugin files
			 */
			require_once STOCKADVISOR_PLUGIN_DIR . 'includes/post-types.php';
			require_once STOCKADVISOR_PLUGIN_DIR . 'includes/install.php';
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @return void
		 */
		public function load_textdomain() {

			// Set filter for StockAdvisor's languages directory
			$stockadvisor_lang_dir = dirname( plugin_basename( STOCKADVISOR_PLUGIN_FILE ) ) . '/languages/';
			$stockadvisor_lang_dir = apply_filters( 'stockadvisor_languages_directory', $stockadvisor_lang_dir );

			// Traditional WordPress plugin locale filter.
			$locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
			$locale = apply_filters( 'plugin_locale', $locale, 'stockadvisor' );

			unload_textdomain( 'stockadvisor' );
			load_textdomain( 'stockadvisor', WP_LANG_DIR . '/stockadvisor/stockadvisor-' . $locale . '.mo' );
			load_plugin_textdomain( 'stockadvisor', false, $stockadvisor_lang_dir );

		}
	}

endif; // End if class_exists check


/**
 * Start Stock Advisor
 *
 * The main function responsible for returning the one true Stock Advisor instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $stockadvisor = StockAdvisor(); ?>
 *
 * @since 1.0
 * @return object|StockAdvisor
 */
function StockAdvisor() {
	return StockAdvisor::instance();
}

StockAdvisor();