<?php
include('config.php');
session_start();
$user_check=$_SESSION['login_user'];
$query ="select nombre from usuarios where user='".$user_check ."'";
$ses_sql=mysql_query($query);
$row=mysql_fetch_array($ses_sql);
$login_session=$row['nombre'];

if(!isset($login_session))
{
  header("Location: index.php");
}
?>