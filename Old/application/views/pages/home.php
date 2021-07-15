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
                <?php echo $post['post_id']?>
                <div class="col-12 post" id="">
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
                        <div class="col-6 postinteracttop" id="<?php echo $post['post_id']?>">
                        <!--------------------LIKES COUNT HERE---------------------->
                        <p><?php foreach($likes as $entry) : ?> 
                        <?php if($entry['Post_id'] == $post['post_id']) :?>
                            <?php if ($entry['Likes']>0): echo $entry['Likes']?> 
                            <?php if($entry['Likes'] <>1  ): echo 'likes';?>
                            <?php elseif($entry['Likes'] =1  ): echo 'like';?>  
                            <?php endif ?>      
                            <?php endif ?>                       

                        <?php endif ?>
                        <?php endforeach; ?>  
                        </p> 
                        </div>
                        <div class="col-6 postinteracttop">                               
                             <p><!--ENTER COMMENTS COUNT HERE--></p>                           
                        </div>                    
                    </div>
                    <div class="row interact">
                    <form name="like">
                    <input type="hidden" class="id" id="<?php echo $post['post_id']?>" name="postid" value="<?php echo $post['post_id']?>">
                    <button class='like' id="<?php echo $post['post_id']?>" aria-hidden='true'> Like</button>
                    </form>

                        <div class="col-6 postinteract">
                        <p class="likedby"><a class="Likebtn" id ="submit<?php echo $post['post_id']?>" href="<?php echo base_url('posts/like/'.$post['post_id']); ?>">
                        <?php $match = FALSE?>
                        <?php foreach($liked as $like) : ?> 
                            <?php if($like['post_id'] == $post['post_id']) :$match = TRUE;?>
                            <?php else:$match = FALSE;?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php if ($match == TRUE){
                            echo "You liked this";
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
    </div>
        
    </div>
</div>