<div class="col-12">
    <div class="row-8">
        <!-- Itterate through users found -->
        <?php foreach ($users as $user) : ?>
            <div class="col-12">
                <div class="row-12 postcard">
                    <!-- Div to show users name and a link -->
                    <p><a class="" href="<?php echo base_url('users/viewprofile/' . $user['User_id']); ?>"><?php echo $user['FirstName'] . ' ' . $user['LastName'] ?></p></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div>