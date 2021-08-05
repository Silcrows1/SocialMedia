<!-- alter div sizes to account for font size-->
<?php $font = $this->session->userdata('TextSize');
if ($font == '1') {
    $col = "col-lg-8 col-md-8 col-md-10 col-12";
}
if ($font == '2') {
    $col = "col-lg-8 col-md-8 col-md-10 col-12";
}
if ($font == '3') {
    $col = "col-lg-10 col-md-10 col-12";
} ?>


<?php if (!$this->session->userdata('logged_in')) {
    redirect('Home');
} ?>
<div class="body">
    <div class="row-12 background">
        <div class="<?php echo $col ?> foreback">
            <?php foreach ($users as $user) : ?>
                <!--Itterate through friends found, if friend found matches User_id set $match to true-->
                <!--Preventing checking for array that doesnt exist-->
                <?php $match = FALSE; ?>
                <?php foreach ($friends as $friend) : ?>
                    <?php if ($friend['Usertwo_id'] == $this->session->userdata['user_id']) : $match = TRUE; ?>
                    <?php endif ?>
                <?php endforeach ?>

                <div class="col 12 profileContent">
                    <!-- Add dark square for profile -->
                    <div class="col profilemain">
                        <div class="row 12 profileOptions">
                            <?php if ($match == FALSE && $this->session->userdata['user_id'] != $user['User_id']) : ?>
                                <a href="<?php echo base_url('/users/addfriend/' . $user['User_id']); ?>">Add Friend</btn></a>
                            <?php endif ?>
                            <!--Show edit profile button if session user_id matches the profile User_id-->
                            <?php if ($this->session->userdata['user_id'] == $user['User_id']) : ?>
                                <a href="<?php echo base_url('/users/editprofile/' . $user['User_id']); ?>">Edit Profile</btn></a>
                            <?php endif ?>
                        </div>
                        <!--Profile Information-->
                        <!--If profile is of a friend, and not own profile, show remove friend button-->
                        <?php if ($match == TRUE && $this->session->userdata['user_id'] != $user['User_id']) : ?>
                            <a class="removeFriend" id="removeFriend">Remove friend</a>
                        <?php endif ?>
                        <div class="row removeconfirm hidden" id="confirmremove">
                            <div class="col">
                                Are you sure you wish to remove this friend?
                                <button class="confirmedremove" id="<?php echo $user['User_id'] ?>">Confirm</button>
                            </div>
                        </div>
                        <h1><?php echo $user['FirstName'] . ' ' . $user['LastName'] ?><br></h1>
                        <!--Checking user_id isnt the same as the session holder and that users are not friends-->

                        <div class="row-12">
                            <div class="col-2 propic">
                                <img class="profPicaccount" src="<?php echo base_url('assets/images/' . $user['Picture']); ?>" alt="Profile Picture">

                            </div>
                        </div>
                        <div class="row 12 profileDetails">
                            <p>Bio: <?php echo $user['Bio'] ?><br><br></p>
                        </div>


                        <!--Show upload profile picture and friend requests if session user_id matches the profile User_id-->
                        <?php if ($this->session->userdata['user_id'] == $user['User_id']) : ?>

                            <a href="<?php echo base_url('/users/requests/'); ?>">Friend requests (<?php echo count($requests) ?>)<br><br></btn></a>
                        <?php endif ?>
                        <p>Friends (<?php echo count($friends) ?>):</p>
                        <div class="col-12">
                            <!--Show friends if user matches as a friend or if profile is session holders-->
                            <?php if ($match == TRUE || $this->session->userdata['user_id'] == $user['User_id']) : ?>
                                <div class="row-12 flex">
                                    <!--Append friend information-->
                                    <?php foreach ($friends as $friend) : ?>
                                        <div class="col-2">
                                            <a href="<?php echo base_url('/users/viewprofile/' . $friend['Usertwo_id']); ?>">
                                                <div class="col-12 profileFriends"><img class="profPicfriend" src="<?php echo base_url('assets/images/' . $friend['Picture']); ?>" alt="Profile Picture">
                                                    <p><?php echo $friend['FirstName'] . ' ' . $friend['LastName'] ?></p>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                    <?php if ($match == TRUE || $this->session->userdata['user_id'] == $user['User_id']) : ?>
                        <!--Display all posts-->
                        <?php foreach ($posts as $post) : ?>

                            <div class="col-12 post">
                                <div class="row g-0">
                                    <div class="wrap col-2 col-md-2 col-lg-1 pic">
                                        <img src="<?php echo base_url('assets/images/' . $post['Picture']); ?>" class="profile">
                                    </div>
                                    <div class="col-10 col-md-10 col-lg-11 name">
                                        <div class="row-12">
                                            <div class="col-9 details">
                                                <p><a class="namelink" href="<?php echo base_url('users/viewprofile/' . $post['user_id']); ?>"><?php echo $post['FirstName'] . ' ' . $post['LastName'] ?></p></a>
                                                <p><?php echo (date("H:i A", strtotime($post['Posted']))) . ' on ' . (date("jS F Y", strtotime($post['Posted']))) ?></p>
                                            </div>
                                        </div>
                                        <?php if ($post['user_id'] == $this->session->userdata('user_id')) : ?>
                                            <a class="delete" href="<?php echo base_url('posts/delete/' . $post['post_id']); ?>">X</a>
                                        <?php endif ?>
                                    </div>
                                    <div class="row g-0">
                                        <div class="col-12 content">
                                            <p><?php echo $post['Content'] ?></p>
                                        </div>
                                    </div>
                                    <div class="row interact g-0">
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
                                                <?php endforeach; ?></p>
                                        </div>
                                    </div>
                                    <div class="row interact g-0">

                                        <div class="col-6 postinteract">
                                            <a class="Likebtn" id="submit<?php echo $post['post_id'] ?>" href="" title="<?php echo $post['post_id'] ?>">
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
                                            <a class="viewcomment" id="viewcommentid<?php echo $post['post_id']; ?>" title="<?php echo $post['post_id']; ?>">
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
                                    <div class="row g-0">
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
                    <?php endif ?>
                    <!--END posts-->
                </div>
            <?php endforeach; ?>
            <!-- End users -->
        </div>
    </div>
</div>