
<div class="col-md-12 ">
    <div class="row-12">
        <div class="col-6 mainfeed">
        
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
                             <p>Like</p>                           
                        </div>
                        <div class="col-6 postinteract">                               
                             <p>Comment</p>                           
                        </div>                    
                    </div>                
                </div>
        </div>
            
        <?php endforeach; ?>
    </div>
        
    </div>
</div>