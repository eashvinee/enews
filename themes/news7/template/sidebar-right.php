
<div class="position-sticky" style="top: 3rem;">
  <div class="p-4 bg-body-tertiary rounded news7-breaking" >
  <?php
 // Arguments for the related posts query.
            $args = array(
                'post_type'      => 'post', // Query for standard posts
                'tag'        => 'breaking', // Posts that share any of these tags
                'posts_per_page' => 5, // Number of related posts to display
                'orderby'        => 'rand', // Order randomly
                'ignore_sticky_posts' => true, // Don't prioritize sticky posts
            );

            // Create a new WP_Query instance.
            $breaking_query = new WP_Query( $args );


if ( $breaking_query->have_posts() ) : ?>
<h2 class="news7-heading-strike"><span>Breaking</span></h2>
<ul class="breaking-listing">
<?php while ( $breaking_query->have_posts() ) : $breaking_query->the_post(); ?>
    
    <li>
            
            <?php 
            $alert_title = get_post_meta( get_the_ID(), 'alert_title', true );
            $main_title = get_post_meta( get_the_ID(), 'main_title', true );
            ?>
            
                <!--span><?php echo $alert_title; ?> :</span--> 
                <a href="<?php the_permalink(); ?>" class="text-dark">
                    <?php echo $main_title;  ?>
                </a>
           
           
          </li>
       
  
     <?php endwhile; wp_reset_postdata(); ?> </ul>
        
                <?php endif;  ?>
  </div>
  <hr/>
  <div class="p-4 mb-3  rounded news7-footernav">
    <div class="footer-nav ">
      <a href="<?php echo home_url('/about'); ?>" title="About us">About</a>
      <!--a href="<?php echo home_url('/advertising'); ?>" title="Terms of Use">Advertising </a-->
      <a href="<?php echo home_url('/legal/terms-of-use'); ?>" title="Terms of Use">Terms of Use </a>
      <a href="<?php echo home_url('/legal/cookie-policy'); ?>" title="Cookie Policy">Cookie Policy</a>
      <a href="<?php echo home_url('/legal/privacy-policy'); ?>" title="Privacy Policy">Privacy Policy</a>
    </div>
    <div class="copy mt-2">eNews7  Media © <?php echo date('Y'); ?> </div>
  </div>  


</div>
      
      