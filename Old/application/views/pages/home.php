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
<body>
    <div class="row-12 background">
        <!-- dynamic divs depending on font size -->
        <div class="<?php echo $col ?> foreback">
            <div class="col-12 mainfeed">
                <div class="mainfeeds">
                    <!-- Create post form -->
                        <?php echo form_open('posts/createPost'); ?>
                        <div class="form-row">
                            <div class="col">
                                <textarea type="text" name="postContent" class="form-control" rows="3" placeholder="Post"></textarea>
                                <button type="submit" class="createPost btn btn-primary">Post</button>
                            </div>
                        </div>
                        <br>
                        <br>
                        <?php echo form_close(); ?>

                        <!-- Append each post -->
                        <?php foreach ($posts as $post) : ?>
                            <div class="col-12 post">
                                <div class="posttop">
                                    <div class="row g-0">
                                        <div class="wrap col-1 col-md-1 col-lg-1 pic">
                                            <img src="<?php echo base_url('assets/images/' . $post['Picture']); ?>" class="profile" alt="Profile Picture">
                                        </div>
                                        <div class="col-11 col-md-11 col-lg-11 name postdetails">
                                            <div class="row-12">
                                                <div class="col-9 details">
                                                    <p><a class="namelink" href="<?php echo base_url('users/viewprofile/' . $post['user_id']); ?>"><?php echo $post['FirstName'] . ' ' . $post['LastName'] ?></p></a>
                                                    <p class="date"><?php echo (date("H:i A", strtotime($post['Posted']))) . ' on ' . (date("jS F Y", strtotime($post['Posted']))) ?></p>
                                                </div>
                                            </div>
                                            <?php if ($post['user_id'] == $this->session->userdata('user_id')) : ?>
                                                <a class="deletepost" href="<?php echo base_url('posts/delete/' . $post['post_id']); ?>">X</a>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-0">
                                    <div class="col-12 content">
                                        <p><?php echo $post['Content'] ?></p>
                                    </div>
                                </div>
                                <div class="row interact g-0">
                                    <div class="col-6 postinteracttop" id="<?php echo $post['post_id'] ?>">

                                        <!--Like counter-->
                                        <p><?php foreach ($likes as $entry) : ?>
                                                <!-- Check for number of likes and change wording -->
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

                                    <!-- Append comments -->
                                        <p><?php foreach ($comments as $entry) : ?>
                                            <!-- Check for number of comments and change wording -->
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
                                <div class="row interact g-0">
                                    <div class="col-6 postinteract Likebtn" title="<?php echo $post['post_id'] ?>">
                                        <a id="submit<?php echo $post['post_id'] ?>" href="" title="<?php echo $post['post_id'] ?>">

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
                                    <div class="col-6 postinteract comment" id="<?php echo $post['post_id']; ?>" title="<?php echo $post['post_id']; ?>">
                                        <a class="viewcomment" id="viewcommentid<?php echo $post['post_id']; ?>" title="<?php echo $post['post_id']; ?>">

                                        <!-- If post contains a comment, set text to view comments, otherwise Add Comment -->
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

                                <!-- Add comment section -->
                                <div class="row pt-3 g-0">
                                    <div class="comments<?php echo $post['post_id']; ?>">

                                        <!-- Set as hidden to be changed in footer after view/add comment/s is clicked -->
                                        <div class="form-row hidden" id="viewcomment<?php echo $post['post_id']; ?>" name="comment<?php echo $post['post_id']; ?>">
                                            <div class="col">
                                                <input type="hidden" name="post_Id" value="<?php echo $post['post_id']; ?>">
                                                <textarea type="text" name="addcomment" id="addcomment<?php echo $post['post_id']; ?>" class="form-control" rows="3" placeholder="comment"></textarea>
                                                <button type="button" id="commentsubmit" title="<?php echo $post['post_id'] ?>" class="commentsubmit createPost btn btn-primary">Post</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Div to append comments to -->
                                    <div class="viewcomments<?php echo $post['post_id']; ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- View friends popup -->
        <div id="wrapper friends col-md-12">
            <div id="friendfind" class="minimize viewfriends"><a class="viewfriends" id="friendfind">View Friends</a>
                <div class="line"></div>

                <!-- UL to append friends to -->
                <ul class="friendList" id="friendList">
                </ul>
            </div>
        </div>
    </div>

    <!-- Popup used for when a volunteer makes contact -->
    <div id="myModal" title="" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 class="adminpop text-center">A volunteer wishes to talk with you, press accept to join the conversation or click off to close</h2>
        </div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script>
    // Get the popup
    var modal = document.getElementById("myModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";

        //emit admincancelled if user clicks to close
        socket.emit("admincancelled", {
            userId: <?php echo $this->session->userdata('user_id') ?>,
            recieverId: document.getElementById('myModal').title,
        });
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";

             //emit admincancelled if user clicks to close
            socket.emit("admincancelled", {
                userId: <?php echo $this->session->userdata('user_id') ?>,
                recieverId: document.getElementById('myModal').title,
            });
        }
    }
</script>