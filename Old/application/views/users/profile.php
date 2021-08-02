<?php if (!$this->session->userdata('logged_in')) {
    redirect('Home');
} ?>
<div class="body">

    <?php foreach ($users as $user) : ?>
        <!--Itterate through friends found, if friend found matches User_id set $match to true-->
        <!--Preventing checking for array that doesnt exist-->
        <?php $match = FALSE; ?>
        <?php foreach ($friends as $friend) : ?>
            <?php if ($friend['Usertwo_id'] == $this->session->userdata['user_id']) : $match = TRUE; ?>
            <?php endif ?>
        <?php endforeach ?>

        <div class="col 12 profileContent">
            <div class="row 12 profileOptions">
                <!--Checking user_id isnt the same as the session holder and that users are not friends-->
                <?php if ($match == FALSE && $this->session->userdata['user_id'] != $user['User_id']) : ?>
                    <a href="<?php echo base_url('/users/addfriend/' . $user['User_id']); ?>">Add Friend</btn></a>
                <?php endif ?>
                <!--Show edit profile button if session user_id matches the profile User_id-->
                <?php if ($this->session->userdata['user_id'] == $user['User_id']) : ?>
                    <a href="<?php echo base_url('/users/editprofile/' . $user['User_id']); ?>">Edit Profile</btn></a>
                <?php endif ?>
            </div>
            <!--Profile Information-->
            <?php if ($match == TRUE && $this->session->userdata['user_id'] != $user['User_id']) : ?>
                <a class="removeFriend" id="removeFriend">Remove friend</a>
            <?php endif ?>
            <div class="row removeconfirm hidden" id="confirmremove">
                <div class="col">
                    Are you sure you wish to remove this friend?
                    <button class="confirmedremove" id="<?php echo $user['User_id']?>">Confirm</button>
                </div>
            </div>
            <div class="row-12">
            <!--If profile is of a friend, and not own profile, show remove friend button-->            
                <img class="profPic" src="<?php echo base_url('assets/images/' . $user['Picture']); ?>" alt="Profile Picture">
            </div>
            <div class="row 12 profileDetails">
                <p><?php echo $user['FirstName'] . ' ' . $user['LastName'] ?></p>
                <p>Bio: <?php echo $user['Bio'] ?></p>
                <p>Posts:</p>

                <!--Display all posts-->
                <?php foreach ($posts as $post) : ?>

                    <div class="col-12 post">
                        <div class="row">
                            <div class="col-1 pic">

                                <img src="<?php echo base_url('assets/images/' . $post['Picture']); ?>" class="profile">
                            </div>

                            <div class="col-11 name">
                                <div class="row-12">
                                    <div class="col details">
                                        <p><a class="namelink" href="<?php echo base_url('users/viewprofile/' . $post['user_id']); ?>"><?php echo $post['FirstName'] . ' ' . $post['LastName'] ?></p></a>
                                    </div>
                                </div>
                                <div class="row-12">
                                    <div class="col details">
                                        <p><?php echo (date("H:i A", strtotime($post['Posted']))) . ' on ' . (date("jS F Y", strtotime($post['Posted']))) ?></p>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12 content">
                                    <p><?php echo $post['Content'] ?></p>
                                </div>
                            </div>
                            <div class="row interact">
                                <div class="col-6 postinteracttop" id="<?php echo $post['post_id'] ?>">
                                    <!--------------------LIKES COUNT HERE---------------------->
                                    <p><?php foreach ($likes as $entry) : ?>
                                            <?php if ($entry['Post_id'] == $post['post_id']) : ?>
                                                <?php if ($entry['Likes'] > 0) : echo $entry['Likes'] ?>
                                                    <?php if ($entry['Likes'] <> 1) : echo 'likes'; ?>
                                                    <?php elseif ($entry['Likes'] = 1) : echo 'like'; ?>
                                                    <?php endif ?>
                                                <?php endif ?>

                                            <?php endif ?>
                                        <?php endforeach; ?>
                                    </p>
                                </div>
                                <div class="col-6 postinteracttop" id="comment<?php echo $post['post_id'] ?>">
                                    <p><?php foreach ($comments as $entry) : ?>
                                            <?php if ($entry['Post_id'] == $post['post_id']) : ?>
                                                <?php if ($entry['Comments'] > 0) : echo $entry['Comments'] ?>
                                                    <?php if ($entry['Comments'] <> 1) : echo 'Comments'; ?>
                                                    <?php elseif ($entry['Comments'] = 1) : echo 'Comments'; ?>
                                                    <?php endif ?>
                                                <?php endif ?>

                                            <?php endif ?>
                                        <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="row interact">

                                <div class="col-6 postinteract">
                                    <a class="Likebtn" id="submit<?php echo $post['post_id'] ?>" href="" title="<?php echo $post['post_id'] ?>" data-elemid="">
                                        <?php $match = FALSE ?>
                                        <?php foreach ($liked as $like) : ?>
                                            <?php if ($like['post_id'] == $post['post_id']) : $match = TRUE; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php if ($match == TRUE) {
                                            echo "You liked this";
                                        } else {
                                            echo "Like";
                                        } ?>
                                    </a>

                                </div>
                                <div class="col-6 postinteract " id="<?php echo $post['post_id']; ?>">
                                    <a class="viewcomment" id="viewcomment<?php echo $post['post_id']; ?>" title="<?php echo $post['post_id']; ?>">
                                        <?php foreach ($comments as $entry) : ?>
                                            <?php if ($entry['Post_id'] == $post['post_id']) : ?>
                                                <?php if ($entry['Comments'] == 0) : echo 'Add Comment'; ?>
                                                <?php else : echo 'View Comments'; ?>
                                                <?php endif ?>
                                            <?php endif ?>
                                        <?php endforeach; ?>
                                    </a>
                                </div>
                            </div>
                            <!-- ADD COMMENT SECTION-->
                            <div class="row">
                                <div class="comments<?php echo $post['post_id']; ?>">

                                    <div class="form-row hidden" id="viewcomment<?php echo $post['post_id']; ?>" name="comment<?php echo $post['post_id']; ?>">
                                        <div class="col">
                                            <input type="hidden" name="post_Id" value="<?php echo $post['post_id']; ?>">
                                            <textarea type="text" name="addcomment" id="addcomment<?php echo $post['post_id']; ?>" class="form-control" rows="3" placeholder="comment"></textarea>
                                            <button type="button" id="commentsubmit" title="<?php echo $post['post_id'] ?>" class="commentsubmit createPost btn btn-primary">Post</button>
                                        </div>
                                    </div>

                                </div>
                                <div class="viewcomments<?php echo $post['post_id']; ?>">


                                </div>

                            </div>


                        </div>
                    </div>


                <?php endforeach; ?>
                <!--END posts-->

                <p>Friends (<?php echo count($friends) ?>):</p>
            </div>
            <!--Show friends if user matches as a friend or if profile is session holders-->
            <?php if ($match == TRUE || $this->session->userdata['user_id'] == $user['User_id']) : ?>
                <div class="col-12">
                    <div class="row-12">
                        <!--Append friend information-->
                        <?php foreach ($friends as $friend) : ?>
                            <a href="<?php echo base_url('/users/viewprofile/' . $friend['Usertwo_id']); ?>">
                                <div class="col-2 profileFriends">
                                    <img class="profPic" src="<?php echo base_url('assets/images/' . $friend['Picture']); ?>" alt="Profile Picture">
                                    <p><?php echo $friend['FirstName'] . ' ' . $friend['LastName'] ?></p>
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
        <?php echo form_open_multipart('upload/do_upload'); ?>
        <input type="file" name="userfile" size="20" />
        <br /><br />
        <input type="submit" value="upload" />
        </form>
        <a href="<?php echo base_url('/users/requests/'); ?>">Friend requests (<?php echo count($requests) ?>):</btn></a><br><br>
    <?php endif ?>