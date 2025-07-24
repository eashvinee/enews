<?php get_header(); ?>
<main class="container">
  <div class="row g-5">
    <div class="col-md-3">
        <?php get_template_part('template/sidebar-left'); ?>
    </div>
    <div class="col-md-6 bg-body-tertiary rounded">
        <?php get_template_part('template/content-single'); ?>
    </div>

    <div class="col-md-3">
      <?php get_template_part('template/sidebar-right'); ?>
    </div>
  </div>
</main>
<?php get_footer();
