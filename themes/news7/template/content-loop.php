<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
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
            <?php get_template_part('template/social-share'); ?>
        </div>
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="col d-none d-lg-block  post-image">
                            <?php the_post_thumbnail(array(350, 223),array('class' => 'img-fluid img-full-box')); ?>
                </div>
                        <?php endif; ?> 
        <?php /*@if($post->image)
        <div class="col d-none d-lg-block  post-image">
            <img  src="{{asset($post->image)}}" class="w-100" alt="your image" class="mt-3"/>
        </div>
        @endif */ ?>
    </article>
  
     <?php endwhile; ?>
        <nav class="news7-pagination">
            <?php 
                echo paginate_links(array(
                    'current'=>max(1,get_query_var('paged')),
                    'total'=>$wp_query->max_num_pages,
                    'type'=>'list', //default it will return anchor
                ));
            ?>
        </nav> 
     
     <?php else : ?>
                <div class="col-md-12 col-lg-12">
                    <p>Sorry, no posts were found!</p>
                </div>
                <?php endif; ?> 