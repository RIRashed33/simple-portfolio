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

if (!defined('SIMPLE_PORTFOLIO_PATH')) {
    define('SIMPLE_PORTFOLIO_PATH', plugin_dir_path(__FILE__));
}

// Namespace
use SimplePortfolio\Plugin;

//CSS Files
wp_enqueue_style('simple-portfolio-list-style', plugins_url( 'assets/css/portfolio.css', __FILE__ ) , array(), '1.0');

// Plugin Files
require_once SIMPLE_PORTFOLIO_PATH . 'includes/class-plugin.php';
require_once SIMPLE_PORTFOLIO_PATH . 'includes/cpt.php';
require_once SIMPLE_PORTFOLIO_PATH . 'includes/taxonomy.php';
require_once SIMPLE_PORTFOLIO_PATH . 'includes/metabox.php';
require_once SIMPLE_PORTFOLIO_PATH . 'includes/shortcode.php';
require_once SIMPLE_PORTFOLIO_PATH . 'includes/settings/class-settings.php';
require_once SIMPLE_PORTFOLIO_PATH . 'includes/api/class-api.php';
require_once SIMPLE_PORTFOLIO_PATH . 'includes/api/class-auth.php';

function simple_portfolio_run_plugin() {
    $plugin = new Plugin();
    $plugin->run();
}
simple_portfolio_run_plugin();


// Single Portfolio Fallback Template
add_filter('template_include', function($template) {
    if ( is_singular('portfolio') ) {  
        $theme_template = locate_template('single-portfolio.php');
        
        if ( $theme_template ) {
            return $theme_template;
        } else {
            return SIMPLE_PORTFOLIO_PATH . 'templates/single-portfolio.php';
        }
    }

    return $template;
});
