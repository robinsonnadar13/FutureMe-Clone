<?php

session_start();
error_reporting(0);
$deliverydate = $_SESSION['deliverydate'];
$headline = $_SESSION['headline'];

?>

<!doctype html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>FutureMe: Write a Letter to the Future</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel = "icon" href = "Images/fm-logo.png" type = "image/x-icon"> 

  <style>

  body{margin:0;padding:0;font-family:sans-serif;background:#f6f7f7}

.text-center{text-align:center}

.main{min-height:calc(100vh - 160px); margin:0 auto;max-width:600px;display:-webkit-box;display:-moz-box;display:-ms-flexbox;display:-webkit-flex;display:flex;align-items:center;justify-content:center}

.logo{padding:10px 0 5px;text-align:center}

.header{margin-bottom:10px}

.setting-wrap{text-align:center}

h1{font-size:26px}

.footer{padding:20px;color:brown;}

@media all and (max-width: 480px) {

.languageSwicher{margin-top:7px}

}

.title{

    font-variant: small-caps;

     text-align: center;

     font: 400 50px/1.3 'Berkshire Swash', Helvetica, sans-serif;

     color: #2b2b2b;

     text-shadow: 1px 1px 0px #ededed, 4px 4px 0px rgba(0,0,0,0.15);

}

  </style>

</head>

<body>
    <div>
        <div class="header col-xs-12" style="background-color: #9400D3;">
            <div class="col-xs-2 "></div>
            <div class="col-xs-8 text-center logo">
                <h1 class="title">FutureMe™</h1>
            </div>
        </div>
        <br />
        <br />
        <div class="text-center">
        <div>
        <h1>Successfully registered!!!</h1>
        <p>Your letter "<?php echo $headline; ?>" will be delivered in the future on "<?php echo $deliverydate; ?>" !"</p>
        </div>
        <button class="button button2 center" style="margin: auto;" href="index.php">GO BACK AND SEND ANOTHER !!</button>
        <br /> 
    </div>

</body>

</html>