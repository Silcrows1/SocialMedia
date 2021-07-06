<?php foreach($users as $user) : ?>
<div class = "col 12">
<?php echo $user['FirstName'] ?>
<?php echo $user['LastName'] ?>
<?php echo $user['Email'] ?>
</div>
<?php endforeach; ?>