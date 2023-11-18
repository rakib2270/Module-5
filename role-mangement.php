<?php 
  session_start();
  if ($_SESSION['role'] != 'admin') {
    header('Location:index.php');
  }

  if (!isset($_GET['edit']) || $_GET['edit'] == "") {
    header("Location: index.php");
  }
  

    $editId =  $_GET['edit'] ? $_GET['edit']-1 : 0;

    $data = file('./data/storage.txt');

    $info = explode(",", $data[$editId]);


  $userErr = $emailErr = $passErr = "";
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $role = $_POST['role'] ?? "";


    $error = [];

    if (empty($username)) {
      $userErr = 'Please Enter Your Username';
      $error[] = true;
    }
    if(empty($email)) {
      $emailErr = "Please Enter Your Valid Email";
      $error[] = true;
    }
    if (empty($role)) {
      $passErr = "Role field must not be empty!";
      $error[] = true;
    }

    if ( count($error) === 0 ) {
      $filename = "./data/storage.txt";

  
      unset($data[$editId]);

      echo "<pre>";
      print_r($data);

      $newData = sprintf("%s,%s,%s,%s",$role,$username,$email,$info[3]);
      array_push($data,$newData);

      print_r($data);
      echo "</pre>";
      
      if ( is_writeable($filename) ) {

        $fp = fopen($filename,"w");
        
        foreach($data as $line) {
          fwrite($fp,$line);
          header("location:index.php");
        }

        fclose($fp);

      }
      
    } 

  }

  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Role Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="bg-info">
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6 bg-warning p-5">
        <h2 class="text-center">Role Management System</h2>
        <span class="text-success"><?php echo $msg ?? ""; ?></span>
        <span class="text-danger"><?php echo $errMsg ?? ""; ?></span>
        <form action="" method="post">
          <div class="mb-4 mt-5">
            <input type="text" class="form-control" name="username" value="<?php echo $info[1]??"";?>">
            <span class="text-danger"><?php echo $userErr; ?></span>
          </div>

          <div class="mb-4">
            <input type="email" class="form-control" name="email" value="<?php echo $info[2]??"";?>">
            <span class="text-danger"><?php echo $emailErr; ?></span>
          </div>

          <div class="mb-4">
            <select name="role" class="form-control">
              <option disable>Select One Role</option>
              <option <?php if ($info[0]=='admin') {echo "selected";} ?> value="admin">Admin</option>
              <option <?php if ($info[0]=='manager') {echo "selected";} ?> value="manager">Manager</option>
              <option <?php if ($info[0]=='user') {echo "selected";} ?> value="user">User</option>
            </select>
          </div>
          <div class="col-12">
              <div class="d-grid">
                  <button type="submit" name="save" class="btn btn-primary radius-50">Update</button>
              </div>
          </div>
          
          <div class="col-12 mt-3">
              <p ><a
                      href="index.php">Home</a></p>
          </div>

        </form>
      </div>
    </div>
    
  </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>