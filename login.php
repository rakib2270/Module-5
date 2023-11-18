<?php 
  session_start();
  if ( isset($_SESSION['login']) && $_SESSION['login']==true ) {
    header("Location:index.php");
  }

   $adminInfo = [
    'username' => 'Rakib',
    'email' => 'rakib@gmail.com',
    'password'=> 12345678,
    'role'=> 'admin'
  ];

  $file = file_get_contents("./data/storage.txt");

  if (empty($file)) {
    $fp = fopen("./data/storage.txt","w");
    
    $data = sprintf("%s,%s,%s,%s\n",$adminInfo['role'],$adminInfo['username'],$adminInfo['email'],$adminInfo['password']);
    fwrite($fp,$data);
    fclose($fp);
  }




  $requiredMsg = "";

  if ( $_SERVER['REQUEST_METHOD']=='POST' ) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ( !empty($email) && !empty($password) ) {

      $roles     = [];
      $usernames = [];
      $emails    = [];
      $passwords = [];

      $data = "./data/storage.txt";
      $fp = fopen($data,"r");
      while($line = fgetcsv($fp)) {
        $roles[]     = $line[0];
        $usernames[] = $line[1];
        $emails[]    = $line[2];
        $passwords[] = $line[3];

      }
      fclose($fp);

     $count = count($emails);

     for( $i=0; $i<$count; $i++ ) {
      if ( $emails[$i] == $email && $passwords[$i] == $password ) {
        session_start();
        $_SESSION['login'] = true;
        $_SESSION['username'] = $usernames[$i];
        $_SESSION['email'] = $emails[$i];
        $_SESSION['role'] = $roles[$i];
       
        header("Location:index.php");
      }else {
        $requiredMsg = "Please Enter Your Valid Username or Password";
      }
     }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="bg-secondary">


  <div class="container mt-5 ">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6 bg-info p-5">
        <h2 class="text-center">Sign In System</h2>
        <span class="text-danger"><?php echo $requiredMsg;?></span>
        <form action="login.php" method="post">
          <div class="mb-3">
            <label for="email" class="form-label">Enter Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="example@gmail.com" aria-describedby="emailHelp">
            
          </div>
          <div class="mb-4">
            <label for="pass" class="form-label">Password</label>
            <input type="password" name="password" placeholder="********" class="form-control" id="pass">
          </div>
          <div class="col-12">
              <div class="d-grid">
                  <button type="submit" name="login" class="btn btn-primary radius-50">Sign
                      In</button>
              </div>
          </div>

          <div class="col-12 mt-3">
              <p class="mb-0">Don't have an account? <a
                      href="registration.php">Sign up</a></p>               
          </div>

        </form>
      </div>
    </div>
    
  </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>