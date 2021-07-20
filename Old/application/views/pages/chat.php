<body>
    <div class="row">
        <div class="col messageboard">
            <?php foreach ($Message as $message) :?>            
                <div class="row-12 message">
                    <div class="col-12 contents 
                        <?php if ($message['Posted_to'] == $this->session->userdata('user_id')){
                        echo "right";
                        }
                        else{
                            echo "left"; 
                        }?>">
                        <div class="row">
                            <div class="col pill">
                                <div class="row-12">
                                    <p><?php echo $message['FirstName']?> <?php echo $message['LastName']?></p>
                                    <p><?php echo $message['Posted_at']?></p>
                                </div>
                                <div class="row">
                                    <p><?php echo $message['Message']?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach?>
        </div>        
    </div>
    <div class="row">
        <div class="col">
            <?php echo form_open('messages/sendMessage'); ?>
                <div class="sticky-bottom">
                    <input type="hidden" name="targetId" value="<?php echo $friendid;?>">
                    <textarea type="text" name="message" id="message" class="form-control" rows="3" placeholder="Insert Message here"></textarea>
                    <button type="submit" id="messagesubmit" class="messagesubmit createPost btn btn-primary">Post</button>
                </div>
            <?php echo form_close(); ?> 
        </div>
    </div>    
</body>