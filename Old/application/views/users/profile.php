<?php foreach($users as $user) : ?>

    <!--Itterate through friends found, if friend found matches User_id set $match to true-->
    <!--Preventing checking for array that doesnt exist-->
    <?php $match = FALSE; ?>
    <?php foreach ($friends as $friend) :?>
    <?php if($friend['Usertwo_id']==$this->session->userdata['user_id']): $match = TRUE; ?>
    <?php endif ?>
    <?php endforeach?>

<div class = "col 12 profileContent">
    <div class = "row 12 profileOptions">
        <!--Checking user_id isnt the same as the session holder and that users are not friends-->
        <?php if ($match == FALSE && $this->session->userdata['user_id'] != $user['User_id']) : ?>
            <a href="<?php echo base_url('/users/addfriend/'.$user['User_id']); ?>">Add Friend</btn></a>  
        <?php endif ?>
        <!--Show edit profile button if session user_id matches the profile User_id-->
        <?php if ($this->session->userdata['user_id'] == $user['User_id']) : ?> 
        <a href="<?php echo base_url('/users/editprofile/'.$user['User_id']); ?>">Edit Profile</btn></a>
        <?php endif ?>
    </div>
    <!--Profile Information-->
    <div class = "row 12">
        <img class="profPic" src="<?php echo base_url('assets/images/'.$user['Picture']);?>" alt="Profile Picture">
    </div>
    <div class = "row 12 profileDetails">
        <p><?php echo $user['FirstName'].' '.$user['LastName'] ?></p>
        <p>Bio: <?php echo $user['Bio'] ?></p>
        <p>Posts:</p>
        <p>Friends (<?php echo count($friends)?>):</p>
    </div>
    <!--Show friends if user matches as a friend or if profile is session holders-->
    <?php if($match == TRUE || $this->session->userdata['user_id'] == $user['User_id']) : ?>
    <div class="col-12">
        <div class="row-12"> 
            <!--Append friend information-->
        <?php foreach($friends as $friend) : ?>
            <a href="<?php echo base_url('/users/viewprofile/'.$friend['Usertwo_id']); ?>">      
            <div class="col-2 profileFriends"> 
            <img class="profPic" src="<?php echo base_url('assets/images/'.$friend['Picture']);?>" alt="Profile Picture">              
            <p><?php echo $friend['FirstName'].' '.$friend['LastName'] ?></p>
            </a>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif ?>

</div>

<?php endforeach; ?>

 <!--Show upload profile picture and friend requests if session user_id matches the profile User_id-->  
<?php if ($this->session->userdata['user_id'] == $user['User_id']) : ?>
<?php foreach ($errors as $error) : ?>
<?php echo $error; ?>
<?php endforeach; ?>
<?php echo form_open_multipart('upload/do_upload');?>
<input type="file" name="userfile" size="20" />
<br /><br />
<input type="submit" value="upload" />
</form>
<a href="<?php echo base_url('/users/requests/'); ?>">Friend requests (<?php echo count($requests)?>):</btn></a><br><br>
<?php endif ?>