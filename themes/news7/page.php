<?php get_header(); ?>
<main class="container">
  <div class="row g-5">
    <div class="col-md-3">
        <?php get_template_part('template/sidebar-left'); ?>
    </div>
    <div class="col-md-6 bg-body-tertiary rounded">
        <?php if ( have_posts() ) :  the_post(); ?>
            <article class="blog-post  row p-4 mb-4">        
                <div class="position-relative post-title">
                    <div class="vr"></div>
                    
                    <h1 class="mb-5 blog-h1 text-dark">
                        <?php the_title(); ?>
                    </h1>
                    
                </div>
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="post-image mb-4">
                                    <?php the_post_thumbnail('full',array('class' => 'img-fluid img-full-box')); ?>
                        </div>
                                <?php endif; ?> 
               
                <div class="post-relative">
                <?php the_content(); ?>
                </div>
            </article>
        <?php endif; ?>
    </div>
    <div class="col-md-3">
      <?php get_template_part('template/sidebar-right'); ?>
    </div>
  </div>
</main>
<?php get_footer();
