<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS"); ?>
<script src="https://cdn.socket.io/3.1.3/socket.io.min.js" integrity="sha384-cPwlPLvBTa3sKAgddT6krw0cJat7egBga3DJepJyrLl4Q9/5WLra3rrnMcyTyOnh" crossorigin="anonymous"></script>

<script>
    function sendMessage(e) {
        e.preventDefault();
        var url = "<?php echo base_url(); ?>Messages/sendMessage";


        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: "html",
            data: {
                targetId: <?php echo $friendid; ?>,
                message: document.getElementById("message").value
            },

            success: function(result) {
                if (document.getElementById("message").value != '') {
                    $('<div class="row-12 message"><div class="col pill"><div class="row-12"><p>' + "<?php echo $this->session->userdata('FirstName'); ?>" + " " + "<?php echo $this->session->userdata('LastName'); ?>" + '</p><p>Posted Now</p></div><div class="row"><p>' + document.getElementById("message").value + '</p></div></div></div>').prependTo('.messageboard');
                    $('#message').val('')
                }
            }

        });
        //emit the message sent
        if (document.getElementById("message").value != '') {
            socket.emit("sendMessage", {
                text: document.getElementById("message").value,
                userId: <?php echo $this->session->userdata('user_id') ?>,
                recieverId: <?php echo $friendid; ?>,
            });
        }
    }
    //if user is an admin and uses live chat, prompt the user for admin contact.
    <?php if ($this->session->userdata('UserType') == "Admin") : ?>
        socket.emit("adminContact", {
            userId: <?php echo $this->session->userdata('user_id') ?>,
            recieverId: <?php echo $friendid; ?>,
        });
    <?php endif ?>

    //if cancelled is recieved, append div to alert admin
    socket.on("cancelled", function(data) {
        $('<div class="row-12 message"><div class="col pill right"><div class="row-12"></div><div class="row decline"><p>User did not accept invite</p></div></div></div>').prependTo('.messageboard');
    });

    //if accepted is recieved, append div to alert admin that user has joined
    socket.on("accepted", function(data) {
        $('<div class="row-12 message"><div class="col pill right"><div class="row-12"></div><div class="row accepted"><p>User has joined the chatroom</p></div></div></div>').prependTo('.messageboard');
    });

    //get users request
    socket.on("getUsers", users => {
        console.log(users);
    });

    //getmessage function, append the message.
    socket.on("getMessage", function(data) {

        $('<div class="row-12 message"><div class="col pill right"><div class="row-12"><p>Testnames</p><p>Posted Now</p></div><div class="row"><p>' + data.text + '</p></div></div></div>').prependTo('.messageboard');

    });

    //create timeout variable
    var timeout;

    //on typing recieved, set typing element to block.
    socket.on("typing", function(data) {

        if (document.getElementById("typing").style.display != "block") {
            document.getElementById("typing").style.display = "block";
        } else {

        }
        //clear previous timeout
        clearTimeout(timeout);

        //create new timeout function, after 1500ms, run timeout function.
        timeout = setTimeout(timeoutFunction, 1500);

    });
    //function to hide typing element.
    function timeoutFunction() {
        document.getElementById("typing").style.display = "none";
    }
</script>

<body>
    <?php if (!$this->session->userdata('logged_in')) {
        redirect("users/login");
    } ?>
    <div class="row no-gutters">
        <div class="chatroom col-12 col-md-10 col-lg-8 messageboard">
            <?php foreach ($Message as $message) : ?>
                <div class="row-12 row-md-8 row-lg-6 message">
                    <div class="col-12 contents
                        <?php if ($message['Posted_to'] == $this->session->userdata('user_id')) {
                            echo "right";
                        } else {
                            echo "left";
                        } ?>">
                        <div class="row">
                            <div class="col pill">
                                <div class="row-12">
                                    <p><?php echo $message['FirstName'] ?> <?php echo $message['LastName'] ?></p>
                                    <p class="date"><?php echo $message['Posted_at'] ?></p>
                                </div>
                                <div class="row">
                                    <p><?php echo $message['Message'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <div class="row">
        <div class="chatroom col-12 col-md-10 col-lg-8 ">
            <form onsubmit="return sendMessage(event)">
                <div class="sticky-bottom">
                    <input type="hidden" name="targetId" value="<?php echo $friendid; ?>">
                    <textarea type="text" name="message" id="message" class="form-control" rows="3" placeholder="Insert Message here"></textarea>
                    <input type="submit" style="visibility: hidden;" />
                    <button type="submit" id="messagesubmit" class="messagesubmit createPost btn btn-primary">Post</button>
                    <div id='typing' class="pulsate">
                        <p>User is typing...</p>
                    </div>
                </div>
            </form>
        </div>
    </div>




</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {
        //if user types, emite typing with friendid
        $("#message").keyup(
            function(e) {

                socket.emit("typing", {
                    recieverId: <?php echo $friendid; ?>,
                });
                //if user presses enter, sendmessage
                if (e.keyCode == 13) {
                    sendMessage(event)
                }
            }
        );
    });
</script>