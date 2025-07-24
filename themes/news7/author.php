<?php get_header(); ?>
<main class="container">
  <div class="row g-5">
    <div class="col-md-3">
        <?php get_template_part('template/sidebar-left'); ?>
    </div>
    <div class="col-md-6 bg-body-tertiary rounded">
        <div class="col-lg-12 px-0 border-bottom">
            <div class="p-4 text-center bg-body-tertiary rounded-3">
                <?php
 $author_id = get_the_author_meta( 'ID' );
        $avatar_size = 64; // You can change this size (e.g., 32, 96, 128)
        $avatar_alt = esc_attr( get_the_author_meta( 'display_name' ) . ' avatar' );

        // Get the avatar HTML.
        $author_avatar = get_avatar( $author_id, $avatar_size, '', $avatar_alt, array( 'class' => 'author-avatar rounded-circle' ) );
       
                ?>
                <div class="bd-placeholder-img rounded-circle  mb-4 enews7-header-image">
                    <?php echo $author_avatar; ?>
                </div>
                <h1 class="text-body-emphasis"><?php echo get_the_author(); ?></h1>
                <?php
   // Common parameters: 'description', 'user_email', 'user_url', 'first_name', 'last_name', etc.
        $author_description = get_the_author_meta( 'description' );
        $author_website = get_the_author_meta( 'user_url' );
                ?>
                <p class=" mx-auto fs-5 text-justify text-muted">
                    <?php echo esc_html( $author_description ); ?>
                </p>
            </div>
        </div>
        <?php get_template_part('template/content-loop'); ?>
    </div>

    <div class="col-md-3">
       <?php get_template_part('template/sidebar-right'); ?>
    </div>
  </div>

</main>
<?php get_footer();
