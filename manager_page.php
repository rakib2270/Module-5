<?php 
session_start();

if ($_SESSION['role'] != 'manager') {
  header('Location:index.php');
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
  <title>Manager Dashboard</title>
  <style>
    li{font-size: 22px;}
  </style>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>


  <div class="container mt-5">
    
    
    <nav class="navbar bg-info">
      <div class="container-fluid">
        <h1 class="navbar-brand" style="font-size:38px">Manager Dashboard</h1>
        <div class="nav d-flex">
          <a class="nav-link" href="#">Welcome <?php echo $_SESSION['username'];?></a>
          <a class="nav-link"> | </a>
          <a class="nav-link" href="logout.php">Logout</a>
        </div>
      </div>
    </nav>

    <br><br>
    <div class="border p-3 bg-success text-white">
      <h2>Username : <?php echo $_SESSION['username'];?></h2>
      <h2>E-mail : <?php echo  $_SESSION['email'];?></h2>
      <h2>Role : <?php echo  $_SESSION['role'];?></h2>
    </div>

    <h3 class="mt-3 mb-4">Display All User Information</h3>
    <table class="table table-hover table-bordered table-striped text-center">
      <thead>
        <tr>
          <th>Serial</th>
          <th>Username</th>
          <th>E-mail</th>
          <th>Role</th>
        </tr>
      </thead>
      <tbody>
    <?php 
    $fp = fopen("./data/storage.txt","r");
    $count = 0;
    while ($line = fgetcsv($fp)) {
      $count++;
    ?>
        <tr>
          <td><?php echo $count < 10 ? 0 . $count : $count;?></td>
          <td><?php echo $line[1];?></td>
          <td><?php echo $line[2];?></td>
          <td><?php echo $line[0];?></td>
        </tr>
      <?php }  ?>
      </tbody>
    </table>
  </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>


