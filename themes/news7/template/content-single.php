 <?php if ( have_posts() ) :  the_post(); ?>
 <article  <?php post_class('blog-post border-bottom row p-4 mb-4'); ?>>        
        <div class="position-relative post-title">
            <div class="vr"></div>
              <?php 
            $alert_title = get_post_meta( get_the_ID(), 'alert_title', true );
            $main_title = get_post_meta( get_the_ID(), 'main_title', true );
            ?>
            <h3 class="mb-0 blog-h3 text-dark">
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
                </a>
                <br/>
                Published by <?php the_author_posts_link(); ?>    
            </div>
            <?php get_template_part('template/social-share'); ?>
        </div>
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="post-image mb-4">
                    <?php the_post_thumbnail('full',array('class' => 'img-fluid img-full-box')); ?>
            </div>
        <?php endif; ?> 
      
        <div class="post-relative">
           <?php the_content(); ?>

        </div>

        <div class="col-md-12 ">

            <?php echo get_the_tag_list( '<ul class="news7-tags-list"><li>', '</li><li>', '</li></ul>' ); ?>
        </div>
    </article>
    <?php endif;

     get_template_part('template/related-posts');