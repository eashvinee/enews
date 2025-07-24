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
                $current_category = get_queried_object();
                 $category_id = $current_category->term_id;
                $icon_url = get_term_meta( $category_id, 'category_icon_url', true ); ?>

                <div class="bd-placeholder-img rounded-circle  mb-4 enews7-header-image">
                    <img src="<?php echo esc_url( $icon_url ); ?>" alt="<?php echo  esc_attr( $current_category->name ); ?>" class="author-avatar rounded-circle" />
                </div>
                <h1 class="text-body-emphasis"><?php echo single_cat_title( '', false ); ?></h1>
                
                <p class=" mx-auto fs-5 text-justify text-muted">
                    <?php echo category_description(); ?>
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
