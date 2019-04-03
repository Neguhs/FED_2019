<?php
try {
  $username = 'jmalik2';
  $password = 'Jm0885175';
  $connection = new PDO( 'mysql:host=mysql.yaacotu.com;dbname=fed_db_justin', $username, $password );
}
catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>