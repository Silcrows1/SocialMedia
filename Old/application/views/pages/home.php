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
                        <div class="col-6 postinteracttop" id="comment<?php echo $post['post_id']?>">                               
                        <p><?php foreach($comments as $entry) : ?> 
                        <?php if($entry['Post_id'] == $post['post_id']) :?>
                            <?php if ($entry['Comments']>0): echo $entry['Comments']?> 
                            <?php if($entry['Comments'] <>1  ): echo 'Comments';?>
                            <?php elseif($entry['Comments'] =1  ): echo 'Comments';?>  
                            <?php endif ?>      
                            <?php endif ?>                       

                        <?php endif ?>
                        <?php endforeach; ?>                                
                        </div>                    
                    </div>
                    <div class="row interact">

                        <div class="col-6 postinteract">
                        <a class="Likebtn" id ="submit<?php echo $post['post_id']?>" href=""  title = "<?php echo $post['post_id']?>" data-elemid="">
                        <?php $match = FALSE?>
                        <?php foreach($liked as $like) : ?> 
                            <?php if($like['post_id'] == $post['post_id']) :$match = TRUE;?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php if ($match == TRUE){
                            echo "You liked this";
                        }
                        else{
                            echo "Like";
                        }?>
                         </a>                          
   
                        </div>
                        <div class="col-6 postinteract " id="<?php echo $post['post_id']; ?>">
                            <a class="viewcomment" id="viewcomment" title="<?php echo $post['post_id']; ?>">
                                <?php foreach($comments as $entry) : ?> 
                                    <?php if($entry['Post_id'] == $post['post_id']) :?>
                                        <?php if ($entry['Comments']==0): echo 'Add Comment';?> 
                                        <?php else : echo 'View Comments';?>
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
                                    <button type="button" id="commentsubmit" title = "<?php echo $post['post_id']?>" class="commentsubmit createPost btn btn-primary">Post</button>
                                    </div>
                                </div>
                           
                        </div>
                        <div class="viewcomments<?php echo $post['post_id']; ?>">
   
                           
                        </div>
                        
                    </div>
                    
                                    
                </div>
        </div>
            
        <?php endforeach; ?>
    </div>
        
    </div>
</div>