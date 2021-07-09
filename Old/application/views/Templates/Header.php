<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
    
    <title>Old</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Old Bees</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo base_url(); ?>pages/view">Home</a>
        </li>
        
        <?php if($this->session->userdata('logged_in')) : ?> 
          <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>users/viewownprofile">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>users/viewaccount">Account</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>users/logout">Log out</a>
        </li>
        <?php endif ?>
        
      </ul>
    </div>
    <form action="<?php echo base_url(); ?>users/search" method = "post" class="searchbar">
        <label for="keyword">Search
        <input class = "input" type="text" name = "keyword" placeholder ="Search Users"label="Search" />
        <input type="submit" value = "Search" />
        </label>
        </form>
  </div>
</nav>
<?php if ($this->session->flashdata('login_failed')): ?>
	<?php echo '<div class="flash"><p class="alert alert-success">'.$this->session->flashdata('login_failed').'</p></div>';?>
	<?php endif; ?>