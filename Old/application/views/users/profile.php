<?php foreach($users as $user) : ?>
<div class = "col 12">

<?php if ($this->session->userdata['user_id'] != $user['User_id']) : ?> 
<a href="<?php echo base_url(('/users/addfriend/'.$user['User_id'])); ?>">Add Friend</btn></a><br><br>
<?php endif ?>


<a href="<?php echo base_url(('/users/editprofile/'.$user['User_id'])); ?>">Edit Profile</btn></a><br><br>
<p><?php echo $user['FirstName'].' '.$user['LastName'] ?></p>
<p>Bio: <?php echo $user['Bio'] ?></p>
<p>Posts:</p>
</div>
<?php endforeach; ?>
<p>Friends (<?php echo count($friends)?>):</p>
<?php foreach($friends as $friend) : ?>
    <div class="col-12">
                <div class="row-12 postcard">                
                <p><?php echo $friend['FirstName'].' '.$friend['LastName'] ?></p>
                </div>
            </div>
    
<?php endforeach; ?>
<a href="<?php echo base_url('/users/requests/'); ?>">Friend requests (<?php echo count($requests)?>):</btn></a><br><br>
