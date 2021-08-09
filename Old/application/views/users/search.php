<div class="col-12">
    <div class="row-8">
        <?php foreach ($users as $user) : ?>
            <div class="col-12">
                <div class="row-12 postcard">
                    <p><a class="" href="<?php echo base_url('users/viewprofile/' . $user['User_id']); ?>"><?php echo $user['FirstName'] . ' ' . $user['LastName'] ?></p></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div>