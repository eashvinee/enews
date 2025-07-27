
<div class="wrap krish-wrap">
    <h1><?php _e( 'Sales Leads -  Follow Up', 'krishpms' ); ?></h1>
    <p><?php _e( 'This page is for managing follow-up actions for your sales leads.', 'krishpms' ); ?></p>


    <div class="container">
        <fieldset class="krish-fieldset">
            <legend class="krish-legend">
                <h3> New Follow Up</h3>
            </legend>

        <form action="#" method="POST">
             <div class="row">
                <!-- Lead ID Field -->
                <div class="col-md-12">
                    <label for="lead_id">Lead ID (FK):</label>
                    <input type="number" id="lead_id" name="lead_id" placeholder="Enter Lead ID" required
                        class="rounded-lg ">
                    <p class="text-sm ">Numerical ID linking to the Sales Lead.</p>
                </div>
            </div>
             <div class="row">
                <!-- Follow Up Date Field -->
                <div class="col-md-6">
                    <label for="follow_up_date">Follow Up Date:</label>
                    <input type="date" id="follow_up_date" name="follow_up_date" required
                        class="rounded-lg ">
                    <p class="text-sm ">Date when the follow-up occurred or is scheduled.</p>
                </div>

                 <!-- Mode Field -->
            <div class="col-md-6">
                <label for="mode">Mode:</label>
                <select id="mode" name="mode" required
                        class="rounded-lg ">
                    <option value="">Select Mode</option>
                    <option value="call">Call</option>
                    <option value="email">Email</option>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="meeting">Meeting</option>
                    <option value="other">Other</option>
                </select>
                <p class="text-sm ">How the follow-up was conducted.</p>
            </div>
            </div>

            <div class="row">
                <!-- Notes Field -->
                <div class="col-md-12">
                    <label for="notes">Notes:</label>
                    <textarea id="notes" name="notes" rows="5" placeholder="Enter notes about the follow-up"
                            class="col-md-12"></textarea>
                    <p class="text-sm ">Detailed description of the follow-up interaction.</p>
                </div>
            </div>

            <div class="row">
                <!-- Status Field -->
                <div class="col-md-12">
                    <label for="status">Attachments:</label>
                    <input type="file" name="attachment" />
                    <p class="text-sm ">Upload files such as PDF, email, DOC.</p>
                </div>
            </div>
            <div class="row">

            <!-- Next Follow Up Date Field -->
            <div class="col-md-6">
                <label for="next_follow_up_date">Next Follow Up Date:</label>
                <input type="date" id="next_follow_up_date" name="next_follow_up_date"
                       class="rounded-lg ">
                <p class="text-sm ">Date for the next scheduled follow-up (optional).</p>
            </div>

            <!-- Status Field -->
            <div class="col-md-6">
                <label for="status">Status:</label>
                <select id="status" name="status" required
                        class="rounded-lg ">
                    <option value="">Select Status</option>
                    <option value="rescheduled">Rescheduled</option>
                    <option value="done">Done</option>
                </select>
                <p class="text-sm ">Current status of this follow-up event.</p>
            </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit" class="button button-primary">Submit Follow Up</button>
            </div>
        </form>
        </fieldset>
    </div>
    <!--div class="card">
        <h2><?php _e( 'Upcoming Follow-ups', 'krishpms' ); ?></h2>
        <p><?php _e( 'You can display a list of leads requiring follow-up here, perhaps based on their status or a custom "next follow-up date" field.', 'krishpms' ); ?></p>
        <ul>
            <li><?php _e( 'Lead: John Doe (New)', 'krishpms' ); ?></li>
            <li><?php _e( 'Lead: Acme Corp (Contacted)', 'krishpms' ); ?></li>
            <li><?php _e( 'Lead: Jane Smith (Proposal Sent)', 'krishpms' ); ?></li>
        </ul>
        <p class="description"><?php _e( 'This section can be dynamically populated with actual lead data.', 'krishpms' ); ?></p>
    </div>

    <div class="card mt-4">
        <h2><?php _e( 'Follow Up Settings', 'krishpms' ); ?></h2>
        <p><?php _e( 'Add settings related to follow-up processes, e.g., default follow-up intervals, notification preferences.', 'krishpms' ); ?></p>
        <form method="post" action="">
            <label for="follow_up_interval"><?php _e( 'Default Follow-up Interval (days):', 'krishpms' ); ?></label>
            <input type="number" id="follow_up_interval" name="follow_up_interval" value="7" min="1" />
            <p class="description"><?php _e( 'Number of days before a lead needs a follow-up.', 'krishpms' ); ?></p>
            <p class="submit">
                <input type="submit" name="submit_follow_up_settings" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Settings', 'krishpms' ); ?>" />
            </p>
        </form>
    </div-->
</div>