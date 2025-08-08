<?php
namespace SimplePortfolio\Metabox;

defined('ABSPATH') || exit;

// Hook to add custom metabox
function add() {
    add_meta_box(
        'portfolio_details',
        __('Portfolio Details', 'simple-portfolio'),
        __NAMESPACE__ . '\render',      
        'portfolio',
        'side',
        'high'
    );
}

// Render the HTML for the metabox
function render($post) {
    wp_nonce_field('portfolio_meta_nonce_action', 'portfolio_meta_nonce');

    $client = get_post_meta($post->ID, '_portfolio_client', true);
    $url = get_post_meta($post->ID, '_portfolio_url', true);

    ?>
    <p>
        <label for="portfolio_client"><?php _e('Client Name', 'simple-portfolio'); ?></label><br />
        <input type="text" name="portfolio_client" id="portfolio_client" value="<?php echo esc_attr($client); ?>" class="widefat"/>
    </p>
    <p>
        <label for="portfolio_url"><?php _e('Project URL', 'simple-portfolio'); ?></label><br />
        <input type="url" name="portfolio_url" id="portfolio_url" value="<?php echo esc_url($url); ?>" class="widefat"/>
    </p>
    <?php
}

// Save metabox data
function save($post_id) {
    if (!isset($_POST['portfolio_meta_nonce']) || !wp_verify_nonce($_POST['portfolio_meta_nonce'], 'portfolio_meta_nonce_action')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['portfolio_client'])) {
        update_post_meta($post_id, '_portfolio_client', sanitize_text_field($_POST['portfolio_client']));
    }

    if (isset($_POST['portfolio_url'])) {
        update_post_meta($post_id, '_portfolio_url', esc_url_raw($_POST['portfolio_url']));
    }
}
