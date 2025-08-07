<?php
namespace SimplePortfolio;

defined('ABSPATH') || exit;

//Plugin Class
class Plugin {

    // Run all plugin hooks
    public function run() {
        add_action('init', [$this, 'register_post_type']);
        add_action('init', [$this, 'register_taxonomy']);
        // add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        // add_action('save_post', [$this, 'save_meta_boxes']);
        // add_shortcode('portfolio_list', [$this, 'render_shortcode']);
        // add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    // Portfolio Post Type
    public function register_post_type() {
        $labels = [
            'name'               => __('Portfolios', 'simple-portfolio'),
            'singular_name'      => __('Portfolio', 'simple-portfolio'),
            'add_new'            => __('Add New', 'simple-portfolio'),
            'add_new_item'       => __('Add New Portfolio', 'simple-portfolio'),
            'edit_item'          => __('Edit Portfolio', 'simple-portfolio'),
            'new_item'           => __('New Portfolio', 'simple-portfolio'),
            'view_item'          => __('View Portfolio', 'simple-portfolio'),
            'search_items'       => __('Search Portfolios', 'simple-portfolio'),
            'not_found'          => __('No portfolios found', 'simple-portfolio'),
            'not_found_in_trash' => __('No portfolios found in Trash', 'simple-portfolio'),
            'menu_name'          => __('Portfolios', 'simple-portfolio'),
        ];

        register_post_type('portfolio', [
            'labels'        => $labels,
            'public'        => true,
            'show_in_rest'  => true,
            'has_archive'   => true,
            'menu_position' => 5,
            'menu_icon'     => 'dashicons-portfolio',
            'supports'      => ['title', 'editor', 'thumbnail', 'category'],
            'rewrite'       => ['slug' => 'portfolio'],
        ]);
    }

    // Poject Types Taxonomy
    public function register_taxonomy() {
        $labels = [
            'name'              => __('Project Types', 'simple-portfolio'),
            'singular_name'     => __('Project Type', 'simple-portfolio'),
            'search_items'      => __('Search Project Types', 'simple-portfolio'),
            'all_items'         => __('All Project Types', 'simple-portfolio'),
            'edit_item'         => __('Edit Project Type', 'simple-portfolio'),
            'update_item'       => __('Update Project Type', 'simple-portfolio'),
            'add_new_item'      => __('Add New Project Type', 'simple-portfolio'),
            'new_item_name'     => __('New Project Type Name', 'simple-portfolio'),
            'menu_name'         => __('Project Types', 'simple-portfolio'),
        ];

        register_taxonomy('project_type', 'portfolio', [
            'labels'       => $labels,
            'hierarchical' => true,
            'public'       => true,
            'show_in_rest' => true,
            'rewrite'      => ['slug' => 'project-type'],
        ]);
    }

}