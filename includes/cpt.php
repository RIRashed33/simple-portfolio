<?php
namespace SimplePortfolio\CPT;

defined('ABSPATH') || exit;

// Portfolio custom post type.
function register() {
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
        'supports'      => ['title', 'editor', 'thumbnail'],
        'rewrite'       => ['slug' => 'portfolio'],
    ]);
}