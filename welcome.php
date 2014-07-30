<?php
  include('lock.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>

  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/data_table.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/data_table.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/favicon.ico">
  </head>
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
            <li><a href="logout.php">Salir</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
  </div>

    <div class="container">

      <div class="starter-template">
        <h3>RFC: <?echo $rfc_session ?></h3>


<table id="example" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID factura</th>
            <th>ID Usuario</th>
            <th>Fecha</th>
            <th>Fecha de creaci&oacute;n</th>
            <th>RFC</th>
            <th>PDF</th>
            <th>XML</th>
            <th>Notas</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>ID factura</th>
            <th>ID Usuario</th>
            <th>Fecha</th>
            <th>Fecha de creaci&oacute;n</th>
            <th>RFC</th>
            <th>PDF</th>
            <th>XML</th>
            <th>Notas</th>
        </tr>
    </tfoot>

</table>
</div>

    </div><!-- /.container -->

<script>

$(document).ready(function() {
    var url= "/api/facturas/search/<?php echo $rfc_session?>"
    $('#example').dataTable( {
         "sAjaxSource": url
    } );
} );

</script>
</body>