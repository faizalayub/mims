<?php
session_start();
if($_SESSION["username"] == "" || $_SESSION["admin_login"] != true){
		header('Location: index.php');
}
?>