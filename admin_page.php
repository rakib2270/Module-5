<?php 
session_start();

if ( !isset($_SESSION['login']) && $_SESSION['login']==false ) {
  header('Location:login.php');
}

if ( $_SESSION['role']!='admin' ){
  header('location: index.php');
}

// delete user code 

if (isset($_GET['index'])) {
  $index =  $_GET['index']-1;

  $data = file('./data/storage.txt');
  
  unset($data[$index]);
  
  $count = count($data);

  if ($count != 0) {
    $fp = fopen("data/storage.txt","w");

    foreach($data as $line) {
      fwrite($fp,$line);
    }

    fclose($fp); 
  }
  header("Location:index.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <style>
    li{font-size: 22px;}
  </style>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="bg-success">


  <div class="container mt-5">
       
    <nav class="navbar bg-info">
      <div class="container-fluid">
        <h1 class="navbar-brand" style="font-size:38px">Admin Dashboard</h1>
        <div class="nav d-flex">
          <a class="nav-link" href="create_user.php">Create New</a>
          <a class="nav-link"> | </a>
          <a class="nav-link" href="#">Welcome <?php echo $_SESSION['username'];?></a>
          <a class="nav-link"> | </a>
          <a class="nav-link" href="logout.php">Logout</a>
        </div>
      </div>
    </nav>
    <div class="border p-3 bg-warning text-white">
      <h3>Username : <?php echo $_SESSION['username'];?></h3>
      <h3>E-mail : <?php echo  $_SESSION['email'];?></h3>
      <h3>Role : <?php echo  $_SESSION['role'];?></h3>
    </div>
    <h3 class='mt-4 mb-4'>Display All User Information</h3>

    <table class="table table-hover table-bordered table-striped text-center">
      <thead>
        <tr>
          <th>Serial</th>
          <th>Username</th>
          <th>E-mail</th>
          <th>Role</th>
          <th>Action</th>
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
          <td><?php echo $line[1] ?? null;?></td>
          <td><?php echo $line[2] ?? null;?></td>
          <td><?php echo $line[0];?></td>
          <td>
            <a class="btn btn-warning" href="role-mangement.php?<?php echo "edit=$count"; ?>">Edit</a>
            <a class="btn btn-danger" href='?<?php echo "index=$count"; ?>'>Delete</a>
          </td>
        </tr>
      <?php }  ?>
      </tbody>
    </table>
    
  </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
