<div class="position-sticky" style="top: 3rem;">

    <div class="p-4 mb-3 bg-body-tertiary rounded sidebar-menu">
    <?php       $terms = get_terms( 'category',['hide_empty'=> 0 ]);
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ):
        ?>

    <ul class="nav nav-pills flex-column mb-auto">
    <?php	foreach ( $terms as $term ):
            ?>
            <li class="nav-item">
                <a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="nav-link fw-bolder text-secondary">
                <?php 
                $icon_url = get_term_meta( $term->term_id, 'category_icon_url', true ); ?>
                <img src="<?php echo esc_url( $icon_url ); ?>" alt="<?php echo  esc_attr( $term->name ); ?>" class="category-icon" />
                <?php echo $term->name; ?>
                </a>
            </li>
            <?php  endforeach; ?>
        </ul>
    <?php  endif;  ?>
    </div>

    <!--div class="p-4 mb-3 bg-body-tertiary rounded">
            <ul class="footer-nav flex ">
              <li><a href="#" title="Terms of Use">Advertise with Us </a></li>
              <li><a href="#" title="Terms of Use">Terms of Use </a></li>
              <li><a href="#" title="Cookie Policy">Cookie Policy</a></li>
              <li><a href="#" title="Privacy Policy">Privacy Policy</a></li>
            </ul>
            <div class="copy">© 2022 - <?php echo date('Y'); ?> eNews7</div>
        </div-->  
      </div>