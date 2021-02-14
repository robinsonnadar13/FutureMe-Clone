<?php
require_once "php/pdo.php";
session_start();
$dateselect = "start";
error_reporting(0);


date_default_timezone_set("Asia/Kolkata");
$time = date("h:i:sa");
$date = date("Y-m-d");
$date_d = date('d');
$date_y = date('Y');
$monthNum  = date('m');
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('F'); 

if(isset($_SESSION['registered'])){
  $emailfetched = $_SESSION['email'];
}

if(isset($_POST['dateselect'] ) ){
  $dateselect = "yes";
}

if(isset($_POST['dateselect1'] ) ){
  $dateselect = "no";
}

if(isset($_POST['signin'] ) ){
  header('Location: signup.php');
}

if(isset($_POST['send'] ) ){


  if(($_POST['accessible-radio1'] == 'item-4')){
    $privacyon = 'Private';

   
  }
  if(($_POST['accessible-radio1'] == 'item-5')){
    $privacyon = 'Public';
    
  }

  if(($_POST['accessible-radio'] == 'item-1')){
    $YearOn = date('Y-m-d',strtotime(date("Y-m-d", time()) . " + 365 day"));
    
    
  }
  if(($_POST['accessible-radio'] == 'item-2')){
    $YearOn = date('Y-m-d',strtotime(date("Y-m-d", time()) . " + 1095 day"));
    
  }
  if(($_POST['accessible-radio'] == 'item-3')){
    $YearOn = date('Y-m-d',strtotime(date("Y-m-d", time()) . " + 1826 day"));
   
  }
  if(isset($_POST['begin']) ){
    $YearOn = $_POST['begin'];
  }

  if(strlen($_POST['msg']) < 1 ){
    $failure = "Message field is empty";
 
  }
  elseif(strlen($_POST['email']) < 1){
    $failure1 = "Email is required";

  }

 
  else{

    $email = $_POST['email'];
    $headline = 'A letter from '.$monthName.' '.$date_d.'th, '.$date_y.' ';
    $message = $_POST['msg'];
    $createdate = $date;
    $deliverydate = $YearOn;
    $privacy = $privacyon;
    $status = 'Not Delivered';
  

    $sql = "INSERT INTO emails (email, headline, message, createdate, deliverydate, privacy, status)
			VALUES (:email, :headline, :message, :createdate, :deliverydate, :privacy, :status)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(
			':email' => $email,
			':headline' => $headline,
			':message' => $message,
			':createdate' => $createdate,
			':deliverydate' => $deliverydate,
      ':privacy' => $privacyon,
			':status' => $status));  

      $_SESSION['headline'] = $headline;
      $_SESSION['deliverydate'] = $deliverydate;

			header('Location: booked.php');
		}
	}



?>
<!DOCTYPE html>
<html>
<head>
  <title>FutureMe: Write a Letter to the Future</title>
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
    <p style="color:white;" class="logoreplace">FutureMe™</p>
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
          <a class="nav-link active" style="color:white; text-decoration: none;" href="public.php" aria-current="page" href="#">Read Public Letters</a>
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
<form method="post">
<h4>A letter from <?php echo $monthName?> <?php echo $date_d?>th, <?php echo $date_y?></h4>
<hr />
<div>
  <textarea class="form-control col-lg-offset-4" name="msg" id="exampleFormControlTextarea1" rows="6"></textarea>
  <?php

                        if ( $failure !== false ) {
                           echo('<p style="color: yellow; margin-left: 1%; text-align:centre;">'.htmlentities($failure)."</p>\n");
                        }

                        ?>
</div>
<div>
<br />
<fieldset>
  <?php if($dateselect != "yes") { ?>
  <p style="color: white; margin-left: 1%;" id="inout" >DELIVER IN</p>
  <input id="item-1" class="radio-inline__input" type="radio" name="accessible-radio" value="item-1" checked="checked"/>
  <label class="radio-inline__label" for="item-1">
      1 year
  </label>
  <input id="item-2" class="radio-inline__input" type="radio" name="accessible-radio" value="item-2"/>
  <label class="radio-inline__label" for="item-2">
      3 years
  </label>
  <input id="item-3" class="radio-inline__input" type="radio" name="accessible-radio" value="item-3"/>
  <label class="radio-inline__label" for="item-3">
      5 years
  </label>
  <?php } ?>
  <?php if($dateselect == "yes") { ?>
  <p style="color: white; margin-left: 1%;" id="inout" >DELIVER ON</p>
  <input style="margin-left: 1%;" type="date" name="begin" 
        placeholder="dd-mm-yyyy" value=""
        min="<?php echo $date; ?>" max="2030-12-31"> 
  <button style="color: white;" class="btn" name="dateselect1" type="submit">Choose duration</button>
  <?php } ?>
  <?php if($dateselect != "yes") { ?>
  <button style="color: white;" class="btn" name="dateselect" type="submit">Choose a date</button>
  <?php } ?>
</fieldset>
<br />
<fieldset>
  <p style="color: white; margin-left: 1%;">MAKE THIS LETTER</p>
  <input id="item-4" class="radio-inline__input" type="radio" name="accessible-radio1" value="item-4" checked="checked"/>
  <label class="radio-inline__label" for="item-4">
      Private
  </label>
  <input id="item-5" class="radio-inline__input" type="radio" name="accessible-radio1" value="item-5"/>
  <label class="radio-inline__label" for="item-5">
      Public, but anonymous
  </label>
</fieldset>
<br />
<p style="color: white; margin-left: 1%;">YOUR EMAIL ADDRESS</p>
<div class="form-group">
    <input style="margin-left: 1%;" class="form-control input-sm" value=" <?php if(isset($emailfetched)) {  echo htmlentities($emailfetched); } ?>" id="inputsm" name='email' type="text">
    <?php

                        if ( $failure1 !== false ) {
                           echo('<p style="color: yellow; margin-left: 1%; text-align:centre;">'.htmlentities($failure1)."</p>\n");
                        }

                        ?>
  </div>
<br />
<button class="button button2 center" style="margin-left: 1%;"name="send" type="submit">SEND TO THE FUTURE !!</button>
</div>
</div>
</form>

</body>
<br />
<br />
<footer style="text-size: 12px;" >
FutureMe™ brought to you by FutureMe Labs, LLC © 2002 - 2021. Yup - we've been sending letters to the future for about 19 years now
</footer>

</html>