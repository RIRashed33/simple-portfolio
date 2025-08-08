<?php
namespace SimplePortfolio\API;

use SimplePortfolio\Auth\Auth;

defined('ABSPATH') || exit;

class API {

	public static function init() {
		add_action('rest_api_init', [__CLASS__, 'register_routes']);
	}

	public static function register_routes() {
		register_rest_route('simple-portfolio/v1', '/portfolio-list', [
			'methods'             => 'GET',
			'callback'            => [__CLASS__, 'get_portfolio_list'],
			'permission_callback' => '__return_true',
		]);

		register_rest_route('simple-portfolio/v1', '/portfolio', [
			'methods'             => 'GET',
			'callback'            => [__CLASS__, 'get_portfolio'],
			'permission_callback' => '__return_true',
		]);
	}

	// Portfolio List
	public static function get_portfolio_list($request) {
		$content_type = $request->get_header('content-type');
		if (strpos($content_type, 'application/json') === false) {
			return new \WP_REST_Response([
				'error' => 'Content-Type must be application/json'
			], 415);
		}

		$header_key = $request->get_header('x_api_key');
		if (empty($header_key)) {
			return new \WP_REST_Response([
				'error' => 'Unable to request. Make sure you\'re using the correct method.'
			], 400);
		}

		$isValid = Auth::validate_key($request);
		if (!$isValid) {
			return new \WP_REST_Response([
				'error' => 'Invalid API Key'
			], 401);
		}

		$page           = isset($request['page']) ? max(1, (int)$request['page']) : 1;
		$posts_per_page = isset($request['per_page']) ? max(1, (int)$request['per_page']) : 12;
		$type            = isset($request['type']) ? sanitize_text_field($request['type']) : '';

		$tax_query = [];

		if (!empty($type)) {
			$tax_query[] = [
				'taxonomy' => 'project_type',
				'field'    => 'slug',
				'terms'    => $type,
			];
		}

		$args = [
			'post_type'      => 'portfolio',
			'post_status'    => 'publish',
			'posts_per_page' => $posts_per_page,
			'paged'          => $page,
			'tax_query'      => $tax_query,
			'orderby'        => 'ID',
			'order'          => 'ASC',
		];

		$query = new \WP_Query($args);
		$items = [];

		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				$items[] = [
					'id'     => get_the_ID(),
					'title'  => get_the_title(),
					'client_name'  => get_post_meta(get_the_ID(), '_portfolio_client', true),
					'thumb_url'   => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
					'description' => wpautop(get_the_content()),
					'short_description'     => get_the_excerpt(),
					'project_url'  => get_post_meta(get_the_ID(), '_portfolio_url', true),
				];
			}
			wp_reset_postdata();
		}

		$response = [
			'total_posts'    => (int) $query->found_posts,
			'total_pages'    => (int) $query->max_num_pages,
			'current_page'   => (int) $page,
			'posts_per_page' => (int) $posts_per_page,
			'posts'          => $items,
		];

		return new \WP_REST_Response($response, 200);
	}

	// Single Portfolio
	public static function get_portfolio($request) {
		$content_type = $request->get_header('content-type');
		if (strpos($content_type, 'application/json') === false) {
			return new \WP_REST_Response([
				'error' => 'Content-Type must be application/json'
			], 415);
		}

		$header_key = $request->get_header('x_api_key');
		if (empty($header_key)) {
			return new \WP_REST_Response([
				'error' => 'Unable to request. Make sure you\'re using the correct method.'
			], 400);
		}

		$isValid = Auth::validate_key($request);
		if (!$isValid) {
			return new \WP_REST_Response([
				'error' => 'Invalid API Key'
			], 401);
		}

		$id = isset($request['id']) ? max(1, (int)$request['id']) : 1;
		$post = get_post($id);
		
        if (!$post || $post->post_type !== 'portfolio' || $post->post_status !== 'publish') {
            return new \WP_REST_Response(['error' => 'Portfolio not found'], 404);
        }
		
        $data = [
            'id'                => $post->ID,
            'title'             => get_the_title($post),
            'client_name'       => get_post_meta($post->ID, '_portfolio_client', true),
            'thumb_url'         => get_the_post_thumbnail_url($post->ID, 'full'),
            'description'       => apply_filters('the_content', $post->post_content),
            'short_description' => get_the_excerpt($post),
            'project_url'       => get_post_meta($post->ID, '_portfolio_url', true),
        ];

		return new \WP_REST_Response($data, 200);
	}
}
