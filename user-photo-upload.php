<?php
/**
 * Plugin Name: User Photo Upload
 * Plugin URI: https://www.rubyvio.com
 * Description: Allows users to upload their own profile photo with editing and customization options.
 * Version: 1.2.2
 * Author: Josef Hrubý - Rubyvio.com
 * Text Domain: user-photo-upload
 * Domain Path: /languages
 * License: GPL v2 or later
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 1) Load textdomain for translations
 */
function user_profile_photo_load_textdomain() {
    load_plugin_textdomain( 'user-photo-upload', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'user_profile_photo_load_textdomain' );

/**
 * Sanitization callback for settings.
 */
function user_profile_photo_settings_sanitize( $input ) {
    $new_input = array();
    if ( isset( $input['upload_btn_text'] ) )
         $new_input['upload_btn_text'] = sanitize_text_field( wp_unslash( $input['upload_btn_text'] ) );
    if ( isset( $input['remove_btn_text'] ) )
         $new_input['remove_btn_text'] = sanitize_text_field( wp_unslash( $input['remove_btn_text'] ) );
    if ( isset( $input['button_font_family'] ) )
         $new_input['button_font_family'] = sanitize_text_field( wp_unslash( $input['button_font_family'] ) );
    if ( isset( $input['button_font_color'] ) )
         $new_input['button_font_color'] = sanitize_hex_color( wp_unslash( $input['button_font_color'] ) );
    if ( isset( $input['button_bg_color'] ) )
         $new_input['button_bg_color'] = sanitize_hex_color( wp_unslash( $input['button_bg_color'] ) );
    if ( isset( $input['button_border_color'] ) )
         $new_input['button_border_color'] = sanitize_hex_color( wp_unslash( $input['button_border_color'] ) );
    if ( isset( $input['button_border_radius'] ) )
         $new_input['button_border_radius'] = sanitize_text_field( wp_unslash( $input['button_border_radius'] ) );
    if ( isset( $input['button_hover_font_color'] ) )
         $new_input['button_hover_font_color'] = sanitize_hex_color( wp_unslash( $input['button_hover_font_color'] ) );
    if ( isset( $input['button_hover_bg_color'] ) )
         $new_input['button_hover_bg_color'] = sanitize_hex_color( wp_unslash( $input['button_hover_bg_color'] ) );
    if ( isset( $input['button_hover_border_color'] ) )
         $new_input['button_hover_border_color'] = sanitize_hex_color( wp_unslash( $input['button_hover_border_color'] ) );
    if ( isset( $input['button_hover_border_radius'] ) )
         $new_input['button_hover_border_radius'] = sanitize_text_field( wp_unslash( $input['button_hover_border_radius'] ) );
    return $new_input;
}

/**
 * 2) Register settings (Settings -> User Photo Upload)
 */
function user_profile_photo_register_settings() {
    register_setting( 'user_profile_photo_settings_group', 'user_profile_photo_settings', 'user_profile_photo_settings_sanitize' );

    add_settings_section(
        'user_profile_photo_main_section',
        '',
        'user_profile_photo_main_section_cb',
        'user_profile_photo_settings'
    );

    // Button text fields
    add_settings_field(
        'upload_btn_text',
        __( 'Upload Button Text', 'user-photo-upload' ),
        'user_profile_photo_upload_btn_text_cb',
        'user_profile_photo_settings',
        'user_profile_photo_main_section'
    );

    add_settings_field(
        'remove_btn_text',
        __( 'Remove Button Text', 'user-photo-upload' ),
        'user_profile_photo_remove_btn_text_cb',
        'user_profile_photo_settings',
        'user_profile_photo_main_section'
    );

    // Button style fields
    add_settings_field(
        'button_font_family',
        __( 'Button Font Family', 'user-photo-upload' ),
        'user_profile_photo_font_family_cb',
        'user_profile_photo_settings',
        'user_profile_photo_main_section'
    );
    add_settings_field(
        'button_font_color',
        __( 'Button Font Color', 'user-photo-upload' ),
        'user_profile_photo_font_color_cb',
        'user_profile_photo_settings',
        'user_profile_photo_main_section'
    );
    add_settings_field(
        'button_bg_color',
        __( 'Button Background Color', 'user-photo-upload' ),
        'user_profile_photo_bg_color_cb',
        'user_profile_photo_settings',
        'user_profile_photo_main_section'
    );
    add_settings_field(
        'button_border_color',
        __( 'Button Border Color', 'user-photo-upload' ),
        'user_profile_photo_border_color_cb',
        'user_profile_photo_settings',
        'user_profile_photo_main_section'
    );

    // Changed label to "Button Radius (px)"
    add_settings_field(
        'button_border_radius',
        __( 'Button Radius (px)', 'user-photo-upload' ),
        'user_profile_photo_border_radius_cb',
        'user_profile_photo_settings',
        'user_profile_photo_main_section'
    );

    add_settings_field(
        'button_hover_font_color',
        __( 'Hover Font Color', 'user-photo-upload' ),
        'user_profile_photo_hover_font_color_cb',
        'user_profile_photo_settings',
        'user_profile_photo_main_section'
    );
    add_settings_field(
        'button_hover_bg_color',
        __( 'Hover Background Color', 'user-photo-upload' ),
        'user_profile_photo_hover_bg_color_cb',
        'user_profile_photo_settings',
        'user_profile_photo_main_section'
    );
    add_settings_field(
        'button_hover_border_color',
        __( 'Hover Border Color', 'user-photo-upload' ),
        'user_profile_photo_hover_border_color_cb',
        'user_profile_photo_settings',
        'user_profile_photo_main_section'
    );

    // Changed label to "Button Hover Radius (px)"
    add_settings_field(
        'button_hover_border_radius',
        __( 'Button Hover Radius (px)', 'user-photo-upload' ),
        'user_profile_photo_hover_border_radius_cb',
        'user_profile_photo_settings',
        'user_profile_photo_main_section'
    );
}
add_action( 'admin_init', 'user_profile_photo_register_settings' );

function user_profile_photo_main_section_cb() {
    echo '<p>' . esc_html__( 'Set the text and styling for the profile photo buttons.', 'user-photo-upload' ) . '</p>';
}

function user_profile_photo_upload_btn_text_cb() {
    $options = get_option( 'user_profile_photo_settings' );
    $val = isset( $options['upload_btn_text'] ) ? $options['upload_btn_text'] : __( 'Upload Photo', 'user-photo-upload' );
    echo '<input type="text" name="user_profile_photo_settings[upload_btn_text]" value="' . esc_attr( $val ) . '" style="width: 300px;">';
}

function user_profile_photo_remove_btn_text_cb() {
    $options = get_option( 'user_profile_photo_settings' );
    $val = isset( $options['remove_btn_text'] ) ? $options['remove_btn_text'] : __( 'Remove Photo', 'user-photo-upload' );
    echo '<input type="text" name="user_profile_photo_settings[remove_btn_text]" value="' . esc_attr( $val ) . '" style="width: 300px;">';
}

// Helper to render color input
function user_profile_photo_color_input( $key, $default = '#000000' ) {
    $options = get_option( 'user_profile_photo_settings' );
    $val = isset( $options[ $key ] ) ? $options[ $key ] : $default;
    echo '<input type="color" name="user_profile_photo_settings[' . esc_attr( $key ) . ']" value="' . esc_attr( $val ) . '">';
}

// Helper to render text input
function user_profile_photo_text_input( $key, $default = '' ) {
    $options = get_option( 'user_profile_photo_settings' );
    $val = isset( $options[ $key ] ) ? $options[ $key ] : $default;
    echo '<input type="text" name="user_profile_photo_settings[' . esc_attr( $key ) . ']" value="' . esc_attr( $val ) . '" style="width: 300px;">';
}

function user_profile_photo_font_family_cb() {
    $fonts = array( 'Arial', 'Verdana', 'Tahoma', 'Georgia', 'Times New Roman', 'Roboto', 'Open Sans', 'Lato', 'Montserrat', 'Poppins' );
    $options = get_option( 'user_profile_photo_settings' );
    $current = isset( $options['button_font_family'] ) ? $options['button_font_family'] : 'Arial';

    echo '<select name="user_profile_photo_settings[button_font_family]">';
    foreach ( $fonts as $font ) {
        echo '<option value="' . esc_attr( $font ) . '"' . selected( $current, $font, false ) . '>' . esc_html( $font ) . '</option>';
    }
    echo '</select>';
    echo '<p class="description">' . esc_html__( 'Google Fonts (e.g., Roboto, Open Sans) must be manually loaded in your theme.', 'user-photo-upload' ) . '</p>';
}

function user_profile_photo_font_color_cb() {
    user_profile_photo_color_input( 'button_font_color', '#000000' );
}

function user_profile_photo_bg_color_cb() {
    user_profile_photo_color_input( 'button_bg_color', '#f1f1f1' );
}

function user_profile_photo_border_color_cb() {
    user_profile_photo_color_input( 'button_border_color', '#cccccc' );
}

function user_profile_photo_border_radius_cb() {
    user_profile_photo_text_input( 'button_border_radius', '4' );
}

function user_profile_photo_hover_font_color_cb() {
    user_profile_photo_color_input( 'button_hover_font_color', '#000000' );
}

function user_profile_photo_hover_bg_color_cb() {
    user_profile_photo_color_input( 'button_hover_bg_color', '#e2e2e2' );
}

function user_profile_photo_hover_border_color_cb() {
    user_profile_photo_color_input( 'button_hover_border_color', '#999999' );
}

function user_profile_photo_hover_border_radius_cb() {
    user_profile_photo_text_input( 'button_hover_border_radius', '4' );
}

/**
 * 3) Create Settings menu page
 */
function user_profile_photo_create_menu_page() {
    add_options_page(
        esc_html__( 'User Photo Upload Settings', 'user-photo-upload' ),
        esc_html__( 'User Photo Upload', 'user-photo-upload' ),
        'manage_options',
        'user_profile_photo_settings',
        'user_profile_photo_settings_page_html'
    );
}
add_action( 'admin_menu', 'user_profile_photo_create_menu_page' );

function user_profile_photo_settings_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
<div class="wrap">
    <h1><?php esc_html_e( 'User Photo Upload Settings', 'user-photo-upload' ); ?></h1>
    <form method="post" action="options.php">
        <?php
            settings_fields( 'user_profile_photo_settings_group' );
            do_settings_sections( 'user_profile_photo_settings' );
            submit_button( esc_html__( 'Save Changes', 'user-photo-upload' ) );
        ?>
    </form>
    <hr />
    <!-- Plugin documentation link. This text is not localized. -->
    <p><a href="<?php echo esc_url( plugins_url( 'readme.txt', __FILE__ ) ); ?>" target="_blank">Plugin Documentation</a></p>
</div>
<?php
}

/**
 * 4) Get button text
 */
function user_profile_photo_get_button_text( $type = 'upload' ) {
    $options = get_option( 'user_profile_photo_settings', array() );
    if ( 'upload' === $type ) {
        return ! empty( $options['upload_btn_text'] ) ? $options['upload_btn_text'] : esc_html__( 'Upload Photo', 'user-photo-upload' );
    } else {
        return ! empty( $options['remove_btn_text'] ) ? $options['remove_btn_text'] : esc_html__( 'Remove Photo', 'user-photo-upload' );
    }
}

/**
 * 5) Enqueue CSS & JS + inline styles from settings
 */
function user_profile_photo_enqueue_scripts( $hook ) {
    if ( ! in_array( $hook, array( 'profile.php', 'user-edit.php', 'user-new.php' ) ) ) {
        return;
    }

    wp_enqueue_media();

    wp_enqueue_style(
        'user-profile-photo-style',
        plugins_url( 'assets/css/style.css', __FILE__ ),
        array(),
        '1.0'
    );

    wp_enqueue_script(
        'user-profile-photo-script',
        plugins_url( 'assets/js/script.js', __FILE__ ),
        array( 'jquery', 'media-upload', 'media-views' ),
        '1.0',
        true
    );

    wp_localize_script( 'user-profile-photo-script', 'userProfilePhoto', array(
        'title'  => esc_html__( 'Upload Profile Photo', 'user-photo-upload' ),
        'button' => esc_html__( 'Use Photo', 'user-photo-upload' ),
        'upload' => user_profile_photo_get_button_text( 'upload' ),
        'remove' => user_profile_photo_get_button_text( 'remove' ),
    ) );

    $options = get_option( 'user_profile_photo_settings', array() );
    $inline_css = '.profile-photo-container .photo-buttons input[type="button"] {
        font-family: ' . esc_attr( $options['button_font_family'] ?? 'Arial' ) . ';
        color: ' . esc_attr( $options['button_font_color'] ?? '#000000' ) . ';
        background-color: ' . esc_attr( $options['button_bg_color'] ?? '#f1f1f1' ) . ';
        border: 1px solid ' . esc_attr( $options['button_border_color'] ?? '#cccccc' ) . ';
        border-radius: ' . intval( $options['button_border_radius'] ?? 4 ) . 'px;
    }
    .profile-photo-container .photo-buttons input[type="button"]:hover {
        color: ' . esc_attr( $options['button_hover_font_color'] ?? '#000000' ) . ';
        background-color: ' . esc_attr( $options['button_hover_bg_color'] ?? '#e2e2e2' ) . ';
        border-color: ' . esc_attr( $options['button_hover_border_color'] ?? '#999999' ) . ';
        border-radius: ' . intval( $options['button_hover_border_radius'] ?? 4 ) . 'px;
    }';
    wp_add_inline_style( 'user-profile-photo-style', $inline_css );
}
add_action( 'admin_enqueue_scripts', 'user_profile_photo_enqueue_scripts' );

/**
 * 6) Activate plugin -> create folders and default settings
 */
function user_profile_photo_activate() {
    wp_mkdir_p( plugin_dir_path( __FILE__ ) . 'assets/css' );
    wp_mkdir_p( plugin_dir_path( __FILE__ ) . 'assets/js' );

    $default_settings = array(
        'upload_btn_text'           => esc_html__( 'Upload Photo', 'user-photo-upload' ),
        'remove_btn_text'           => esc_html__( 'Remove Photo', 'user-photo-upload' ),
        'button_font_family'        => 'Arial',
        'button_font_color'         => '#ffffff',
        'button_bg_color'           => '#2271b1',
        'button_border_color'       => '#2271b1',
        'button_border_radius'      => '4',
        'button_hover_font_color'   => '#ffffff',
        'button_hover_bg_color'     => '#135e96',
        'button_hover_border_color' => '#135e96',
    );

    if ( false === get_option( 'user_profile_photo_settings' ) ) {
        update_option( 'user_profile_photo_settings', $default_settings );
    }
}
register_activation_hook( __FILE__, 'user_profile_photo_activate' );

/**
 * 7) Add fields in user profile
 *
 * Zobrazujeme pole mezi "Osobní nastavení" a "Jméno" pomocí hooku "personal_options" (priorita 99)
 */
function user_profile_photo_fields( $user ) {
    $profile_photo = get_user_meta( $user->ID, 'user_profile_photo', true );
    $photo_filters = get_user_meta( $user->ID, 'user_profile_photo_filters', true );
    ?>
<h3><?php esc_html_e( 'Profile Photo', 'user-photo-upload' ); ?></h3>
<?php wp_nonce_field( 'user_profile_photo_nonce', 'user_profile_photo_nonce' ); ?>
<div class="profile-photo-container">
    <!-- Photo Preview -->
    <div class="profile-photo-preview">
        <?php if ( $profile_photo ) : ?>
        <img src="<?php echo esc_url( $profile_photo ); ?>"
            alt="<?php esc_attr_e( 'Profile Photo', 'user-photo-upload' ); ?>" />
        <?php endif; ?>
    </div>
    <!-- Photo URL -->
    <div class="photo-url-container">
        <input type="text" name="user_profile_photo" id="user_profile_photo"
            value="<?php echo esc_attr( $profile_photo ); ?>" class="regular-text" />
    </div>
    <!-- Hidden input for storing filter settings -->
    <input type="hidden" name="photo_filters" value="<?php echo esc_attr( $photo_filters ); ?>">
    <!-- Buttons -->
    <div class="photo-buttons">
        <input type="button" class="button-secondary"
            value="<?php echo esc_attr( user_profile_photo_get_button_text( 'upload' ) ); ?>"
            id="upload_profile_photo_button" />
        <input type="button" class="button-secondary"
            value="<?php echo esc_attr( user_profile_photo_get_button_text( 'remove' ) ); ?>"
            id="remove_profile_photo_button" <?php echo ( $profile_photo ? '' : 'style="display:none;"' ); ?> />
    </div>
    <!-- Filters Container (vždy viditelné) -->
    <div id="photo-filters-container">
        <div class="photo-filter">
            <label><?php esc_html_e( 'Preset Filter:', 'user-photo-upload' ); ?></label>
            <select id="preset-filters">
                <option value="none"><?php esc_html_e( 'None', 'user-photo-upload' ); ?></option>
                <option value="sepia"><?php esc_html_e( 'Sepia', 'user-photo-upload' ); ?></option>
                <option value="grayscale"><?php esc_html_e( 'Grayscale', 'user-photo-upload' ); ?></option>
                <option value="highContrast"><?php esc_html_e( 'High Contrast', 'user-photo-upload' ); ?></option>
                <option value="highBrightness"><?php esc_html_e( 'High Brightness', 'user-photo-upload' ); ?></option>
                <option value="vintage"><?php esc_html_e( 'Vintage', 'user-photo-upload' ); ?></option>
                <option value="cool"><?php esc_html_e( 'Cool', 'user-photo-upload' ); ?></option>
                <option value="warm"><?php esc_html_e( 'Warm', 'user-photo-upload' ); ?></option>
                <option value="duotone"><?php esc_html_e( 'Duotone', 'user-photo-upload' ); ?></option>
                <option value="dramatic"><?php esc_html_e( 'Dramatic', 'user-photo-upload' ); ?></option>
            </select>
        </div>
        <div class="photo-filter">
            <label><?php esc_html_e( 'Brightness:', 'user-photo-upload' ); ?></label>
            <input type="range" data-filter="brightness" min="0" max="200" value="100">
        </div>
        <div class="photo-filter">
            <label><?php esc_html_e( 'Contrast:', 'user-photo-upload' ); ?></label>
            <input type="range" data-filter="contrast" min="0" max="200" value="100">
        </div>
        <div class="photo-filter">
            <label><?php esc_html_e( 'Saturation:', 'user-photo-upload' ); ?></label>
            <input type="range" data-filter="saturate" min="0" max="200" value="100">
        </div>
        <div class="photo-filter">
            <label><?php esc_html_e( 'Grayscale:', 'user-photo-upload' ); ?></label>
            <input type="range" data-filter="grayscale" min="0" max="100" value="0">
        </div>
        <div class="photo-filter">
            <label><?php esc_html_e( 'Corner Rounding (px):', 'user-photo-upload' ); ?></label>
            <input type="range" data-filter="borderRadius" min="0" max="100" value="0">
        </div>
        <div class="photo-filter">
            <label><?php esc_html_e( 'Border Width (px):', 'user-photo-upload' ); ?></label>
            <input type="range" data-filter="borderWidth" min="0" max="5" value="0">
        </div>
        <div class="photo-filter">
            <label><?php esc_html_e( 'Border Style:', 'user-photo-upload' ); ?></label>
            <select data-filter="borderStyle">
                <option value="solid"><?php esc_html_e( 'Solid', 'user-photo-upload' ); ?></option>
                <option value="dashed"><?php esc_html_e( 'Dashed', 'user-photo-upload' ); ?></option>
                <option value="dotted"><?php esc_html_e( 'Dotted', 'user-photo-upload' ); ?></option>
                <option value="double"><?php esc_html_e( 'Double', 'user-photo-upload' ); ?></option>
            </select>
        </div>
        <div class="photo-filter">
            <label><?php esc_html_e( 'Border Color:', 'user-photo-upload' ); ?></label>
            <input type="color" data-filter="borderColor" value="#000000">
        </div>
    </div><!-- #photo-filters-container -->
</div>
<?php
}
remove_action( 'show_user_profile', 'user_profile_photo_fields' );
remove_action( 'edit_user_profile', 'user_profile_photo_fields' );
add_action( 'personal_options', 'user_profile_photo_fields', 99 );
add_action( 'user_new_form', 'user_profile_photo_fields' );

/**
 * 8) Save user photo and filters
 */
function save_user_profile_photo( $user_id ) {
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return;
    }
    // Sanitize and verify nonce
    $nonce = isset( $_POST['user_profile_photo_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['user_profile_photo_nonce'] ) ) : '';
    if ( ! wp_verify_nonce( $nonce, 'user_profile_photo_nonce' ) ) {
        return;
    }
    if ( isset( $_POST['user_profile_photo'] ) ) {
        update_user_meta( $user_id, 'user_profile_photo', sanitize_text_field( wp_unslash( $_POST['user_profile_photo'] ) ) );
    }
    if ( isset( $_POST['photo_filters'] ) ) {
        update_user_meta( $user_id, 'user_profile_photo_filters', sanitize_text_field( wp_unslash( $_POST['photo_filters'] ) ) );
    }
}
add_action( 'personal_options_update', 'save_user_profile_photo' );
add_action( 'edit_user_profile_update', 'save_user_profile_photo' );
add_action( 'user_register', 'save_user_profile_photo' );

/**
 * 9) Custom avatar if user photo is set
 */
function user_profile_photo_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    $user = false;
    if ( is_numeric( $id_or_email ) ) {
        $user = get_user_by( 'id', (int) $id_or_email );
    } elseif ( is_object( $id_or_email ) && ! empty( $id_or_email->user_id ) ) {
        $user = get_user_by( 'id', $id_or_email->user_id );
    } else {
        $user = get_user_by( 'email', $id_or_email );
    }
    if ( $user && is_object( $user ) ) {
        $profile_photo = get_user_meta( $user->ID, 'user_profile_photo', true );
        $photo_filters = get_user_meta( $user->ID, 'user_profile_photo_filters', true );
        if ( $profile_photo ) {
            $style = '';
            if ( $photo_filters ) {
                $filters = json_decode( $photo_filters, true );
                if ( $filters ) {
                    $filterString = sprintf(
                        'brightness(%d%%) contrast(%d%%) saturate(%d%%) grayscale(%d%%)',
                        $filters['brightness'] ?? 100,
                        $filters['contrast'] ?? 100,
                        $filters['saturate'] ?? 100,
                        $filters['grayscale'] ?? 0
                    );
                    $style = sprintf(
                        'filter:%s; -webkit-filter:%s; border-radius:%dpx; border:%dpx %s %s;',
                        $filterString,
                        $filterString,
                        $filters['borderRadius'] ?? 0,
                        $filters['borderWidth'] ?? 0,
                        $filters['borderStyle'] ?? 'solid',
                        $filters['borderColor'] ?? '#000000'
                    );
                }
            }
            // Attempt to get attachment ID from URL. If found, use wp_get_attachment_image.
            $attachment_id = attachment_url_to_postid( $profile_photo );
            if ( $attachment_id ) {
                $attr = array(
                    'style' => $style,
                    'alt'   => $alt,
                );
                return wp_get_attachment_image( $attachment_id, array( $size, $size ), false, $attr );
            } else {
                // WARNING: As user-supplied images are used, wp_get_attachment_image() cannot be applied.
                return sprintf(
                    '<img alt="%s" src="%s" class="avatar avatar-%d photo" height="%d" width="%d" style="%s" />',
                    esc_attr( $alt ),
                    esc_url( $profile_photo ),
                    (int) $size,
                    (int) $size,
                    (int) $size,
                    esc_attr( $style )
                );
            }
        }
    }
    return $avatar;
}
add_filter( 'get_avatar', 'user_profile_photo_avatar', 10, 5 );
?>
