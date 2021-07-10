<?php foreach($users as $user) : ?>
    <!--Itterate through friends found, if friend found matches User_id set $match to true-->
    <?php $match = FALSE; ?>
    <?php foreach ($friends as $friend) :?>
    <?php if($friend['Usertwo_id']==$user['User_id']): $match = TRUE; ?>
    <?php endif ?>
    <?php endforeach?>

<div class = "col 12 profileContent">
    <div class = "row 12 profileOptions">
        <!--Preventing checking for array that doesnt exist and checking user_id isnt the same as the session holder-->
        <?php if ($match == FALSE && $this->session->userdata['user_id'] != $user['User_id']) : ?>
            <a href="<?php echo base_url('/users/addfriend/'.$user['User_id']); ?>">Add Friend</btn></a>  

        <!--if session userdata doesnt match the userID of the profile, and doesnt match friends show add friend-->
        <?php elseif ($this->session->userdata['user_id'] != $user['User_id'] && $match == FALSE) : ?> 
        <a href="<?php echo base_url('/users/addfriend/'.$user['User_id']); ?>">Add Friend</btn></a>
        <?php endif ?>

        <?php if ($this->session->userdata['user_id'] == $user['User_id']) : ?> 
        <a href="<?php echo base_url('/users/editprofile/'.$user['User_id']); ?>">Edit Profile</btn></a>
        <?php endif ?>
    </div>
    <div class = "row 12">
        <img class="profPic" src="<?php echo base_url('assets/images/'.$user['Picture']);?>" alt="Profile Picture">
    </div>
    <div class = "row 12 profileDetails">
        <p><?php echo $user['FirstName'].' '.$user['LastName'] ?></p>
        <p>Bio: <?php echo $user['Bio'] ?></p>
        <p>Posts:</p>
        <p>Friends (<?php echo count($friends)?>):</p>
    </div>
</div>
<?php endforeach; ?>

<?php foreach($friends as $friend) : ?>
    <div class="col-12">
        <div class="row-12 postcard">                
        <p><?php echo $friend['FirstName'].' '.$friend['LastName'] ?></p>
        </div>
    </div>    
<?php endforeach; ?>

<?php foreach ($errors as $error) : ?>
<?php echo $error; ?>
<?php endforeach; ?>

<?php echo form_open_multipart('upload/do_upload');?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />

</form>
<a href="<?php echo base_url('/users/requests/'); ?>">Friend requests (<?php echo count($requests)?>):</btn></a><br><br>
