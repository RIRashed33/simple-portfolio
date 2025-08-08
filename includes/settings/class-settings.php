<?php
namespace SimplePortfolio\Settings;

defined('ABSPATH') || exit;

class Settings {

    public static function init() {
        add_action('admin_menu', [__CLASS__, 'add_settings_page']);
        add_action('admin_init', [__CLASS__, 'register_settings']);
    }

    public static function add_settings_page() {
        add_options_page(
            'Simple Portfolio API Settings',
            'Portfolio API',
            'manage_options',
            'simple-portfolio-api-settings',
            [__CLASS__, 'render_settings_page']
        );
    }

    public static function register_settings() {
        register_setting('simple_portfolio_api_settings', 'simple_portfolio_api_keys');
    }

    public static function generate_key() {
        $key = bin2hex(random_bytes(16));
        $keys = get_option('simple_portfolio_api_keys', []);

        $keys[$key] = [
            'usage' => 0,
            'created' => current_time('mysql')
        ];

        update_option('simple_portfolio_api_keys', $keys);
    }

    public static function delete_key($key_to_delete) {
        $keys = get_option('simple_portfolio_api_keys', []);
        if (isset($keys[$key_to_delete])) {
            unset($keys[$key_to_delete]);
            update_option('simple_portfolio_api_keys', $keys);
            return true;
        }
        return false;
    }

    public static function render_settings_page() {
        if (isset($_POST['generate_key']) && check_admin_referer('generate_api_key_action')) {
            self::generate_key();
            echo '<div class="updated"><p>New API key generated.</p></div>';
        }

        if (isset($_POST['delete_key']) && check_admin_referer('delete_api_key_action_' . sanitize_text_field($_POST['delete_key']))) {
            $deleted = self::delete_key(sanitize_text_field($_POST['delete_key']));
            if ($deleted) {
                echo '<div class="updated"><p>API key deleted.</p></div>';
            } else {
                echo '<div class="error"><p>Key not found or could not be deleted.</p></div>';
            }
        }

        $keys = get_option('simple_portfolio_api_keys', []);
        ?>
        <div class="wrap">
            <h1>Simple Portfolio API Keys</h1>
            <form method="post">
                <?php wp_nonce_field('generate_api_key_action'); ?>
                <p>
                    <input type="submit" name="generate_key" class="button button-primary" value="Generate New API Key">
                </p>
            </form>

            <h2>Existing API Keys</h2>
            <table class="widefat">
                <thead>
                    <tr>
                        <th>API Key</th>
                        <th>Count</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($keys as $key => $data): ?>
                        <tr>
                            <td><code><?php echo esc_html($key); ?></code></td>
                            <td><?php echo intval($data['usage']); ?></td>
                            <td><?php echo esc_html($data['created']); ?></td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <?php wp_nonce_field('delete_api_key_action_' . $key); ?>
                                    <input type="hidden" name="delete_key" value="<?php echo esc_attr($key); ?>">
                                    <input type="submit" class="button button-secondary" value="Delete" onclick="return confirm('Are you sure you want to delete this API key?');">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($keys)): ?>
                        <tr><td colspan="4">No API keys found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}