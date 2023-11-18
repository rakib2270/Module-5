<?php 
session_start();

if ($_SESSION['role'] != 'user') {
  header("Location: index.php");
}

if ( !isset($_SESSION['login']) && $_SESSION['login']==false ) {
  header('Location:login.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <style>
    .nav .nav-link{font-size: 22px;}
  </style>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>


  <div class="container mt-5">
    
    
    <nav class="navbar bg-info">
      <div class="container-fluid">
        <h1 class="navbar-brand" style="font-size:38px">User Dashboard</h1>
        <div class="nav d-flex">
          <a class="nav-link" href="#">Welcome <?php echo $_SESSION['username'];?></a>
          <a class="nav-link"> | </a>
          <a class="nav-link" href="logout.php">Logout</a>
        </div>
      </div>
    </nav>
    
    <div class="border p-3 bg-success text-white">
      <h2>Username : <?php echo $_SESSION['username'];?></h2>
      <h2>E-mail : <?php echo  $_SESSION['email'];?></h2>
      <h2>Role : <?php echo  $_SESSION['role'];?></h2>
    </div>
    
  </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>


