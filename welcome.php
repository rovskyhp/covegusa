<!DOCTYPE html>
<html lang="en">
  <head> 

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <?php
  include('lock.php');
  ?>
<style>
body {
  padding-top: 50px;
}
.starter-template {
  padding: 40px 15px;
  text-align: center;
}
</style>
<body>

  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">

        <div class="navbar-header">
          <span class="navbar-brand">Bienvenido: <?php echo $login_session; ?></span>
        </div>
        <div class="collapse navbar-collapse">
          
          <ul class="nav navbar-nav" style="float:right">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="logout.php">Salir</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
  </div>
 
    <div class="container">

      <div class="starter-template">
        <h1>Informaci&oacute;n del Usuario</h1>
        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      </div>

    </div><!-- /.container -->

</body>