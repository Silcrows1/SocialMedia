
<div class="col-md-12 ">
    <div class="row-12">
        <div class="col-8 mainfeed">
        
        <?php echo form_open('posts/createPost'); ?>
        <div class="form-row">
            <div class="col">
            <textarea type="text" name="postContent" class="form-control" rows="3" placeholder="Post"></textarea>
            <button type="submit" class="createPost btn btn-primary">Sign in</button>
            </div>
        </div>
        <br>
        <br>
        <?php echo form_close(); ?>
        <?php foreach($posts as $post) : ?>
            <div class="col-12">
                <div class="row-12 postcard">
                <p><?php echo (date("H:i A",strtotime ($post['Posted']))).' on '.(date("l jS F Y",strtotime ($post['Posted'])))?></p>
                <p><a class="" href="<?php echo base_url('users/viewprofile/'.$post['user_id']); ?>"><?php echo $post['FirstName'].' '.$post['LastName']?></p></a>
                <p><?php echo $post['Content']?></p>
                </div>
            </div>
            
        <?php endforeach; ?>
        </div>
        
    </div>
</div>