<!--Validation errors show here -->
<?php echo validation_errors(); ?>
<!--Form location -->
<div class="col-8 register">
<?php echo form_open('users/register'); ?>
	<div class="form-group loginelement">
	<!--First name input --><br>
		<label>First Name</label>
		<input type='text' class="form-control" name="fname" placeholder="First Name">
	</div><br>
	<div class="form-group loginelement">
	<!--Last Name input-->
		<label>Last Name</label>
		<input type='text' class="form-control" name="lname" placeholder="Last Name">
	</div><br>

    <p>Select the font that is easiest to read (you can change this later).</p>
    <div>
    <input type="radio" class="small" name="fontpref" value="1" checked="checked">
    <label for="small" class="small">A a B b C c</label>
    <br>
    <input type="radio" class="medium" name="fontpref" value="2">
    <label for="medium" class="medium">A a B b C c</label>
    <br>
    <input type="radio" class="large" name="fontpref" value="3">
    <label for="large" class="large">A a B b C c</label>
    </div><br>
    <div class="form-group loginelement">
	<!--Support required input -->
		<p>This website supports its users and can provide volunteers to keep you company,
            please select if you would like to use this service. (You can change this preference from your profile)</p>
        <div>    
		<input type="radio" class="No" name="support" value="0" checked="checked">
        <label for="No" class="small">No</label>
        <br>
        <input type="radio" class="Yes" name="support" value="1">
        <label for="Yes" class="small">Yes</label>
        </div>
	</div><br>
	<div class="form-group loginelement">
	<!--Email address input -->
		<label>Email Address</label>
		<input type='email' class="form-control" name="email" placeholder="Email Address">
	</div><br>
    <div class="form-group loginelement">
	<!--Username input) -->
		<label>Username</label>
		<input type='text' class="form-control" name="username" placeholder="Username">
	</div><br>
	<div class="form-group loginelement">
	<!--Password input-->
		<label>Password</label>
		<input type='text' class="form-control" name="password" placeholder="Password">
	</div><br>
	<div class="form-group loginelement">
	<!--Confirm password input (must match previous password (validation)) -->
		<label>Confirm Password</label>
		<input type='text' class="form-control" name="password2" placeholder="Confirm Password">
	</div><br>

    <div class="form-group loginelement">
	<!--password reminder input -->
    <label for="cars">Choose a password reminder:</label>
    <br>
        <select name="question" id="questions">
        <option value="1" selected>Mothers Maiden Name</option>
        <option value="2">The name of your first pet</option>
        <option value="3">The first place you lived</option>
        <option value="4">Your favourite holiday location</option>
        <option value="5">Your favourite TV show</option>
        </select> 
        <br><br>
		<label>Password reminder answer</label>
		<input type='text' class="form-control" name="reminder" placeholder="Department">
	</div><br>

	<button type="submit" class="btn btn-primary">submit</button>
<?php echo form_close(); ?>
</div>

