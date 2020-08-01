<?php 
if (!$_SESSION['is_logged_in']||empty($_SESSION["email"])) { 
  die(header('Location:../login.php'));
  echo ("<SCRIPT LANGUAGE='Javascript'> window.location.href='../login.php';</SCRIPT>");
}?>