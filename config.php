<?php
$mysql_hostname = "127.0.0.1";
$mysql_user = "root";
$mysql_password = "root";
$mysql_database = "covegusa_db";
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password)
or die("Opps some thing went wrong");
mysql_select_db($mysql_database, $bd) or die("Opps some thing went wrong");
?>