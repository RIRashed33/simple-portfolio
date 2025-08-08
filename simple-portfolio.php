<?php
/**
 * Plugin Name:       Simple Portfolio
 * Plugin URI:        https://example.com/simple-portfolio
 * Description:       A simple plugin to showcase portfolio projects with custom post types, custom fields, and a display shortcode.
 * Version:           1.0.0
 * Requires at least: 5.0
 * Requires PHP:      7.4
 * Author:            Rashedul Islam
 * Author URI:        https://rirashed33.github.io/
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       simple-portfolio
 * Domain Path:       /languages
 */

defined('ABSPATH') || exit;

// Namespace
use SimplePortfolio\Plugin;

// Plugin Files
require_once plugin_dir_path(__FILE__) . 'includes/class-plugin.php';
require_once plugin_dir_path(__FILE__) . 'includes/cpt.php';
require_once plugin_dir_path(__FILE__) . 'includes/taxonomy.php';
require_once plugin_dir_path(__FILE__) . 'includes/metabox.php';


function simple_portfolio_run_plugin() {
    $plugin = new Plugin();
    $plugin->run();
}
simple_portfolio_run_plugin();