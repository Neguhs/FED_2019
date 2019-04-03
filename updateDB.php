<?php
session_start();
include_once("connect.php");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Connect to Inventory</title>
  <style>.error {color: #C00;}</style>
</head>

<body>

<?php
if (!isset($_POST["upc"])) { // first time on page
  if (strcmp ($_SESSION["where"], "usda") == 0) { // upc found in usda
    echo "NOTE: This item was NOT found in the local database.  It has been added with an initial quantity of zero.<br><br>";

    $sql = "INSERT INTO `fedInventory`(`UPC`, `DESCRIPTION`, `QUANTITY`) VALUES (".$_SESSION["upc"].",\"".$_SESSION['desc']."\",0);";
    mysqli_query($mysqli, $sql);
  }
  if (strcmp ($_SESSION["where"], "") == 0) { // upc not found
    echo ("Item found in neither the local database nor the USDA database.<br><br>");
  }
}
else {  // loading page after form below submitted, so update quantity
  $sql = 'UPDATE `fedInventory` SET `QUANTITY`='.$_SESSION["qty"].'+'.$_POST["adj_qty"].' '.'WHERE UPC ='.$_SESSION["upc"];   
  echo $sql;                           
  mysqli_query($mysqli, $sql);
  $_SESSION["qty"] += $_POST["adj_qty"];
}

if (strcmp ($_SESSION["where"], "") != 0) { // upc found
  $upc = $_SESSION["upc"];
  $desc = $_SESSION["desc"]; 
  $qty = $_SESSION["qty"];

  $display_msg = <<<EOT
  <form action='updateDB.php' method='post'>
    <table>
      <tr>
        <td align='right'>upc:</td>
        <td align='left'>{$upc}</td></tr>
      <tr>
        <td align='right'>description:</td>
        <td align='left'>{$desc}</td></tr>
      <tr>
        <td align='right'>in stock:</td>
        <td align='left'>{$qty}</td></tr>
      <tr>
        <td align='right'>add:</td>
        <td align='left'><input name='adj_qty' type='number'> (enter negative to remove)</td></tr>
      <tr>
        <td align='right'>&nbsp;</td>
        <td align='left'><input type='submit'></td></tr>
    </table>
    <input type='hidden' name='upc' value='{$upc}'>
  </form><br><br><br>
EOT;
  echo $display_msg;
}
?>

<form action='index.php'>
  <input type='submit' value='done updating this item'>
</form>
</body>
</html>
