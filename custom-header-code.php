<?php
/**
 * Plugin Name: Custom Header Code Editor
 * Description: A simple plugin to add custom code to the header.
 * Version: 1.0
 * Author: kkawataki
 */

// Prevent direct access to the file
if (!defined('ABSPATH')) {
    exit;
}

// Function to add custom code to the header
function chc_add_custom_code_to_header() {
    $custom_code = get_option('chc_custom_header_code', '');
    if (!empty($custom_code)) {
        echo $custom_code;
    }
}
add_action('wp_head', 'chc_add_custom_code_to_header');

// Create admin menu item under Settings > Head Tag Editor
function chc_create_admin_menu() {
    add_options_page(
        'Head Tag Editor',         // Page title
        'Head Tag Editor',         // Menu title
        'manage_options',          // Capability
        'custom-header-code',      // Menu slug
        'chc_admin_page_callback'  // Callback function
    );
}
add_action('admin_menu', 'chc_create_admin_menu');

// Admin page callback function
function chc_admin_page_callback() {
    ?>
    <div class="wrap">
        <h1>Head Tag Editor</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields('chc-settings-group');
                do_settings_sections('chc-settings-group');
                $custom_code = get_option('chc_custom_header_code', '');
            ?>
            <textarea name="chc_custom_header_code" rows="10" cols="50" class="large-text"><?php echo esc_textarea($custom_code); ?></textarea>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Register the setting
function chc_register_settings() {
    register_setting('chc-settings-group', 'chc_custom_header_code');
}
add_action('admin_init', 'chc_register_settings');