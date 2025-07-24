<?php    // --- Social Media Sharing Buttons ---
        $post_url = get_the_permalink();
         $alert_title = get_post_meta( get_the_ID(), 'alert_title', true );
            $main_title = get_post_meta( get_the_ID(), 'main_title', true );
        $post_title =$alert_title.': '.$main_title; //get_the_title();
        $encoded_url = urlencode( $post_url );
        $encoded_title = urlencode( $post_title );
        $encoded_text_for_whatsapp = urlencode( $post_title . ' ' . $post_url ); // WhatsApp combines text and URL

        // WhatsApp Share URL
        $whatsapp_share_url = 'https://api.whatsapp.com/send?text=' . $encoded_text_for_whatsapp;

        // Facebook Share URL
        $facebook_share_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $encoded_url;

        // X (Twitter) Share URL
        $x_share_url = 'https://twitter.com/intent/tweet?text=' . $encoded_title . '&url=' . $encoded_url;
        ?>
        <div class="d-inline">
            <a href="<?php echo $facebook_share_url; ?>" target="_blank"><svg class="bi mx-auto" width="24" height="18"><use xlink:href="#news7-facebook"></use></svg></a>
            <a href="<?php echo $x_share_url; ?>" target="_blank"><svg class="bi mx-auto" width="24" height="18"><use xlink:href="#news7-twitter"></use></svg>
            <a href="<?php echo $whatsapp_share_url; ?>" target="_blank"><svg class="bi mx-auto" width="24" height="18"><use xlink:href="#news7-whatsapp"></use></svg></a>
        </div>