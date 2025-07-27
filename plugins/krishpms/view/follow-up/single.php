<?php

$lead_id=$_GET['lead'];

?><div class="wrap krish-wrap">
    <h1>Sales Leads -  Follow Up</h1>
    <p>This page provides a comprehensive timeline of all follow-up actions for a specific sales lead. It's designed as a complete history, detailing every interaction, communication, and planned next step taken with that particular prospect. By centralizing these records, you gain a clear, chronological view of the entire engagement journey, ensuring you always have the full context needed to effectively manage and progress your sales lead.</p>


    <div class="container">
        <div class="card">
        <h2>Sales Lead: [#<?php echo $lead_id; ?>] <?php echo get_post_meta($lead_id, 'contact_person', true); ?></h2>
        <p class="description"><?php echo get_post_meta($lead_id, 'notes', true); ?></p>
        <ul>
            <li>Phone Number: <?php echo get_post_meta($lead_id, 'phone_number', true); ?></li>
            <li>Email Address: <?php echo get_post_meta($lead_id, 'email_address', true); ?></li>
            <li>Status: <?php echo get_post_meta($lead_id, 'status', true); ?></li>
        </ul>
        
        <!--p class="description"><?php _e( 'This section can be dynamically populated with actual lead data.', 'krishpms' ); ?></p-->
    </div>
        <?php
        
        $comments = get_comments([
            'post_id' => $lead_id,
            'type'    => 'followup',
            'fields'  => 'ids',
        ]);
        
        foreach($comments as $comment_id): ?>
        <fieldset class="krish-fieldset" id="<?php echo $comment_id; ?>">
            <legend class="krish-legend">
                <h3> Follow Up:  #<?php echo $comment_id; ?></h3>
            </legend>
            <div class="row">
                <!-- Notes Field -->
                <div class="col-md-12">
                    <label for="notes">Notes:</label>
                    <p class="text-sm "><?php echo get_comment_meta( $comment_id, 'notes',true ); ?></p>
                </div>
            </div>
            <div class="row">
                <!-- Follow Up Date Field -->
                <div class="col-md-6">
                    <label for="follow_up_date">Follow Up Date:</label>
                    <p class="text-sm "><?php echo get_comment_meta( $comment_id, 'follow_up_date',true ); ?></p>
                </div>
                    <!-- Mode Field -->
                <div class="col-md-6">
                    <label for="mode">Mode:</label>
                    <p class="text-sm "><?php echo get_comment_meta( $comment_id, 'mode',true ); ?></p>
                </div>
            </div>

            <div class="row">

            <!-- Next Follow Up Date Field -->
            <div class="col-md-6">
                <label for="next_follow_up_date">Next Follow Up Date:</label>
                <p class="text-sm "><?php echo get_comment_meta( $comment_id, 'next_follow_up_date',true ); ?></p>
            </div>

            <!-- Status Field -->
            <div class="col-md-6">
                <label for="status">Status:</label>
                <p class="text-sm "><?php echo get_comment_meta( $comment_id, 'status',true ); ?></p>
            </div>
            </div>

            <?php if(get_comment_meta( $comment_id, 'attachment', true )): ?>
            <div class="row">
                <!-- Status Field -->
                <div class="col-md-12">
                    <label for="status">Attachments:</label>
                    <p class="text-sm "><a href="<?php echo get_comment_meta( $comment_id, 'attachment', true ); ?>" target="_blank">Download</a></p>
                </div>
            </div>
            <?php endif; ?>
        </fieldset>
        <?php endforeach; ?>
    </div>
   
</div>

