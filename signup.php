<?php
require_once "php/pdo.php";
// error_reporting(0);
$failure = false; 
$comment = false;

if ( isset($_POST['cancel'] ) ) {
    
    header('Location: index.php');
    return;
}


try {

    if (isset($_POST['email']) && isset($_POST['password'])) {

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {      
        $failure = "Invalid Email.";
    }
    
    elseif ( strlen($_POST['password']) < 5 ) {
        $failure = "Use at least 6 characters for password.";
    } 
    else{

        $salt = "dhjl@bxjkns238njknwqs".$_POST['password'];
	    $hashed = hash('md5',$salt);

          $sql = "INSERT INTO userinfo (email, password)
          VALUES (:email, :password)";
          $stmt = $pdo->prepare($sql);
          $stmt->execute(array(
          ':email' => $_POST['email'],
          ':password' => $hashed));

          session_start();
          $_SESSION['registered'] = 'yes';
          $_SESSION['email'] = $_POST['email'];

          header('Location: index.php');
        
    }

  }
}
catch (\PDOException $e) {
    if ($e->errorInfo[1] == 1062) {
        $failure = "Email already registered.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Sign Up</title>
  <link rel="stylesheet" href="font-awesome.min.css">
  <link rel = "icon" href = "Images/fm-logo.png" type = "image/x-icon"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/signup.css">
</head>
<body>
    <div class="overlay">

   <form method="post">

   <div class="con">
   
   <header class="head-form">
      <h2>Sign In to FutureMe</h2>
   </header>
   
   <br>

   <div class="field-set">
         <?php

         if ( $failure !== false ) {
             echo('<p style="color: red; text-align:centre;">'.htmlentities($failure)."</p>\n");
         }

         if ( $comment !== false ) {
             echo('<p style="color: green; text-align:centre;">'.htmlentities($comment)."</p>\n");
         }

         ?>

          <span class="input-item">
          <i class="fa fa-at"></i>
          </span>
          <input class="form-input" id="txt-input4" name ="email" type="text" placeholder="Email">
          <br>
          <br />
          <span class="input-item">
          <i class="fa fa-key"></i>
          </span>
          <input class="form-input" type="password" placeholder="Password" id="pwd"  name="password">
          <span >
          <i class="fa fa-eye" type="button" id="eye"></i>
          </span>
          <br>



     </span>
      <br>

      <button class="signup"> Sign Up </button>
   </div>
  

   <div class="other">
      <button class="btn submits frgt-pass" name="cancel">Cancel</button>
      <button class="btn submits sign-up" type="disabled" name="login">Login 
      </button>

   </div>
  </div>
  
 
</form>
</div>
<script src="js/demo4.js"></script>
</body>
</html>

