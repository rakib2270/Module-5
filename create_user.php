<?php 
  session_start();
  
  if ($_SESSION["role"] != "admin") {
    header("Location:index.php");
  }

  $userErr = $emailErr = $passErr = $roleErr = "";
  
    

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    function validation($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    $username = validation($_POST['username']);
    $email    = validation($_POST['email']);
    $password = validation($_POST['password']);
    $role     = validation($_POST['role']) ?? "";

    

    $error = [];

    if (empty($username)) {
      $userErr = 'Username field must not be empty!';
      $error[] = true;
    }
    if(empty($email)) {
      $emailErr = "Email field must not be empty!";
      $error[] = true;
    }
    if (empty($password)) {
      $passErr = "Password field must not be empty!";
      $error[] = true;
    }
    if (empty($role)) {
      $roleErr = "Role field must not be empty!";
      $error[] = true;
    }

    if ( count($error) === 0 ) {
      $filename = "./data/storage.txt";
      
      if ( is_writeable($filename) ) {
        $data = file_get_contents($filename);

        $fp = fopen($filename,"a+");

        $found = false;
        // check if exist email 
        $data = file_get_contents($filename);
        $lines = explode("\n",rtrim($data,"\n"));
        foreach($lines as $line) {
          $data = explode(',',$line);
          if ($data[2] == $email) {
            $found = true;
          }
        }

        if ($found) {
          $requiredMsg = "Already Email address exists";;
        }else {
          fwrite($fp,"$role,$username,$email,$password\n");
          $msg = "New User Added Successfully";
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
  <title>Create New Account</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="bg-success">
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6 bg-warning p-5">
        <h2 class="text-center">Create New Account</h2>
        <span class="text-success"><?php echo $msg ?? ""; ?></span>
        <span class="text-danger"><?php echo $requiredMsg ?? ""; ?></span>
        <form action="" method="post">
          <div class="mb-4 mt-5">
            <input type="text" class="form-control" name="username" placeholder="Enter Username">
            <span class="text-danger"><?php echo $userErr; ?></span>
          </div>

          <div class="mb-4">
            <input type="email" class="form-control" name="email" placeholder="Enter Email">
            <span class="text-danger"><?php echo $emailErr; ?></span>
          </div>

          <div class="mb-4">
            <input type="password" name="password" placeholder="Enter Password" class="form-control" >
            <span class="text-danger"><?php echo $passErr; ?></span>
          </div>

          <div class="mb-4">
           <select name="role" class="form-control">
            <option disabled="" selected>Select Role</option>
            <option value="admin">Admin</option>
            <option value="manager">Manager</option>
            <option value="user">User</option>
           </select>
           <span class="text-danger"><?php echo $roleErr; ?></span>
          </div>
          
          <div class="col-12">
              <div class="d-grid">
                  <button type="submit" name="addUser" class="btn btn-primary radius-50">Create Account</button>
              </div>
          </div>
          <div class="col-12 mt-3">
              <p ><a
                      href="index.php"> Home </a></p>
          </div>

        </form>
      </div>
    </div>
  </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>