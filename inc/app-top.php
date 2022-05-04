<?php
session_start();
if($_SESSION["username"] == "" || $_SESSION["user_login"] != true){
		header('Location: index.php');
}
?>