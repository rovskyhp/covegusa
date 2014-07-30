<?php
// connect and login to FTP server
$ftp_server = "covegusa.info";
$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, 'facturas@covegusa.info', 'c0v3gusQ');

$local_file = "demo1.pdf";
$server_file = "factura.pdf";

// download server file
if (ftp_get($ftp_conn, $local_file, $server_file, FTP_ASCII))
  {
  echo "Successfully written to $local_file.";
  }
else
  {
  echo "Error downloading $server_file.";
  }

// close connection
ftp_close($ftp_conn);
?>