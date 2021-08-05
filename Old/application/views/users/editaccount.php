<div class="col-12 position-relative">
	<?php foreach ($users as $user) : ?>
		<!--Validation errors show here -->
		<?php $id = $this->session->userdata('user_id') ?>
		<?php echo validation_errors(); ?>
		<!--Form location -->
		<div class="col-8 register">
			<?php echo form_open('users/editaccount/' . $id); ?>
			<div class="form-group loginelement">
				<!--First name input --><br>
				<label>First Name</label>
				<input type='text' class="form-control" name="fname" placeholder="First Name" value="<?php echo $user['FirstName'] ?>">
			</div><br>
			<div class="form-group loginelement">
				<!--Last Name input-->
				<label>Last Name</label>
				<input type='text' class="form-control" name="lname" placeholder="Last Name" value="<?php echo $user['LastName'] ?>">
			</div><br>

			<p>Select the font that is easiest to read (you can change this later).</p>
			<div>
				<input type="radio" class="small" name="fontpref" value="1" <?php if ($user['Vision'] == "1") echo 'checked="checked"'?>>
				<label for="small" class="small">A a B b C c</label>
				<br>
				<input type="radio" class="medium" name="fontpref" value="2" <?php if ($user['Vision'] == "2") echo 'checked="checked"'?>>
				<label for="medium" class="medium">A a B b C c</label>
				<br>
				<input type="radio" class="large" name="fontpref" value="3" <?php if ($user['Vision'] == "3") echo 'checked="checked"'?>>
				<label for="large" class="large">A a B b C c</label>
			</div><br>
			<div class="form-group loginelement">
				<!--Support required input -->
				<p>This website supports its users and can provide volunteers to keep you company,
					please select if you would like to use this service. (You can change this preference from your profile)</p>
				<div>
					<input type="radio" class="No" name="support" value="0" <?php if ($user['HelpRequired'] == '0') {
																				echo 'checked="checked"';
																			} ?>>
					<label for="No" class="small">No</label>
					<br>
					<input type="radio" class="Yes" name="support" value="0" <?php if ($user['HelpRequired'] == '1') {
																					echo 'checked="checked"';
																				} ?>>
					<label for="Yes" class="small">Yes</label>
				</div>
			</div><br>
			<div class="form-group loginelement">
				<!--Gender input -->
				<p>Gender</p>
				<div>
					<input type="radio" class="No" name="gender" value="Male" <?php if ($user['Gender'] == 'Male') {
																					echo 'checked="checked"';
																				} ?>>
					<label for="No" class="small">Male</label>
					<br>
					<input type="radio" class="Yes" name="gender" value="Female" <?php if ($user['Gender'] == 'Female') {
																						echo 'checked="checked"';
																					} ?>>
					<label for="Yes" class="small">Female</label>
				</div>
			</div><br>
			<div class="form-group loginelement">
				<!--Email address input -->
				<label>Email Address</label>
				<input type='email' class="form-control" name="email" placeholder="Email Address" value="<?php echo $user['Email'] ?>">
			</div><br>
			<div class="form-group loginelement">
				<!--Username input) -->
				<label>Username</label>
				<input type='text' class="form-control" name="username" placeholder="Username" value="<?php echo $user['Username'] ?>">
			</div><br>

			<div class="form-group loginelement">
				<p>If you wish to change your password, enter your old password and new password. If your old password does not match, this will remain unchanged</p><br>
				<!--Password input-->
				<label>Old password</label>
				<input type='password' class="form-control" name="password" placeholder="Old Password">
			</div><br>
			<div class="form-group loginelement">
				<!--Confirm password input (must match previous password (validation)) -->
				<label>New Password</label>
				<input type='password' class="form-control" name="password2" placeholder="New Password">
			</div><br>

			<button type="submit" class="btn btn-primary">submit</button>
			<?php echo form_close(); ?>
		</div>
		<div class="row deletebox hidden" id="deletebox">
			<div class="col text-center">
				<p>Deleting your account is irreversible, to proceed with delete, please type Delete below to confirm.
					<input type="text" id="confirmationinput" name="confirm"><br>
					<button class="confirmdelete" id="<?php echo $user['User_id'] ?>">CONFIRM</button>
			</div>
		</div>
		<a class="deleteProfile" id="Deletebutton">Delete Account</a><br><br>


	<?php endforeach; ?>
</div>