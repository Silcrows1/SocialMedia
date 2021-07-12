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

        <!--Display all posts-->
        <?php foreach($posts as $post) : ?>
                <div class="col-12 post">
                    <div class="row">
                        <div class="col-1 pic">
                        <img src ="<?php echo base_url('assets/images/'.$post['Picture']);?>" class="profile">
                    </div>
                    
                    <div class="col-11 name">
                        <div class="row-12">
                            <div class="col details">
                            <p><a class="namelink" href="<?php echo base_url('users/viewprofile/'.$post['user_id']); ?>"><?php echo $post['FirstName'].' '.$post['LastName']?></p></a>
                            </div>
                        </div>
                        <div class="row-12">
                            <div class="col details">
                                 <p><?php echo (date("H:i A",strtotime ($post['Posted']))).' on '.(date("jS F Y",strtotime ($post['Posted'])))?></p>
                            </div>
                        </div>
                       
                    </div>    
                    <div class="row">
                        <div class="col-12 content">                            
                            <p><?php echo $post['Content']?></p>                           
                        </div>                   
                    </div>
                    <div class="row interact">
                        <div class="col-6 postinteract">
                        <?php foreach($likes as $entry) : ?> 
                           
                            <?php if($entry['Post_id']['posts']['post_id'] == $post['post_id']) :?>
                                
                                <?php if ($entry['Likes']>0):?>
                                <?php echo $entry['Likes']?> 
                                <?php if($entry['Likes'] <>1  ): echo 'likes';?>
                                <?php elseif($entry['Likes'] =1  ): echo 'like';?>  
                                <?php endif ?>      
                                <?php endif ?>                       

                            <?php endif ?>
                        <?php endforeach; ?>

                        <p><a class="namelink" id ="submit" href="<?php echo base_url('posts/like/'.$post['post_id']); ?>">
                        <?php $likematch = FALSE?>
                        <?php foreach($liked as $like) : ?> 
                            <?php if($like['post_id'] == $post['post_id']) :$likematch = TRUE;?>                            
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php if ($likematch == TRUE){
                            echo "Liked";
                        }
                        else{
                            echo "Like";
                        }?>

                         </p></a>                          
   
                        </div>
                        <div class="col-6 postinteract">                               
                             <p>Comment</p>                           
                        </div>                    
                    </div>
                    
                                    
                </div>
        </div>
            
        <?php endforeach; ?>
         <!--END posts-->               

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