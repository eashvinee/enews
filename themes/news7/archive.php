<?php get_header(); ?>
<main class="container">
  <div class="row g-5">
    <div class="col-md-3">
        <?php get_template_part('template/sidebar-left'); ?>
    </div>
    <div class="col-md-6 bg-body-tertiary rounded">
        <div class="col-lg-12 px-0 border-bottom">
            <div class="p-4 text-center bg-body-tertiary rounded-3">
               
                <h1 class="text-body-emphasis">Monthly Archives: <?php echo get_the_date('F Y' ); ?></h1>
              
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
