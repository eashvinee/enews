<?php


/**
 * 1. Remove Default Username Field and Add Custom Fields to Registration Form HTML.
 *
 * This function hooks into 'register_form' to display our custom fields
 * on the default WordPress registration page (wp-login.php?action=register).
 * It also removes the default username field.
 */
function custom_registration_add_fields() {
    // Only apply if we are on the registration action.
    if ( ! isset( $_GET['action'] ) || 'register' !== $_GET['action'] ) {
        return;
    }

    // Remove the default username field.
    // This requires JavaScript as there's no direct PHP hook to remove specific default fields.
    // We'll hide it with CSS and ensure the email field takes its place.
    ?>

    <p>
        <label for="user_password"><?php _e( 'Password', 'custom-registration' ); ?><br />
            <input type="password" name="user_password" id="user_password" class="input" value="" size="25" required />
        </label>
    </p>
    <p>
        <label for="user_password_confirm"><?php _e( 'Confirm Password', 'custom-registration' ); ?><br />
            <input type="password" name="user_password_confirm" id="user_password_confirm" class="input" value="" size="25" required />
        </label>
    </p>
    <p>
        <label for="first_name"><?php _e( 'First Name', 'custom-registration' ); ?><br />
            <input type="text" name="first_name" id="first_name" class="input" value="<?php echo ( isset( $_POST['first_name'] ) ? esc_attr( wp_unslash( $_POST['first_name'] ) ) : '' ); ?>" size="25" />
        </label>
    </p>
    <p>
        <label for="last_name"><?php _e( 'Last Name', 'custom-registration' ); ?><br />
            <input type="text" name="last_name" id="last_name" class="input" value="<?php echo ( isset( $_POST['last_name'] ) ? esc_attr( wp_unslash( $_POST['last_name'] ) ) : '' ); ?>" size="25" />
        </label>
    </p>
    <?php
}
add_action( 'register_form', 'custom_registration_add_fields' );



/**
 * 3. Validate Custom Registration Fields and provide clearer error messages for duplicates.
 *
 * This function hooks into 'registration_errors' to add custom validation rules
 * for our new fields.
 *
 * @param WP_Error $errors   A WP_Error object containing any errors.
 * @param string   $sanitized_user_login The user's sanitized username (will be email here).
 * @param string   $user_email The user's email address.
 * @return WP_Error The updated WP_Error object.
 */
function custom_registration_validation( $errors, $sanitized_user_login, $user_email ) {
    // Validate Password
    if ( empty( $_POST['user_password'] ) ) {
        $errors->add( 'password_empty', __( '<strong>ERROR</strong>: Password field is empty.', 'custom-registration' ) );
    } elseif ( strlen( $_POST['user_password'] ) < 5 ) { // Example: Minimum password length
        $errors->add( 'password_short', __( '<strong>ERROR</strong>: Password must be at least 5 characters long.', 'custom-registration' ) );
    } elseif ( $_POST['user_password'] !== $_POST['user_password_confirm'] ) {
        $errors->add( 'password_mismatch', __( '<strong>ERROR</strong>: Passwords do not match.', 'custom-registration' ) );
    }

    // Validate First Name (optional, uncomment to make required)
     if ( empty( $_POST['first_name'] ) ) {
         $errors->add( 'first_name_empty', __( '<strong>ERROR</strong>: Please enter your first name.', 'custom-registration' ) );
     }

    // Validate Last Name (optional, uncomment to make required)
    // if ( empty( $_POST['last_name'] ) ) {
    //     $errors->add( 'last_name_empty', __( '<strong>ERROR</strong>: Please enter your last name.', 'custom-registration' ) );
    // }

    // --- Improved Duplicate Checks ---
    // Check if the email is already registered as an email for *any* user.
    if ( email_exists( $user_email ) ) {
        $errors->add( 'duplicate_email', __( '<strong>ERROR</strong>: This email address is already registered. Please use a different email or log in.', 'custom-registration' ) );
    }




    return $errors;
}
add_filter( 'registration_errors', 'custom_registration_validation', 10, 3 );

/**
 * 4. Save Custom Registration Fields and Set Password.
 *
 * This function hooks into 'user_register' to save the custom field data
 * and set the user's password after successful registration.
 *
 * @param int $user_id The ID of the newly registered user.
 */
function custom_registration_save_fields( $user_id ) {
    // Check if passwords were submitted and valid.
    if ( isset( $_POST['user_password'] ) && ! empty( $_POST['user_password'] ) ) {
        // Set the user's password directly.
        wp_set_password( $_POST['user_password'], $user_id );
    }

    // Save First Name.
    if ( isset( $_POST['first_name'] ) ) {
        update_user_meta( $user_id, 'first_name', sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) );
    }

    // Save Last Name.
    if ( isset( $_POST['last_name'] ) ) {
        update_user_meta( $user_id, 'last_name', sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) );
    }
}
add_action( 'user_register', 'custom_registration_save_fields', 10, 1 );

/**
 * Optional: Disable the default "New User Registration" email that contains password reset link.
 *
 * Since the user is setting their password directly, the default email is redundant.
 * This function removes the default email action.
 */
function custom_registration_disable_default_new_user_notification_email() {
    remove_action( 'register_new_user', 'wp_send_new_user_notifications' );
    remove_action( 'edit_user_profile', 'wp_send_new_user_notifications' );
    remove_action( 'user_add_new_user', 'wp_send_new_user_notifications' );
}
add_action( 'init', 'custom_registration_disable_default_new_user_notification_email' );

/**
 * Optional: Send a custom welcome email after registration.
 *
 * If you disable the default email, you might want to send your own custom welcome email.
 */
function custom_registration_send_welcome_email( $user_id ) {
    $user_info = get_userdata( $user_id );
    $blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

    $subject = sprintf( __( '[%s] Welcome to our site!', 'custom-registration' ), $blogname );
    $message = sprintf( __( 'Hi %s,', 'custom-registration' ), $user_info->first_name ? $user_info->first_name : $user_info->user_login ) . "\r\n\r\n";
    $message .= sprintf( __( 'Thank you for registering at %s.', 'custom-registration' ), $blogname ) . "\r\n\r\n";
    $message .= sprintf( __( 'Your username is: %s', 'custom-registration' ), $user_info->user_login ) . "\r\n";
    $message .= sprintf( __( 'You can log in here: %s', 'custom-registration' ), wp_login_url() ) . "\r\n\r\n";
    $message .= __( 'We look forward to seeing you around!', 'custom-registration' ) . "\r\n";

    wp_mail( $user_info->user_email, $subject, $message );
}
// Only add this if you disabled the default email and want a custom one.
add_action( 'user_register', 'custom_registration_send_welcome_email', 11, 1 ); // Run after saving fields



//add_action("login_header");