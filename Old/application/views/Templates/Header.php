<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
  <script src="https://cdn.socket.io/4.1.2/socket.io.min.js" integrity="sha384-toS6mmwu70G0fw54EGlWWeA4z3dyJ+dlXBtSURSKN4vyRFOcxd3Bzjj/AoOwY+Rg" crossorigin="anonymous"></script>
  <title>Old</title>

</head>

<body>
  <script>
    //if user is logged in, emit add user to insert in database as online user//
    <?php if ($this->session->userdata('logged_in')) : ?>
      var socket = io("http://localhost:3000");
      socket.emit("addUser", {
        userId: "<?php echo $this->session->userdata('user_id'); ?>",

      });
    <?php endif ?>
  </script>
  <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <a class="navbar-brand" href="<?php echo base_url(); ?>Home"><img class="beelogo" src = "<?php echo base_url(); ?>assets/images/beelogo.svg"></a> 
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link active" aria-current="page" href="<?php echo base_url(); ?>Home">Home</a>
        </li>

        <?php if ($this->session->userdata('logged_in')) : ?>
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

        <?php if ($this->session->userdata('UserType') == 'Admin') : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url(); ?>admins/viewUsers">AdminPanel</a>
          </li>
        <?php endif ?>

      </ul>
    </div>
    <form action="<?php echo base_url(); ?>users/search" method="post" class="searchbar">
      <label for="keyword">Search
        <input class="input" type="text" name="keyword" placeholder="Search Users" label="Search" />
        <input type="submit" value="Search" />
      </label>
    </form>

    </div>
  </nav>
  <?php if ($this->session->flashdata('login_failed')) : ?>
    <?php echo '<div class="flash"><p class="alert alert-success">' . $this->session->flashdata('login_failed') . '</p></div>'; ?>
  <?php endif; ?>
