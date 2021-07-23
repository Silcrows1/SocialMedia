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

                $('<div class="row-12 message"><div class="col pill"><div class="row-12"><p>' + "<?php echo $this->session->userdata('FirstName'); ?>" + " " + "<?php echo $this->session->userdata('LastName'); ?>" + '</p><p>Posted Now</p></div><div class="row"><p>' + document.getElementById("message").value + '</p></div></div></div>').prependTo('.messageboard');
                $('#message').val('')
            }

        });

        socket.emit("sendMessage", {
            text: document.getElementById("message").value,
            userId: <?php echo $this->session->userdata('user_id') ?>,
            recieverId: <?php echo $friendid; ?>,
        });
    }
    var socket = io("http://localhost:3000");
    socket.emit("addUser", {
        userId: "<?php echo $this->session->userdata('user_id'); ?>",
        
    });


    socket.on("getUsers", users => {
        console.log(users);
    });
    socket.on("getMessage", function(data) {

        $('<div class="row-12 message"><div class="col pill right"><div class="row-12"><p>Testnames</p><p>Posted Now</p></div><div class="row"><p>' + data.text + '</p></div></div></div>').prependTo('.messageboard');

    });
    var timeout;
    socket.on("typing", function(data) {

        if (document.getElementById("typing").style.display != "block") {
            document.getElementById("typing").style.display = "block";
        } else {

        }
        clearTimeout(timeout);
        timeout = setTimeout(timeoutFunction, 1500);

    });

    function timeoutFunction() {

        document.getElementById("typing").style.display = "none";
    }
    //adding message into array for emit
</script>

<body>
    <?php if (!$this->session->userdata('logged_in')) {
        redirect("users/login");
    } ?>
    <div class="row">
        <div class="col messageboard">
            <?php foreach ($Message as $message) : ?>
                <div class="row-12 message">
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
                                    <p><?php echo $message['Posted_at'] ?></p>
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
        <div class="col">
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

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript">

    $(document).ready(function() {

        $("#message").keyup(
            function(e) {

                socket.emit("typing", {
                    recieverId: <?php echo $friendid; ?>,
                });

                if (e.keyCode == 13) {
                    sendMessage(event)
                }
            }
        );
        //add user to database function, needs an ajax function to remove user on disconnect
        //id = 

        //jQuery.ajax({
        //    type: "POST",
        //    url: "<?php echo base_url(); ?>Users/online",
        //    dataType: 'json',
        //    data: {
        //        id
        //    },
        //    success: function(result) {
        //        console.log("added to db");
        //    }
        //});


    });
</script>