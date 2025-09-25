<?php
require 'db.php';
if(empty($_SESSION['user'])) {
  header("Location: login.php"); 
  exit;
}
$user = $_SESSION['user'];

