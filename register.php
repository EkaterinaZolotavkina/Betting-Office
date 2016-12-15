<?php
session_start();
if(isset($_SESSION['user'])!="")
{
	header("Location: index.php");
}
include_once 'db.php';

if(isset($_GET['notUniqueLogin'])){
?>
	<script>alert('Такой логин уже занят');</script>
<?php
}

if(isset($_GET['ne18'])){
?>
	<script>alert('Вам нет 18 лет или вы ввели неправильную дату');</script>
<?php
}

if(isset($_POST['btn-signup'])) {
	$uname = $_POST['uname'];
	$fio = $_POST['fio'];
	$date = $_POST['date'];
	$upass = md5($_POST['pass']);

	$today = date('Y-M-D');
	if (strtotime($date) > strtotime("-18 years") || ($date >= $today )) {
		header('Location: register.php?ne18');
	}
 	else {
		
		//if($db->query("INSERT INTO client (login, fio, password, birthdate) VALUES ('$uname', '$fio', '$upass', '$date')")) {
		
 		if($count = $db->exec("INSERT INTO client (login, fio, password, birthdate) VALUES ('$uname', '$fio', '$upass', '$date')"))
		//$db->exec("INSERT INTO client (login, fio, password, birthdate) VALUES ('$uname', '$fio', '$upass', '$date')") or die(print_r($db->errorInfo(), true));
			{
 		header('Location: index.php'); 
?>
 		<script>alert('Регистрация прошла успешно');</script>;
<?php 	
 	}
 	 else {
 		header('Location: register.php?notUniqueLogin');
?>
    	
<?php
	} 
}
 	} 
		
require_once ('reg/index.php');
?>