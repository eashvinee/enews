<?php 

// --- Related Posts Section (Based on Tags) ---
       
        $current_post_id = get_the_ID();

        // Get all tags for the current post.
        $post_tags = get_the_tags();
        $tag_ids = array();

        if ( $post_tags ) {
            foreach ( $post_tags as $tag ) {
                $tag_ids[] = $tag->term_id; // Collect tag IDs
            }
        }

        // Only proceed if the current post has tags.
       // if ( ! empty( $tag_ids ) ) {
            // Arguments for the related posts query.
            $args = array(
                'post_type'      => 'post', // Query for standard posts
                'tag__in'        => $tag_ids, // Posts that share any of these tags
                'post__not_in'   => array( $current_post_id ), // Exclude the current post
                'posts_per_page' => 5, // Number of related posts to display
                'orderby'        => 'rand', // Order randomly
                'ignore_sticky_posts' => true, // Don't prioritize sticky posts
            );

            // Create a new WP_Query instance.
            $related_posts_query = new WP_Query( $args );




if ( $related_posts_query->have_posts() ) : while ( $related_posts_query->have_posts() ) : $related_posts_query->the_post(); ?>
    <article <?php post_class('blog-post border-bottom row p-4 mb-4'); ?> <?php /*  class="blog-post border-bottom row p-4 mb-4 post-<?php echo get_the_ID(); ?>" */ ?>>        
        <div class="col d-flex text-justify  flex-column position-relative post-title">
            <div class="vr"></div>
            <?php 
            $alert_title = get_post_meta( get_the_ID(), 'alert_title', true );
            $main_title = get_post_meta( get_the_ID(), 'main_title', true );
            ?>
            <h3 class="mb-0 blog-h3 text-dark" title="<?php the_title(); ?>">
                <span><?php echo $alert_title; ?> :</span> 
                <a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none">
                    <?php echo $main_title;  ?>
                </a>
            </h3>
            <div class="blog-post-meta mt-2">
                <?php   $month_archive_link = get_month_link( get_the_date( 'Y' ), get_the_date( 'm' ) ); ?>
                <a href="<?php echo $month_archive_link; ?>">
                <?php the_time('F j, Y'); ?>
                </a>, 
                <a class="d-inline-block mb-2 text-primary-emphasis" href="#">
                    <?php the_category( ', ' );?>
                </a><br/>
                Published by <?php the_author_posts_link(); ?>
            </div>
        </div>
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="col d-none d-lg-block  post-image">
                <?php the_post_thumbnail(array(350, 223),array('class' => 'img-fluid img-full-box')); ?>
            </div>
        <?php endif; ?> 
     
    </article>
  
     <?php endwhile; wp_reset_postdata(); ?>
        
                <?php endif; 