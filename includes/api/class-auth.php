<?php
namespace SimplePortfolio\Auth;

defined('ABSPATH') || exit;

class Auth {

    public static function validate_key($request) {
        $headers = $request->get_headers();
        if (empty($headers['x-api-key'])) {
            return false;
        }

        $provided_key = sanitize_text_field($headers['x-api-key']);

        $saved_keys = get_option('simple_portfolio_api_keys', []);
        if (!array_key_exists($provided_key, $saved_keys)) {
            return false;
        }

        // Optional: track usage
        $saved_keys[$provided_key]['usage'] += 1;
        update_option('simple_portfolio_api_keys', $saved_keys);

        return $provided_key;
    }
}
