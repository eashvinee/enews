<div class="wrap">
    <h1>Sales Leads Follow Up <a class="button" href="?page=sales-leads-follow-up&action=add">Add Follow Up</a></h1>
    <p>This page offers a concise overview of sales leads, prioritizing efficiency by showcasing only those with the latest follow-up activities. 
        Instead of sifting through every interaction, users can instantly identify leads that have been most recently contacted or updated. 
        This focus helps sales teams and individuals quickly ascertain who requires immediate attention or where current efforts are concentrated. 
        It's designed to streamline lead management, enabling users to efficiently track recent engagements and determine next steps without unnecessary data clutter, 
        ultimately boosting productivity and ensuring no hot lead is overlooked due to stale information.</p>
  
  <table  class="widefat striped" >
    <thead>
        <tr>
            <th colspan="5" style="border-right:1px solid #ddd; text-align:center;">Sales Lead</th>
            <th colspan="4"  style="text-align:center;">Follow Up</th>
        </tr>
        <tr>
            <th>ID</th>
            <th>Sales Lead</th>
            <th>Phone Number</th>
            <th>Email Address</th>
            <th>Status</th>
            <th>Latest</th>
            <th>Next</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
      <?php 

         foreach($leads as $lead_id): 

            $args = array(
                'number' => 1,
                'post_id' => $lead_id,
                'type'    => 'followup',
                'fields'  => 'ids'
            );

            $recent_comments = get_comments($args);

            $comment_id=(isset($recent_comments[0])) ? $recent_comments[0] : false;
            //print_r($comment_id);
            ?>

            <tr>
                <td><?php echo $lead_id; ?></td>
                <td><?php echo get_post_meta($lead_id, 'contact_person', true); ?></a></td>
                <td><?php echo get_post_meta($lead_id, 'phone_number', true); ?></td>
                <td><?php echo get_post_meta($lead_id, 'email_address', true); ?></td>
                <td><?php echo get_post_meta($lead_id, 'status', true); ?></td>
            <?php if($comment_id): ?>
            
                <td><a title="view follow up" href="<?php echo admin_url("admin.php?page=sales-leads-follow-up&action=single&lead=".$lead_id.'#'.$comment_id); ?>"><?php echo get_comment_meta( $comment_id, 'follow_up_date', true ); ?></td>
                <td><a title="add follow up" href="<?php echo admin_url("admin.php?page=sales-leads-follow-up&action=add&id=".$lead_id); ?>"><?php echo get_comment_meta( $comment_id, 'next_follow_up_date', true ); ?></a></td>
                <td><?php echo get_comment_meta( $comment_id, 'status', true ); ?></td>
                <td>
                    <a href="<?php echo admin_url("admin.php?page=sales-leads-follow-up&action=&action=single&lead=".$lead_id.'#'.$comment_id); ?>" title="follow up"><span class="dashicons dashicons-share-alt"></span></a>
                    <a href="<?php echo admin_url("admin.php?page=sales-leads-follow-up&action=&action=add&id=".$lead_id); ?>" title="add new follow up"><span class="dashicons dashicons-insert"></span></a>
                </td>
                
                
                <?php else: ?>
                    <td colspan="3">No follow up.</td>
                    <td>
                        <a href="<?php echo admin_url("admin.php?page=sales-leads-follow-up&action=&action=add&id=".$lead_id); ?>" title="add new follow up"><span class="dashicons dashicons-insert"></span></a>
                    </td>
                <?php endif; ?>

            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>