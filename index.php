<?php 
session_start();

if ( !isset($_SESSION['login']) && $_SESSION['login']==false ) {
  header('Location:login.php');
}


if ( $_SESSION['role'] == 'admin' ) {
  header("Location: admin_page.php");
}

if ( $_SESSION['role'] == 'manager' ) {
  header("Location: manager_page.php");
}


if ( $_SESSION['role'] == 'user' ) {
  header("Location: user_page.php");
}