<div class="col-12">
<a class="" href="<?php echo base_url(); ?>users/viewownprofile">Back to Profile</a>
    <div class="row-8">

    <!-- Itterate through requests -->
    <?php foreach($requests as $request) : ?>
            <div class="col-12">
                <div class="row-12 postcard">                
                <p><a class="acontrastlink" href="<?php echo base_url('users/viewprofile/'.$request['Usertwo_id']); ?>"><?php echo $request['FirstName'].' '.$request['LastName']?></p></a>
                
                <!-- If the request wasnt submitted by session holder, show accept and decline options -->
                <?php if ($request['submitted_by'] != $this->session->userdata('user_id')) : ?> 
                <!--accept request-->
                <a class="acontrastlink" href="<?php echo base_url('users/acceptrequest/'.$request['Pending_id']); ?>">Accept</a>

                <!--decline request-->
                <a class="acontrastlink" href="<?php echo base_url('users/declinerequest/'.$request['Usertwo_id']); ?>">Decline</a>
                <?php endif ?>

                <!-- If request was submitted by session holder, show cancel request option -->
                <?php if ($request['submitted_by'] == $this->session->userdata('user_id')) : ?>
                <p>Not yet confirmed</p> 

                 <!--cancel sent request-->
                <a class="acontrastlink" href="<?php echo base_url('users/declinerequest/'.$request['Pending_id']); ?>">Cancel request</a>   
                <?php endif ?>
                </div>
            </div>
            
        <?php endforeach; ?>
        </div>
    </div>
</div>