<?php
namespace SimplePortfolio\Taxonomy;

defined('ABSPATH') || exit;

// Project Type taxonomy
function register() {
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
