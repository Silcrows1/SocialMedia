<div class="col-12">
	<?php foreach ($users as $user) : ?>
		<!--Validation errors show here -->
		<div class="col-8 editprofileoptions">
			<?php echo validation_errors(); ?>
			<!--Form location -->

			<?php echo form_open('users/editprofile'); ?>
			<div class="form-group loginelement">
				<!--Biography input --><br>
				<label>Biography</label>
				<input type='text' class="form-control" name="Bio" placeholder="Biography" value="<?php echo $user['Bio'] ?>">
			</div><br>
			<button type="submit" class="btn btn-primary">submit</button>
			<?php echo form_close(); ?><br/>

		<?php endforeach; ?>
		<!-- Upload new profile picture select and submit -->
		<p>To upload a new profile picture, click 'Browse' to select a new picture and then click upload</p><br/>
		<?php echo form_open_multipart('upload/do_upload'); ?>
		<input type="file" name="userfile" size="20" />
		<br /><br />
		<input type="submit" value="upload" />
		</form>
		</div>
</div>