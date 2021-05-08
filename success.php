<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


$Correo = new PHPMailer();
  $Correo->IsSMTP();
  $Correo->SMTPAuth = true;
  $Correo->SMTPSecure = "tls";
  $Correo->Host = "smtp.gmail.com";
  $Correo->Port = 587;
  $Correo->Username = "GMAIL ID";  //Enter your gmail id
  $Correo->Password = "PASSWORD";               //Enter you gmail password
  $Correo->SetFrom('enter from');       //Enter from 
  $Correo->FromName = "no-reply";
  $Correo->AddAddress($_SESSION['mail']);
  $Correo->Subject = "Covid donation receipt";
  $Correo->Body = "<H3>Congratulations! You have successfully donated ₹".$_SESSION['amount']." for covid relief in India.</H3>";
  $Correo->IsHTML (true);
  if (!$Correo->Send())
  {
    echo "Error: $Correo->ErrorInfo";
  }
  else
  {
    echo "<div>A payment confirmation receipt has been sent to ".$_SESSION['mail']."</div>";
    
  }



?>
<html>
<head>
  <title>Thanks for your donation!</title>
  <link rel="stylesheet" href="style.css">
  <style type="text/css">
  	div{
  		margin:auto;
  	}
  	body{
  		background-color: #e3fae8;
  	}
  </style>
</head>
<body>
</body>
</html>