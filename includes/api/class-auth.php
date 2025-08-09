<?php
namespace SimplePortfolio\Auth;

defined('ABSPATH') || exit;

class Auth {

    public static function validate_key($request) {
        $header_key = $request->get_header('x_api_key');
        if (empty($header_key)) {
            return false;
        }

        $saved_keys = get_option('simple_portfolio_api_keys', []);
        if(!array_key_exists($header_key, $saved_keys)) {
            return false;
        }

        $saved_keys[$header_key]['usage'] += 1;
        update_option('simple_portfolio_api_keys', $saved_keys);

        return true;
    }
}
