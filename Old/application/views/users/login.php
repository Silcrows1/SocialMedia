<!--Show and hide password javeascript function (found in w3) -->
<script>
	function myFunction() {
  var x = document.getElementById("password");
	  if (x.type === "password") {
		x.type = "text";
	  } else {
		x.type = "password";
	  }
	} 
	</script>
  <?php 
  if(isset($_SESSION['userexsists'])){
    unset($_SESSION['userexsists']);
  }?>
<div class="col-3 login">

<!--login Form-->
<?php echo form_open_multipart('users/login'); ?>
  <div class="col-12 mb-3">
  <?php echo validation_errors(); ?>
    <label for="exampleInputEmail1" class="form-label">Username</label>
    <input type="text" name="username" class="form-control" >
    <div id="emailHelp" class="form-text">We'll never share your details with anyone else.</div>
  </div>
  <div class="col-12 mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" name="password" id="password" class="form-control">
  </div>
  <div class="col-12 mb-3 form-check">
    <input type="checkbox" class="form-check-input" onclick="myFunction()">
    <label class="form-check-label" for="exampleCheck1">Show Password</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button></br></br></br>

  <p>Need an account? Register <a href="<?php echo base_url(); ?>users/register">here</a></p>
  <!--<button type="button" onclick="location.href='<?php echo base_url(); ?>users/register'" class="btn btn-primary">Register</button>-->
  <?php echo form_close(); ?>
</div>