<?php


/**
 * 1. Add Custom Avatar Upload Field to User Profile Page.
 *
 * This function hooks into 'show_user_profile' (for current user)
 * and 'edit_user_profile' (for other users by admin) to display the upload field.
 *
 * @param WP_User $user The user object currently being edited.
 */
function custom_avatar_add_profile_field( $user ) {
    // Get the current custom avatar URL for the user.
    $custom_avatar_url = get_user_meta( $user->ID, 'custom_user_avatar', true );
    ?>
    <h3 class="heading-size-3"><?php _e( 'Custom Avatar', 'custom-avatar' ); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="custom_user_avatar"><?php _e( 'Upload Avatar', 'custom-avatar' ); ?></label></th>
            <td>
                <?php if ( $custom_avatar_url ) : ?>
                    <img src="<?php echo esc_url( $custom_avatar_url ); ?>" class="avatar avatar-96 photo" width="96" height="96" alt="<?php esc_attr_e( 'Current Avatar', 'custom-avatar' ); ?>" style="border-radius: 50%; object-fit: cover; margin-bottom: 10px;" /><br />
                    <input type="checkbox" name="custom_user_avatar_remove" id="custom_user_avatar_remove" value="1" />
                    <label for="custom_user_avatar_remove"><?php _e( 'Remove current avatar', 'custom-avatar' ); ?></label><br />
                <?php endif; ?>
                <input type="file" name="custom_user_avatar" id="custom_user_avatar" accept="image/*" />
                <p class="description">
                    <?php _e( 'Upload a custom profile picture. Recommended size: 150x150 pixels.', 'custom-avatar' ); ?>
                </p>
                <?php if ( $custom_avatar_url ) : ?>
                    <p class="description">
                        <?php _e( 'Leave blank to keep current avatar. Check "Remove" to delete it.', 'custom-avatar' ); ?>
                    </p>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <?php
}
add_action( 'show_user_profile', 'custom_avatar_add_profile_field' );
add_action( 'edit_user_profile', 'custom_avatar_add_profile_field' );

/**
 * 2. Save Custom Avatar Field and Handle Upload.
 *
 * This function hooks into 'personal_options_update' (for current user)
 * and 'edit_user_profile_update' (for other users by admin) to save the avatar.
 *
 * @param int $user_id The ID of the user being edited.
 */
function custom_avatar_save_profile_field( $user_id ) {
    // Check if the current user has permission to edit this user.
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return;
    }

    // Include WordPress's file upload functions.
    // This is crucial for wp_handle_upload() to work.
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );

    // Handle avatar removal first.
    if ( isset( $_POST['custom_user_avatar_remove'] ) && $_POST['custom_user_avatar_remove'] == '1' ) {
        delete_user_meta( $user_id, 'custom_user_avatar' );
        // Optionally, delete the file from media library if desired.
        // This requires more complex logic to find the attachment ID by URL.
        // For simplicity, we're just removing the meta link here.
    }

    // Handle new avatar upload.
    if ( ! empty( $_FILES['custom_user_avatar']['name'] ) ) {
        $upload_overrides = array( 'test_form' => false ); // Important for admin uploads
        $uploaded_file    = wp_handle_upload( $_FILES['custom_user_avatar'], $upload_overrides );

        if ( isset( $uploaded_file['file'] ) ) { // Check if upload was successful
            $file_url  = $uploaded_file['url'];
            $file_type = $uploaded_file['type'];
            $file_name = basename( $uploaded_file['file'] );

            // Optionally, create an attachment in the Media Library.
            // This makes the image manageable via WordPress Media.
            $attachment = array(
                'guid'           => $file_url,
                'post_mime_type' => $file_type,
                'post_title'     => preg_replace( '/\.[^.]+$/', '', $file_name ),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );
            $attach_id = wp_insert_attachment( $attachment, $uploaded_file['file'], 0 ); // 0 for no parent post

            // Generate metadata for the attachment and update the attachment post.
            $attach_data = wp_generate_attachment_metadata( $attach_id, $uploaded_file['file'] );
            wp_update_attachment_metadata( $attach_id, $attach_data );

            // Save the URL of the uploaded image as user meta.
            update_user_meta( $user_id, 'custom_user_avatar', $file_url );
            update_user_meta( $user_id, 'custom_user_avatar_attachment_id', $attach_id ); // Store attachment ID
        } else {
            // Handle upload error (e.g., file type not allowed, upload limit exceeded).
            // You might want to add an admin notice here.
            error_log( 'Custom Avatar Upload Error for user ' . $user_id . ': ' . $uploaded_file['error'] );
        }
    }
}
add_action( 'personal_options_update', 'custom_avatar_save_profile_field' );
add_action( 'edit_user_profile_update', 'custom_avatar_save_profile_field' );

/**
 * 3. Filter `get_avatar` to Use Custom Avatar.
 *
 * This function overrides the default Gravatar behavior.
 *
 * @param string $avatar The HTML for the avatar.
 * @param mixed  $id_or_email The user ID, email address, or comment object.
 * @param int    $size The size of the avatar in pixels.
 * @param string $default The URL of the default avatar.
 * @param string $alt The alt text for the avatar.
 * @return string The modified avatar HTML.
 */
function custom_avatar_get_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    $user_id = 0;

    if ( is_numeric( $id_or_email ) ) {
        $user_id = (int) $id_or_email;
    } elseif ( is_string( $id_or_email ) && ( $user = get_user_by( 'email', $id_or_email ) ) ) {
        $user_id = $user->ID;
    } elseif ( is_object( $id_or_email ) && ! empty( $id_or_email->user_id ) ) {
        $user_id = (int) $id_or_email->user_id;
    }

    if ( $user_id ) {
        $custom_avatar_url = get_user_meta( $user_id, 'custom_user_avatar', true );
        if ( $custom_avatar_url ) {
            // Get the attachment ID if stored, to get proper image sizes.
            $attachment_id = get_user_meta( $user_id, 'custom_user_avatar_attachment_id', true );
            if ( $attachment_id ) {
                $image_attributes = wp_get_attachment_image_src( $attachment_id, array( $size, $size ) );
                if ( $image_attributes ) {
                    $custom_avatar_url = $image_attributes[0]; // Use the resized URL
                }
            }

            $avatar = '<img alt="' . esc_attr( $alt ) . '" src="' . esc_url( $custom_avatar_url ) . '" class="avatar avatar-' . esc_attr( $size ) . ' photo" height="' . esc_attr( $size ) . '" width="' . esc_attr( $size ) . '" style="border-radius: 50%; object-fit: cover;" />';
        }
    }
    return $avatar;
}
add_filter( 'get_avatar', 'custom_avatar_get_avatar', 10, 5 );

/**
 * 4. Add `enctype` to User Profile Forms.
 *
 * This is crucial to allow file uploads from the profile page.
 * WordPress's default user profile forms don't have `enctype="multipart/form-data"` by default.
 */
function custom_avatar_add_form_enctype() {
    echo ' enctype="multipart/form-data"';
}
add_action( 'user_edit_form_tag', 'custom_avatar_add_form_enctype' );
