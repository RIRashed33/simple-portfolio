<?php
namespace SimplePortfolio;

use function SimplePortfolio\CPT\register as register_cpt;
use function SimplePortfolio\Taxonomy\register as register_taxonomy;
use function SimplePortfolio\Metabox\add as add_meta_boxes;
use function SimplePortfolio\Metabox\save as save_meta_boxes;
use function SimplePortfolio\Shortcode\init as shortcode_init; 
use SimplePortfolio\Settings\Settings;
use SimplePortfolio\API\API;

defined('ABSPATH') || exit;


class Plugin {

    public function run() {
        add_action('init', [$this, 'register_post_type']);
        add_action('init', [$this, 'register_taxonomy']);
        add_action('add_meta_boxes', [ $this, 'add_meta_boxes' ]);
        add_action('save_post', [ $this, 'save_meta_boxes' ]);
        add_action('init', [$this, 'register_shortcode']);

        $settings = new Settings();
        $settings->init();

        $api = new API();
        $api->init();
		
		add_action('rest_api_init', [$this, 'add_cors_headers'], 15);
    }

    // Register the Portfolio post type
    public function register_post_type() {
        register_cpt();
    }

    // Register the Project Type taxonomy
    public function register_taxonomy() {
        register_taxonomy();
    }

    // Register Metabox
    public function add_meta_boxes() {
        add_meta_boxes();
    }

    // Save Metabox
    public function save_meta_boxes($post_id) {
        save_meta_boxes($post_id);
    }

    // Register shortcode
    public function register_shortcode() {
        shortcode_init();
    }
	
	// Remove WP default CORS headers
	public function add_cors_headers() {
    remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
		add_filter('rest_pre_serve_request', function ($value) {
			$current_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

			if (strpos($current_url, '/simple-portfolio/v1/portfolio-list') !== false || strpos($current_url, '/simple-portfolio/v1/portfolio') !== false) {
				header('Access-Control-Allow-Origin: *');
				header('Access-Control-Allow-Methods: GET');
				header('Access-Control-Allow-Headers: X-API-Key, Content-Type');
			}
			return $value;
		});
	}

    // Actions to perform on plugin activation
    public static function activate() {
        register_cpt();
        register_taxonomy();
        flush_rewrite_rules();
    }

    // Actions to perform on plugin deactivation
    public static function deactivate() {
        flush_rewrite_rules();
    }
}
