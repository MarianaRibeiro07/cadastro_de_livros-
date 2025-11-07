<?php
$servername = "localhost";
$username = "root";
$password = "Senai@118";
$dbname = "bibliotecaa";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Verifica se o ID foi passado na URL
if (isset($_GET['id'])) {
    // Converte o ID para número (segurança)
    $id = intval($_GET['id']);

    // Usa prepared statement (seguro contra injeção SQL)
    $stmt = $conn->prepare("DELETE FROM livro WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redireciona de volta ao index.php se deu certo
        header("Location: index.php");
        exit;
    } else {
        echo "Erro ao excluir: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID não informado!";
}

$conn->close();
?>
