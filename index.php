
<?php
ini_set("display_errors", 1);

error_reporting(E_ALL);
// Criar conexão
header('Content-Type: text/html; charset=UTF-8');


$servername = getenv('DB_HOST');
$username   = getenv('DB_USER');
$password   = getenv('DB_PASSWORD');
$database   = getenv('DB_NAME');


$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$alunoId = rand(1, 999);
$nome = strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
$host = gethostname();

// Prepared Statement (segurança)
$stmt = $conn->prepare(
    "INSERT INTO dados (AlunoID, Nome, Sobrenome, Endereco, Cidade, Host)
     VALUES (?, ?, ?, ?, ?, ?)"
);

$stmt->bind_param(
    "isssss",
    $alunoId,
    $nome,
    $nome,
    $nome,
    $nome,
    $host
);

if ($stmt->execute()) {
    echo "Registro criado com sucesso 🚀<br>";
    echo "Servidor: " . $host;
} else {
     echo "Erro ao inserir: " . $stmt->error;
}

$stmt->close();
$conn->close();

echo "<br>Versão do PHP: " . phpversion();
