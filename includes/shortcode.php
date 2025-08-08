<?php
namespace SimplePortfolio\Shortcode;

defined('ABSPATH') || exit;

function init() {
    add_shortcode('portfolio_list', __NAMESPACE__ . '\\render');
}

function render($atts) {
    
    $atts = shortcode_atts([
        'type'           => '', 
        'posts_per_page' => 9,
    ], $atts, 'portfolio_list');

    $posts_per_page = max(1, intval($atts['posts_per_page']));

    $tax_query = [];

    if (!empty($atts['type'])) {
        $tax_query = [
            [
                'taxonomy' => 'project_type',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($atts['type']),
            ]
        ];
    }

    $args = [
        'post_type'      => 'portfolio',
        'posts_per_page' => $posts_per_page,
    ];

    if ($tax_query) {
        $args['tax_query'] = $tax_query;
    }

    $query = new \WP_Query($args);

    if (!$query->have_posts()) {
        return '<p>' . esc_html__('No portfolio items found.', 'simple-portfolio') . '</p>';
    }

    ob_start();
    include SIMPLE_PORTFOLIO_PATH . 'templates/portfolio-list.php';
    return ob_get_clean();
}
