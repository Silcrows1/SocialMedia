<div class="col-12">
<?php foreach($users as $user) : ?>
    <!--Validation errors show here -->
    
<?php echo validation_errors(); ?>
<!--Form location -->
<div class="col-8 register">
<?php echo form_open('users/editprofile'); ?>
	<div class="form-group loginelement">
	<!--First name input --><br>
		<label>Biography</label>
		<input type='text' class="form-control" name="Bio" placeholder="Biography" value="<?php echo $user['Bio'] ?>">
	</div><br>

    
	<button type="submit" class="btn btn-primary">submit</button>
<?php echo form_close(); ?>
</div>

<?php endforeach; ?>
</div>