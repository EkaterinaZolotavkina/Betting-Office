<?php
session_start();
include_once 'db.php';

if(isset($_SESSION['user'])!=""){
	header("Location: index.php");
}

if(isset($_POST['btn-login'])){
	$uname = $_POST['uname'];
	$upass = $_POST['pass'];
	$sql="SELECT * FROM client WHERE login = '$uname'";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$res = $stmt->fetch(PDO::FETCH_ASSOC);
	if($res['password']== (md5($upass))){
 		$_SESSION['user'] = $res['client_id'];
		header("Location: index.php");
	}
	else{
?>
    	<script>alert('wrong details');</script>
		
<?php
	}
}
require_once('reg/index_login.php');
?>