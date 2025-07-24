<?php

function news7_alert_title_add_meta_box() {
    add_meta_box('post_alert_title_metabox', 'Alert Title',
        'news7_post_alert_title_display_metabox', 
        'post', 
        'normal', // Context: 'normal', 'side', or 'advanced'
        'high' // Priority: 'high', 'core', 'default', 'low'
    );
}
add_action( 'add_meta_boxes', 'news7_alert_title_add_meta_box' );

function news7_post_alert_title_display_metabox( $post ) {
    wp_nonce_field( 'custom_alert_title_save_data', 'custom_alert_title_nonce' );

    $alert_title = get_post_meta( $post->ID, 'alert_title', true );
    $main_title = get_post_meta( $post->ID, 'main_title', true );

    // Output the HTML for the subtitle input field.
    ?>
    <p>
        <label for="alert_title">Enter alert title</label>
        <br>
        <input type="text" id="alert_title" name="alert_title" value="<?php echo esc_attr( $alert_title ); ?>" class="small-text" style="width:60%;" />
    </p>
    <p>
        <label for="main_title">Enter main title</label>
        <br>
        <input type="text" id="main_title" name="main_title" value="<?php echo esc_attr( $main_title ); ?>" class="large-text" style="width:100%;" />
    </p>
    <?php
}

/**
 * 3. Save the Meta Box Data
 *
 * This function hooks into 'save_post' to save the data entered into our meta box.
 * It performs several security checks before saving the data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function news7_post_alerttitle_save_metabox_data( $post_id ) {
    // Check if our nonce is set.
    if ( ! isset( $_POST['custom_alert_title_nonce'] ) ) {
        return $post_id;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['custom_alert_title_nonce'], 'custom_alert_title_save_data' ) ) {
        return $post_id;
    }

    // If this is an autosave, our form data will not be set.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    // Check the user's permissions.
    // For posts, 'edit_post' capability is usually sufficient.
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
    }


    // Sanitize the user input.
    // sanitize_text_field() is good for single-line text inputs.
    $alert_title = sanitize_text_field( $_POST['alert_title'] );
    $main_title = sanitize_text_field( $_POST['main_title'] );

    // Update the post meta.
    // update_post_meta( $post_id, $meta_key, $meta_value, $prev_value )
    // If the meta key doesn't exist, it will be added. If it does, it will be updated.
    update_post_meta( $post_id, 'alert_title', $alert_title );
    update_post_meta( $post_id, 'main_title', $main_title );
}
add_action( 'save_post', 'news7_post_alerttitle_save_metabox_data' );
