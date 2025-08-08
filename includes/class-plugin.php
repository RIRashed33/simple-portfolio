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
