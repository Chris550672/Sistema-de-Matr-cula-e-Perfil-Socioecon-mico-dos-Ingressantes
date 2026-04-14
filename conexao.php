<?php
require_once 'config.php';

$conexao = new mysqli(HOST, USUARIO, SENHA, DB);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// definindo o padrão de caracteres para não dar erro em acentos
$conexao->set_charset("utf8mb4");
?>