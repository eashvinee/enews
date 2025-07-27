<div class="wrap">
    <h1>Sales Leads<a class="button" href="?page=sales-leads&action=add">Add Sales Lead</a></h1>
    <p>This page serves as your central hub for listing all your sales leads. 
        It presents a comprehensive, organized view of every potential client or opportunity you're tracking. 
        Here, you can quickly scan and review your entire lead database, providing an essential overview of your sales pipeline. 
        This streamlined listing enables efficient lead management, allowing you to easily identify, prioritize, and access the information needed to drive your sales efforts forward.</p>
    <table  class="widefat striped" >
    <thead>
        <tr>
            <th>ID</th>
            <th>Sales Lead</th>
            <th>Phone Number</th>
            <th>Email Address</th>
            <th>Status</th>
            <th>Created Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
      <?php 

         foreach($leads as $lead_id): 
            ?>

            <tr>
                <td><?php echo $lead_id; ?></td>
                <td><?php echo get_post_meta($lead_id, 'contact_person', true); ?></a></td>
                <td><?php echo get_post_meta($lead_id, 'phone_number', true); ?></td>
                <td><?php echo get_post_meta($lead_id, 'email_address', true); ?></td>
                <td><?php echo get_post_meta($lead_id, 'status', true); ?></td>
                <td><?php echo get_post_meta($lead_id, 'created_date', true); ?></td>
                <td>
                    <a href="<?php echo admin_url("admin.php?page=sales-leads&action=edit&id=".$lead_id); ?>" title="edit"><span class="dashicons dashicons-edit"></span></a> 
                    <a href="<?php echo admin_url("admin.php?page=sales-leads-follow-up&action=single&lead=".$lead_id); ?>" title="follow up"><span class="dashicons dashicons-share-alt"></span></a>
                    <a href="#" style="color:#aaa;" title="trash"><span class="dashicons dashicons-trash"></span></a></a>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

