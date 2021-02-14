<?php

session_start();
error_reporting(0);

if(isset($_POST['signin'] ) ){
    header('Location: signup.php');
}

if(isset($_SESSION['registered'])){
  $emailfetched = $_SESSION['email'];
}

?>


<!DOCTYPE html>
<html>
<head>
  <title>FutureMe - Public, but anonymous, letters</title>
  <link rel = "icon" href = "Images/fm-logo.png" type = "image/x-icon"> 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  <!-- DatePicker -->
  <!--Importing CDN's-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
  <link rel="stylesheet" href="css/index.css">
  <script src="js/index.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom border-dark">
  <div class="container-fluid">
  <a class="navbar-brand" href="#">
    <p style="color:white;" href="index.php" class="logoreplace">FutureMe™</p>
    <!-- <img src="Images/fm-logo.png" width="60" height="30" alt=""> -->
  </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" style="color:white; text-decoration: none;" aria-current="page" href="#">For Teachers</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" style="color:white; text-decoration: none;" aria-current="page" href="#">For Organizations</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" style="color:white; text-decoration: none;" aria-current="page" href="index.php">Write a Letter to the Future</a>
        </li>
        
      </ul>
      <form class="d-flex" method="post">
        <?php 
        if(!isset($emailfetched)){
        echo'<button class="btn btn-outline-success" name="signin" style="color:white; margin-left: 90%;" type="submit">Sign In</button>';
        }
        else{
          echo'<div class="dropdown" style="color:white; margin-left: 70%;" >';
          echo'<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="font-size: 16px;text-align: center; margin-top: 2.8px; background-color: #0D45E4;">';
          echo htmlentities($emailfetched);
          echo'</button>';
          echo'<ul class="dropdown-menu">';
          echo'<li><a href="#" style="font-size: 16px;">My Account</a></li>';
          echo'<li><a href="php/logout.php" style="font-size: 16px;">Logout</a></li>';
          echo'</ul>';
          
          echo'</div>';
          echo'<button class="btn btn-outline-success" style="color:white; margin-left: 70%;" type="submit">'.htmlentities($emailfetched).'</button>';
        }
        ?>
      </form>
    </div>
  </div>
</nav>

<br />
<br />
<h2 style="color: white; margin-left: 1%;">Public, but anonymous, letters</h2>
<p style="color: white; margin-left: 1%;">Letters delivered from the past, curated by the community</p>
<hr>
</body>
<br />
<?php
                             include 'php/Dbconnect.php';
                             $stmt = $conn->prepare("SELECT * FROM emails where privacy = 'Public'");
                             $stmt->execute();
                             $result = $stmt->get_result();
                             while  ($row = $result->fetch_assoc()):

?>
<div class="card" style="margin-left: 1%;">
  <div class="card-header">
  SENT ALMOST 10 YEARS INTO THE FUTURE
  </div>
  <div class="card-body" >
    <h5 class="card-title"><?= $row['Headline'] ?></h5>
    <p class="card-text"><?= $row['Message'] ?></p>
  </div>
</div>
<hr>
<?php 
endwhile; ?>
<br />
<footer style="text-size: 12px;" >
FutureMe™ brought to you by FutureMe Labs, LLC © 2002 - 2021. Yup - we've been sending letters to the future for about 19 years now
</footer>

</html>