<?php
/**
 * Conexão com o banco de dados via PDO.
 * Ajuste as credenciais conforme o seu ambiente local.
 */

$host    = 'localhost';
$banco   = 'db_chamados';
$usuario = 'root';
$senha   = '';
$charset = 'utf8mb4';

$dsn = "mysql:host={$host};dbname={$banco};charset={$charset}";

$opcoes = [
    // Lança exceções em caso de erro, permitindo tratamento com try/catch
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    // Retorna os resultados como arrays associativos
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // Desativa a emulação de prepared statements (prepared statements reais no MySQL)
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $usuario, $senha, $opcoes);
} catch (PDOException $e) {
    // O detalhe do erro vai para o log do servidor, nunca para o usuário final
    error_log('Erro de conexão: ' . $e->getMessage());
    http_response_code(500);
    exit('Não foi possível conectar ao banco de dados. Tente novamente mais tarde.');
}
