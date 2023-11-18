<?php 
  
  $userErr = $emailErr = $passErr = "";
  

  // When logined or registration page is executed user information will save in storage file

  $adminInfo = [
    'username' => 'rakib',
    'email' => 'rakib@gmail.com',
    'password'=> 'rakib123',
    'role'=> 'admin'
  ];

  $file = file_get_contents("./data/storage.txt");

  if (empty($file)) {
    $fp = fopen("./data/storage.txt","w");
    
    $data = sprintf("%s,%s,%s,%s\n",$adminInfo['role'],$adminInfo['username'],$adminInfo['email'],$adminInfo['password']);
    fwrite($fp,$data);
    fclose($fp);
  }
    

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

    

    $error = [];

    if (empty($username)) {
      $userErr = 'Please Enter Your Username';
      $error[] = true;
    }
    if(empty($email)) {
      $emailErr = "Please Enter Your Valid Email";
      $error[] = true;
    }
    if (empty($password)) {
      $passErr = "Please Enter Your Valid Password";
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
          fwrite($fp,"user,$username,$email,$password\n");
          $msg = "Registration Successfully";
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
  <title>Registration System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="bg-info">
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6 bg-warning p-5">
        <h2 class="text-center">Registration System</h2>
        <span class="text-success"><?php echo $msg ?? ""; ?></span>
        <span class="text-danger"><?php echo $requiredMsg ?? ""; ?></span>
        <form action="registration.php" method="post">
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

          <div class="col-12">
              <div class="d-grid">
                  <button type="submit" name="register" class="btn btn-primary radius-50">Sign
                      Up</button>
              </div>
          </div>

          <div class="col-12 mt-3">
              <p class="mb-0">Already have an account? <a
                      href="login.php">Login here</a></p>
          </div>

        </form>
      </div>
    </div>
    
  </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>