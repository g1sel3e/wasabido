conexao.php
<?php

	$host = "localhost";
	$banco = "wasabido_a";
	$user = "root";
	$pass = "";

	$conexao = new PDO("mysql:host=$host; dbname=$banco",$user,$pass);

	
?>
