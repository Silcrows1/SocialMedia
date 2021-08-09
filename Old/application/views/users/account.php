<!-- Append user information -->
<?php foreach($users as $user) : ?>
<div class = "col-8 profilemain chatroom">
    <!-- Edit account button -->
    <a class="acontrastlink" href="<?php echo base_url(('/users/edit/'.$user['User_id'])); ?>">Edit Account</btn></a><br><br>
<p><?php echo $user['FirstName'].' '.$user['LastName'] ?></p>
<p>Email: <?php echo $user['Email'] ?></p>
<p>Gender: <?php echo $user['Gender'] ?></p>
</div>

<?php endforeach; ?>
