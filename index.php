<?php
include("config.php");
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST")
{
// username and password sent from Form 
$myusername=addslashes($_POST['username']); 
$mypassword=addslashes($_POST['password']); 

$sql="SELECT id FROM usuarios WHERE user='$myusername' and pass='$mypassword'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$count=mysql_num_rows($result);


// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1)
{
$_SESSION['login_user']=$myusername;
header("location: welcome.php");
}
else 
{
$error="Your Login Name or Password is invalid";
}
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Inicio</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/singin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <div class="container">

      <form class="form-signin" role="form" method="post">
        <h2 class="form-signin-heading">Ingresar</h2>
        <input type="text" class="form-control"  name="username"placeholder="Usuario" required autofocus>
        <input type="password" class="form-control"  name="password" placeholder="Password" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>

