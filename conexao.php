<?php
ob_start();
$host = "mysql-wasabido.alwaysdata.net"; 
$dbname = "wasabido_a";          
$user = "wasabido";         
$password = "2008wasabido@"; // Coloque aqui a senha que você usa para entrar na Alwaysdata

try {
    $conexao = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>
