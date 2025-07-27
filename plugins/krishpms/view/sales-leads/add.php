
<div class="wrap">
    <h1>Sales leads <a class="button" href="?page=sales-leads">Back to sales leads</a></h1>
    <p>This page is where you add your new sales leads. 
        It's designed to make the initial capture of potential clients straightforward, ensuring no valuable opportunity is missed. 
        Here, you'll input all the essential details about a new prospect, from their contact information to any initial notes or sources.
         This crucial step lays the groundwork for all future engagement, populating your sales pipeline and enabling your team to begin the nurturing process effectively.</p>

         <div class="krish-wrap">

    <div class="container">
        <fieldset class="krish-fieldset">
            <legend class="krish-legend">
                <h3> New Sales Lead</h3>
            </legend>

        <form method="post" enctype="multipart/form-data">
            <?php wp_nonce_field( 'sales_lead_add_nonce', 'sales_lead_add_nonce_field' ); ?>
            <input type="hidden" name="sales_lead_action" value="add" />
             <div class="row">
                <!-- Lead ID Field -->
                <div class="col-md-12">
                    <label for="contact_person">Contact Person*:</label>
                    <input type="text" id="contact_person" name="contact_person" placeholder="Enter name of contact person" required
                        class="rounded-lg ">
                    <p class="text-sm ">Full name of the primary contact.</p>
                </div>
            </div>
             <div class="row">
                <!-- Follow Up Date Field -->
                <div class="col-md-6">
                    <label for="phone_number">Phone Number*:</label>
                    <input type="text" id="phone_number" name="phone_number" required
                        class="rounded-lg ">
                    <p class="text-sm ">Primary contact phone number.</p>
                </div>
 <!-- Follow Up Date Field -->
                <div class="col-md-6">
                    <label for="email_address">Email Address*:</label>
                    <input type="text" id="email_address" name="email_address" required
                        class="rounded-lg ">
                    <p class="text-sm ">Primary contact email address.</p>
                </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                    <label for="created_date">Created Date*:</label>
                    <input type="date" id="created_date" name="created_date" class="rounded-lg " required>
                    <p class="text-sm ">This is the date the lead was created.</p>
                </div>

                 <!-- Mode Field -->
            <div class="col-md-6">
                <label for="source">Source*:</label>
                <input type="text" id="source" name="source" required class="rounded-lg ">
                <p class="text-sm ">Where did this lead come from (e.g., website, referral, cold call)?</p>
            </div>
            </div>
             <div class="row">
                <!-- Lead ID Field -->
                <div class="col-md-12">
                    <label for="company_name">Company Name*:</label>
                    <input type="text" id="company_name" name="company_name" placeholder="Enter company name name" required
                        class="rounded-lg col-md-12">
                    <p class="text-sm ">Name of the company.</p>
                </div>
            </div>

            <div class="row">
                <!-- Notes Field -->
                <div class="col-md-12">
                    <label for="notes">Notes:</label>
                    <textarea id="notes" name="notes" rows="5" placeholder="Enter notes about the sales lead"
                            class="col-md-12"></textarea>
                    <p class="text-sm ">Detailed description of the sales lead.</p>
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
                <!-- Status Field -->
                <div class="col-md-6">
                    <label for="status">Status:</label>
                    <select id="status" name="status" required class="rounded-lg ">
                        <option value="new">New</option>
                        <option value="contacted">Contacted</option>
                        <option value="qualified">Qualified</option>
                        <option value="proposal">Proposal Sent</option>
                        <option value="closed_won">Closed Won</option>
                        <option value="closed_lost">Closed Lost</option>
                    </select>
                    <p class="text-sm ">Current status of this sales lead.</p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit" class="button button-primary">Submit Sales Lead</button>
            </div>
        </form>
        </fieldset>
    </div>
    </div>
</div>