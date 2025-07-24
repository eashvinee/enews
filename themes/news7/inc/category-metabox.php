<?php



/**
 * 1. Enqueue WordPress Media Uploader Scripts
 *
 * This function ensures that the necessary JavaScript and CSS for the
 * WordPress media uploader are loaded on the category add/edit screens.
 */
function category_icon_enqueue_media_uploader() {
    // Only load on category add/edit pages
    $screen = get_current_screen();
    if ( $screen->id === 'edit-category' || $screen->id === 'term' ) {
        wp_enqueue_media(); // Enqueue the media uploader scripts and styles
    }
}
add_action( 'admin_enqueue_scripts', 'category_icon_enqueue_media_uploader' );

/**
 * 2. Add the custom field to the "Add New Category" screen.
 *
 * This function adds the HTML for the icon upload field
 * when creating a new category.
 *
 * @param string $taxonomy The taxonomy slug (e.g., 'category').
 */
function category_icon_add_form_field( $taxonomy ) {
    ?>
    <div class="form-field term-icon-wrap">
        <label for="category-icon-url"><?php _e( 'Category Icon', 'textdomain' ); ?></label>
        <input type="text" name="category_icon_url" id="category-icon-url" value="" class="regular-text" />
        <input type="button" class="button button-secondary category-icon-upload-button" value="<?php _e( 'Upload Image', 'textdomain' ); ?>" />
        <input type="button" class="button button-secondary category-icon-remove-button" value="<?php _e( 'Remove Image', 'textdomain' ); ?>" style="display: none;" />
        <div class="category-icon-preview" style="margin-top:10px;">
            <img src="" style="max-width:100px; height:auto; display:none;" />
        </div>
        <p class="description"><?php _e( 'Upload an icon image for this category.', 'textdomain' ); ?></p>
    </div>
    <?php
}
add_action( 'category_add_form_fields', 'category_icon_add_form_field', 10, 2 );

/**
 * 3. Add the custom field to the "Edit Category" screen.
 *
 * This function adds the HTML for the icon upload field
 * when editing an existing category, pre-filling it with saved data.
 *
 * @param WP_Term $term The current term object.
 */
function category_icon_edit_form_field( $term ) {
    // Get the saved icon URL for the current term.
    $icon_url = get_term_meta( $term->term_id, 'category_icon_url', true );
    $display_style = ! empty( $icon_url ) ? 'block' : 'none'; // Show preview if URL exists
    $remove_button_style = ! empty( $icon_url ) ? 'inline-block' : 'none'; // Show remove button if URL exists
    ?>
    <tr class="form-field term-icon-wrap">
        <th scope="row"><label for="category-icon-url"><?php _e( 'Category Icon', 'textdomain' ); ?></label></th>
        <td>
            <input type="text" name="category_icon_url" id="category-icon-url" value="<?php echo esc_url( $icon_url ); ?>" class="regular-text" />
            <input type="button" class="button button-secondary category-icon-upload-button" value="<?php _e( 'Upload Image', 'textdomain' ); ?>" />
            <input type="button" class="button button-secondary category-icon-remove-button" value="<?php _e( 'Remove Image', 'textdomain' ); ?>" style="display: <?php echo $remove_button_style; ?>;" />
            <div class="category-icon-preview" style="margin-top:10px;">
                <img src="<?php echo esc_url( $icon_url ); ?>" style="max-width:100px; height:auto; display:<?php echo $display_style; ?>;" />
            </div>
            <p class="description"><?php _e( 'Upload an icon image for this category.', 'textdomain' ); ?></p>
        </td>
    </tr>
    <?php
}
add_action( 'edit_category_form_fields', 'category_icon_edit_form_field', 10, 2 );

/**
 * 4. JavaScript for Media Uploader Interaction.
 *
 * This inline script handles the opening of the media uploader,
 * selecting an image, and updating the input field and preview.
 */
function category_icon_media_uploader_script() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            var mediaUploader;

            // Handle 'Upload Image' button click
            $('.category-icon-upload-button').on('click', function(e) {
                e.preventDefault();

                var $button = $(this);
                var $input = $button.prev('input[type="text"]'); // The URL input field
                var $preview = $button.siblings('.category-icon-preview').find('img');
                var $removeButton = $button.next('.category-icon-remove-button');

                // If the uploader already exists, reopen it
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                // Create the media frame.
                mediaUploader = wp.media({
                    title: '<?php _e( "Choose Category Icon", "textdomain" ); ?>',
                    button: {
                        text: '<?php _e( "Use this image", "textdomain" ); ?>',
                    },
                    multiple: false // Only allow selection of a single image
                });

                // When an image is selected, run a callback.
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $input.val(attachment.url); // Set the URL in the input field
                    $preview.attr('src', attachment.url).show(); // Show the image preview
                    $removeButton.show(); // Show the remove button
                });

                // Open the uploader dialog
                mediaUploader.open();
            });

            // Handle 'Remove Image' button click
            $('.category-icon-remove-button').on('click', function(e) {
                e.preventDefault();
                var $button = $(this);
                var $input = $button.siblings('input[type="text"]');
                var $preview = $button.siblings('.category-icon-preview').find('img');

                $input.val(''); // Clear the input field
                $preview.attr('src', '').hide(); // Hide and clear the preview
                $button.hide(); // Hide the remove button itself
            });

            // Initial check to show/hide remove button and preview on page load (for edit screen)
            $('.term-icon-wrap').each(function() {
                var $wrap = $(this);
                var $input = $wrap.find('input[type="text"]');
                var $preview = $wrap.find('.category-icon-preview img');
                var $removeButton = $wrap.find('.category-icon-remove-button');

                if ($input.val()) {
                    $preview.show();
                    $removeButton.show();
                }
            });
        });
    </script>
    <?php
}
add_action( 'admin_footer', 'category_icon_media_uploader_script' ); // Add to admin footer for jQuery availability

/**
 * 5. Save the custom field data when a category is created or updated.
 *
 * This function handles saving the icon URL to term meta.
 *
 * @param int $term_id The ID of the term being saved.
 */
function category_icon_save_term_meta( $term_id ) {
    // Verify nonce for security (though not strictly necessary for term meta, good practice)
    // WordPress handles nonce for term saving, but adding one for our field is safer.
    // However, the current category forms don't have built-in nonce for custom fields.
    // We rely on WordPress's main term saving nonce.

    // Check if our field is set and sanitize the URL.
    if ( isset( $_POST['category_icon_url'] ) ) {
        $icon_url = esc_url_raw( $_POST['category_icon_url'] ); // Sanitize URL

        // Update term meta. If the meta key doesn't exist, it will be added.
        // If it does, it will be updated.
        update_term_meta( $term_id, 'category_icon_url', $icon_url );
    } else {
        // If the field is not set (e.g., on initial creation without an image),
        // ensure the meta is deleted if it exists to clean up.
        delete_term_meta( $term_id, 'category_icon_url' );
    }
}
// Hook into both creation and editing of categories.
add_action( 'created_category', 'category_icon_save_term_meta', 10, 2 );
add_action( 'edited_category', 'category_icon_save_term_meta', 10, 2 );


/**
 * How to display the category icon on your website:
 *
 * To display the category icon on your frontend (e.g., on category archive pages,
 * or when listing categories), you can use the following code:
 *
 * Example 1: On a category archive page (e.g., category.php, archive.php)
 * where the current query is for a category:
 *
 * <?php
 * $current_category = get_queried_object();
 * if ( $current_category && property_exists( $current_category, 'term_id' ) ) {
 * $icon_url = get_term_meta( $current_category->term_id, 'category_icon_url', true );
 * if ( ! empty( $icon_url ) ) {
 * echo '<img src="' . esc_url( $icon_url ) . '" alt="' . esc_attr( $current_category->name ) . ' Icon" class="category-icon" />';
 * }
 * }
 * ?>
 *
 * Example 2: When looping through categories (e.g., in a custom menu, widget, or list):
 * Assuming you have a $category_object (e.g., from get_categories() or get_the_category()):
 *
 * <?php
 * // Example: For a specific category ID (replace 123 with your category ID)
 * $category_id = 123;
 * $icon_url = get_term_meta( $category_id, 'category_icon_url', true );
 * $category_name = get_cat_name( $category_id );
 * if ( ! empty( $icon_url ) ) {
 * echo '<img src="' . esc_url( $icon_url ) . '" alt="' . esc_attr( $category_name ) . ' Icon" class="category-icon" />';
 * }
 * ?>
 *
 * Example 3: Inside the WordPress Loop, to get the icon for the post's first category:
 * (Place this inside the `while ( have_posts() ) : the_post();` loop)
 *
 * <?php
 * $categories = get_the_category();
 * if ( ! empty( $categories ) ) {
 * $first_category = $categories[0]; // Get the first category object
 * $icon_url = get_term_meta( $first_category->term_id, 'category_icon_url', true );
 * if ( ! empty( $icon_url ) ) {
 * echo '<img src="' . esc_url( $icon_url ) . '" alt="' . esc_attr( $first_category->name ) . ' Icon" class="post-category-icon" />';
 * }
 * }
 * ?>
 *
 * Remember to adjust the HTML tags and classes (e.g., `<img>`, `category-icon`)
 * to match your theme's styling.
 */
